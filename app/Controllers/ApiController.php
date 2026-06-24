<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class ApiController extends BaseController
{
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Set CORS headers
        $this->response->setHeader("Access-Control-Allow-Origin", "*");
        $this->response->setHeader("Access-Control-Allow-Methods", "GET, POST, OPTIONS");
        $this->response->setHeader("Access-Control-Allow-Headers", "Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Handle preflight OPTIONS request
        if ($this->request->getMethod() === 'options') {
            $this->response->setStatusCode(200)->send();
            exit();
        }
    }
    private function getDb()
    {
        require_once ROOTPATH . 'config.php';
        $db = getDbConnection();
        // Run migration helper for alumnos.correo
        try { 
            @$db->exec("ALTER TABLE alumnos ADD COLUMN correo VARCHAR(255) DEFAULT ''"); 
        } catch (\PDOException $e) {}
        return $db;
    }

    public function authLogin()
    {
        try {
            $db = $this->getDb();
            $input = $this->request->getJSON(true) ?: [];

            $email = trim($input['email'] ?? '');
            $password = trim($input['password'] ?? '');

            if (empty($email) || empty($password)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Email y contraseña son requeridos.'
                ])->setStatusCode(400);
            }

            $stmt = $db->prepare("SELECT id_usuario, nombre_completo, email, password_hash, rol FROM usuarios WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && $user['password_hash'] === $password) {
                return $this->response->setJSON([
                    'success' => true,
                    'user' => [
                        'id_usuario' => intval($user['id_usuario']),
                        'nombre_completo' => $user['nombre_completo'],
                        'email' => $user['email'],
                        'rol' => $user['rol']
                    ]
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Credenciales incorrectas.'
                ])->setStatusCode(401);
            }
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Exception: ' . $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ])->setStatusCode(500);
        }
    }

    public function getStudents()
    {
        $db = $this->getDb();
        $evaluadorId = $this->request->getGet('evaluador_id') !== null ? intval($this->request->getGet('evaluador_id')) : 1;

        $stmt = $db->prepare("SELECT id_alumno, matricula, nombre_completo, semestre_grupo, correo FROM alumnos WHERE id_docente = ?");
        $stmt->execute([$evaluadorId]);
        $students = $stmt->fetchAll();

        return $this->response->setJSON($students);
    }

    public function syncStudents()
    {
        $db = $this->getDb();
        $input = $this->request->getJSON(true);

        if (!is_array($input)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'El cuerpo de la solicitud debe ser un arreglo JSON de alumnos.'
            ])->setStatusCode(400);
        }

        $synced = [];
        $db->beginTransaction();

        try {
            foreach ($input as $alRaw) {
                $matricula = trim($alRaw['matricula'] ?? '');
                $nombre = trim($alRaw['nombre_completo'] ?? '');
                $semestre = trim($alRaw['semestre_grupo'] ?? '');
                $correo = trim($alRaw['correo'] ?? '');
                $docenteId = intval($alRaw['id_docente'] ?? 1);

                if (empty($matricula) || empty($nombre)) {
                    continue; // Skip invalid
                }

                // Check duplicate by matricula
                $stmtCheck = $db->prepare("SELECT id_alumno FROM alumnos WHERE matricula = ?");
                $stmtCheck->execute([$matricula]);
                if ($stmtCheck->rowCount() > 0) {
                    $idAlumno = intval($stmtCheck->fetchColumn());
                    // Update email if changed or set
                    $stmtUpdate = $db->prepare("UPDATE alumnos SET correo = ? WHERE id_alumno = ?");
                    $stmtUpdate->execute([$correo, $idAlumno]);
                } else {
                    $stmtInsert = $db->prepare("INSERT INTO alumnos (matricula, nombre_completo, semestre_grupo, correo, id_docente) VALUES (?, ?, ?, ?, ?)");
                    $stmtInsert->execute([$matricula, $nombre, $semestre, $correo, $docenteId]);
                    $idAlumno = intval($db->lastInsertId());
                }

                $synced[] = [
                    'matricula' => $matricula,
                    'id_alumno' => $idAlumno
                ];
            }

            $db->commit();
            return $this->response->setJSON([
                'success' => true,
                'synced' => $synced
            ]);

        } catch (\Exception $ex) {
            $db->rollBack();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al sincronizar alumnos: ' . $ex->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function syncEvaluations()
    {
        $db = $this->getDb();
        $evaluations = $this->request->getJSON(true);

        if (!is_array($evaluations)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'El cuerpo de la solicitud debe ser un arreglo JSON de evaluaciones.',
                'syncedUuids' => []
            ])->setStatusCode(400);
        }

        $syncedUuids = [];
        $newlySyncedEvaluations = [];
        $db->beginTransaction(); // Start atomic transaction

        try {
            foreach ($evaluations as $item) {
                if (!isset($item['evaluation']) || !isset($item['evaluation']['uuid'])) {
                    continue; // Skip invalid items
                }

                $evalRaw = $item['evaluation'];
                $detailsRaw = $item['details'] ?? [];
                $uuid = $evalRaw['uuid'];

                // 1. Idempotency Check: Verify if uuid already exists
                $stmtCheck = $db->prepare("SELECT id_evaluacion FROM evaluaciones WHERE uuid = ?");
                $stmtCheck->execute([$uuid]);
                if ($stmtCheck->rowCount() > 0) {
                    // If it already exists, add to synced lists so client knows it was handled
                    $syncedUuids[] = $uuid;
                    continue;
                }

                // 2. Map data fields (Kotlin camelCase -> MySQL snake_case)
                $fechaEvaluacion = isset($evalRaw['fechaEvaluacion']) 
                    ? date('Y-m-d', intval($evalRaw['fechaEvaluacion'] / 1000)) 
                    : date('Y-m-d');

                $evalQuery = "INSERT INTO evaluaciones (
                    uuid, id_evaluador, id_alumno, fecha_evaluacion, entorno_clinico, 
                    tipo_paciente, asunto_principal, complejidad, tiempo_observacion, 
                    tiempo_feedback, calificacion_total, firma_evaluador, firma_alumno, is_synced
                ) VALUES (
                    ?, ?, ?, ?, ?, 
                    ?, ?, ?, ?, 
                    ?, ?, ?, ?, 1
                )";

                $stmtEval = $db->prepare($evalQuery);
                $stmtEval->execute([
                    $uuid,
                    intval($evalRaw['idEvaluador'] ?? 1),
                    intval($evalRaw['idAlumno'] ?? 1),
                    $fechaEvaluacion,
                    $evalRaw['entornoClinico'] ?? 'Consulta MF',
                    $evalRaw['tipoPaciente'] ?? 'Nuevo',
                    $evalRaw['asuntoPrincipal'] ?? '',
                    $evalRaw['complejidad'] ?? 'Media',
                    intval($evalRaw['tiempoObservacion'] ?? 0),
                    intval($evalRaw['tiempoFeedback'] ?? 0),
                    floatval($evalRaw['calificacionTotal'] ?? 0.0),
                    $evalRaw['firmaEvaluador'] ?? null,
                    $evalRaw['firmaAlumno'] ?? null
                ]);

                $newEvalId = $db->lastInsertId();

                // Insert rubric details
                if (is_array($detailsRaw)) {
                    $detailsQuery = "INSERT INTO detalles_rubrica (
                        id_evaluacion, competencia, puntaje, notas, a_destacar, a_mejorar
                    ) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmtDetails = $db->prepare($detailsQuery);
                    foreach ($detailsRaw as $detail) {
                        $stmtDetails->execute([
                            $newEvalId,
                            $detail['competencia'] ?? '',
                            intval($detail['puntaje'] ?? 0),
                            $detail['notas'] ?? '',
                            $detail['aDestacar'] ?? '',
                            $detail['aMejorar'] ?? ''
                        ]);
                    }
                }

                $newlySyncedEvaluations[] = [
                    'id_evaluacion' => $newEvalId,
                    'asunto_principal' => $evalRaw['asuntoPrincipal'] ?? '',
                    'calificacion_total' => floatval($evalRaw['calificacionTotal'] ?? 0.0),
                    'id_alumno' => intval($evalRaw['idAlumno'] ?? 1)
                ];

                $syncedUuids[] = $uuid;
            }

            $db->commit(); // Commit all inserts atomically

        } catch (\Exception $ex) {
            $db->rollBack();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al guardar evaluaciones: ' . $ex->getMessage(),
                'syncedUuids' => $syncedUuids
            ])->setStatusCode(500);
        }

        // Send notification emails after successful commit
        require_once ROOTPATH . 'api/pdf_generator.php';
        require_once ROOTPATH . 'includes/email_sender.php';
        
        foreach ($newlySyncedEvaluations as $newEv) {
            // Fetch student info
            $stmtAl = $db->prepare("SELECT nombre_completo, correo FROM alumnos WHERE id_alumno = ?");
            $stmtAl->execute([$newEv['id_alumno']]);
            $alumnoInfo = $stmtAl->fetch(\PDO::FETCH_ASSOC);
            
            if ($alumnoInfo && !empty($alumnoInfo['correo'])) {
                // Fetch student average
                $stmtAvg = $db->prepare("SELECT AVG(calificacion_total) FROM evaluaciones WHERE id_alumno = ?");
                $stmtAvg->execute([$newEv['id_alumno']]);
                $promedio = floatval($stmtAvg->fetchColumn());
                
                // Generate PDF report
                $pdfContent = generateEvaluationPdf($db, $newEv['id_evaluacion']);
                
                // Send email
                if (!empty($pdfContent)) {
                    sendEvaluationEmail(
                        $alumnoInfo['correo'],
                        $alumnoInfo['nombre_completo'],
                        $promedio,
                        $pdfContent,
                        $newEv['asunto_principal'],
                        $newEv['calificacion_total']
                    );
                }
            }
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Sincronización completada con éxito.',
            'syncedUuids' => $syncedUuids
        ]);
    }

    public function getEvaluations()
    {
        $db = $this->getDb();
        $evaluadorId = $this->request->getGet('evaluador_id') !== null ? intval($this->request->getGet('evaluador_id')) : 1;

        $stmt = $db->prepare("SELECT * FROM evaluaciones WHERE id_evaluador = ?");
        $stmt->execute([$evaluadorId]);
        $evaluations = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $result = [];
        foreach ($evaluations as $eval) {
            $stmtDetails = $db->prepare("SELECT * FROM detalles_rubrica WHERE id_evaluacion = ?");
            $stmtDetails->execute([$eval['id_evaluacion']]);
            $details = $stmtDetails->fetchAll(\PDO::FETCH_ASSOC);

            $evalDto = [
                'idEvaluacion' => intval($eval['id_evaluacion']),
                'uuid' => $eval['uuid'],
                'idEvaluador' => intval($eval['id_evaluador']),
                'idAlumno' => intval($eval['id_alumno']),
                'fechaEvaluacion' => strtotime($eval['fecha_evaluacion']) * 1000,
                'entornoClinico' => $eval['entorno_clinico'],
                'tipoPaciente' => $eval['tipo_paciente'],
                'asuntoPrincipal' => $eval['asunto_principal'],
                'complejidad' => $eval['complejidad'],
                'tiempoObservacion' => intval($eval['tiempo_observacion']),
                'tiempoFeedback' => intval($eval['tiempo_feedback']),
                'calificacionTotal' => floatval($eval['calificacion_total']),
                'firmaEvaluador' => $eval['firma_evaluador'],
                'firmaAlumno' => $eval['firma_alumno'],
                'isSynced' => true,
                'createdAt' => strtotime($eval['created_at']) * 1000
            ];

            $detailsDto = [];
            foreach ($details as $detail) {
                $detailsDto[] = [
                    'idDetalle' => intval($detail['id_detalle']),
                    'idEvaluacion' => intval($detail['id_evaluacion']),
                    'competencia' => $detail['competencia'],
                    'puntaje' => intval($detail['puntaje']),
                    'notas' => $detail['notas'],
                    'aDestacar' => $detail['a_destacar'],
                    'aMejorar' => $detail['a_mejorar']
                ];
            }

            $result[] = [
                'evaluation' => $evalDto,
                'details' => $detailsDto
            ];
        }

        return $this->response->setJSON($result);
    }

    public function processQueue()
    {
        $db = $this->getDb();
        $evaluadorId = $this->request->getGet('evaluador_id') !== null ? intval($this->request->getGet('evaluador_id')) : 1;
        $queue = $this->request->getJSON(true) ?: [];

        $processedIds = [];
        $serverActions = [];
        $localToServerStudentIds = []; // Map from App's local idAlumno to Server's id_alumno

        // Verificar inmediatamente si el usuario existe. Si no, retornar acción de borrado y abortar.
        $stmtUserCheck = $db->prepare("SELECT COUNT(*) FROM usuarios WHERE id_usuario = ?");
        $stmtUserCheck->execute([$evaluadorId]);
        if ($stmtUserCheck->fetchColumn() == 0) {
            return $this->response->setJSON([
                'success' => true,
                'processedIds' => [],
                'serverActions' => [[
                    'action' => 'delete',
                    'tableName' => 'usuarios',
                    'entityUuid' => '',
                    'dataPayload' => '{}',
                    'timestamp' => time() * 1000
                ]]
            ]);
        }

        $db->beginTransaction();

        try {
            // 1. Procesar la cola de entrada (App -> Server)
            foreach ($queue as $item) {
                if (!isset($item['action']) || !isset($item['tableName']) || !isset($item['entityUuid'])) continue;
                
                $action = $item['action'];
                $table = $item['tableName'];
                $uuid = $item['entityUuid'];
                $dataPayloadStr = $item['dataPayload'] ?? '{}';
                $payload = json_decode($dataPayloadStr, true) ?: [];

                // Almacenar en la tabla sync_queue para mantener un historial y permitir que otros dispositivos (si los hay) la descarguen.
                // Aunque en Minicex el maestro es 1-1 con su dispositivo, es útil para recuperar sesión.
                $stmtLog = $db->prepare("INSERT INTO sync_queue (user_id, action, table_name, entity_uuid, data_payload) VALUES (?, ?, ?, ?, ?)");
                $stmtLog->execute([$evaluadorId, $action, $table, $uuid, $dataPayloadStr]);
                
                if ($table === 'alumnos') {
                    if ($action === 'insert' || $action === 'update') {
                        $matricula = $payload['matricula'] ?? '';
                        $nombre = $payload['nombreCompleto'] ?? '';
                        $semestre = $payload['semestreGrupo'] ?? '';
                        $correo = $payload['correo'] ?? '';
                        $localAppId = $payload['idAlumno'] ?? 0;
                        
                        $stmtCheck = $db->prepare("SELECT id_alumno FROM alumnos WHERE uuid = ? OR matricula = ?");
                        $stmtCheck->execute([$uuid, $matricula]);
                        $existing = $stmtCheck->fetch();
                        
                        if ($existing) {
                            $stmtUpdate = $db->prepare("UPDATE alumnos SET nombre_completo=?, semestre_grupo=?, correo=?, uuid=? WHERE id_alumno=?");
                            $stmtUpdate->execute([$nombre, $semestre, $correo, $uuid, $existing['id_alumno']]);
                            if ($localAppId) $localToServerStudentIds[$localAppId] = $existing['id_alumno'];
                        } else {
                            $stmtInsert = $db->prepare("INSERT INTO alumnos (uuid, matricula, nombre_completo, semestre_grupo, correo, id_docente) VALUES (?, ?, ?, ?, ?, ?)");
                            $stmtInsert->execute([$uuid, $matricula, $nombre, $semestre, $correo, $evaluadorId]);
                            if ($localAppId) $localToServerStudentIds[$localAppId] = $db->lastInsertId();
                        }
                    } else if ($action === 'delete') {
                        $stmtDel = $db->prepare("DELETE FROM alumnos WHERE uuid = ?");
                        $stmtDel->execute([$uuid]);
                    }
                } else if ($table === 'evaluaciones') {
                    if ($action === 'insert' || $action === 'update') {
                        $eval = $payload['evaluation'] ?? [];
                        $details = $payload['details'] ?? [];
                        
                        $stmtCheck = $db->prepare("SELECT id_evaluacion FROM evaluaciones WHERE uuid = ?");
                        $stmtCheck->execute([$uuid]);
                        $existing = $stmtCheck->fetch();
                        
                        $fechaEvaluacion = isset($eval['fechaEvaluacion']) ? date('Y-m-d', intval($eval['fechaEvaluacion'] / 1000)) : date('Y-m-d');
                        
                        // Find local student ID
                        $studentUuid = $eval['uuid_alumno'] ?? ''; 
                        $appStudentId = $eval['idAlumno'] ?? 0;
                        
                        if (isset($localToServerStudentIds[$appStudentId])) {
                            $alId = $localToServerStudentIds[$appStudentId];
                        } else {
                            $stmtFindAl = $db->prepare("SELECT id_alumno FROM alumnos WHERE uuid = ? OR matricula = ? OR id_alumno = ?");
                            $stmtFindAl->execute([$studentUuid, "TEMP", $appStudentId]);
                            $alId = $stmtFindAl->fetchColumn() ?: 1;
                        }

                        if (!$existing) {
                            $stmtEval = $db->prepare("INSERT INTO evaluaciones (uuid, id_evaluador, id_alumno, fecha_evaluacion, entorno_clinico, tipo_paciente, asunto_principal, complejidad, tiempo_observacion, tiempo_feedback, calificacion_total, firma_evaluador, firma_alumno, is_synced) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
                            $stmtEval->execute([
                                $uuid, $evaluadorId, $alId, $fechaEvaluacion, 
                                $eval['entornoClinico'] ?? '', $eval['tipoPaciente'] ?? '', $eval['asuntoPrincipal'] ?? '',
                                $eval['complejidad'] ?? '', intval($eval['tiempoObservacion'] ?? 0), intval($eval['tiempoFeedback'] ?? 0),
                                floatval($eval['calificacionTotal'] ?? 0), $eval['firmaEvaluador'] ?? null, $eval['firmaAlumno'] ?? null
                            ]);
                            $newId = $db->lastInsertId();
                            
                            if (is_array($details)) {
                                $stmtDet = $db->prepare("INSERT INTO detalles_rubrica (id_evaluacion, competencia, puntaje, notas, a_destacar, a_mejorar) VALUES (?, ?, ?, ?, ?, ?)");
                                foreach ($details as $det) {
                                    $stmtDet->execute([$newId, $det['competencia'] ?? '', intval($det['puntaje'] ?? 0), $det['notas'] ?? '', $det['aDestacar'] ?? '', $det['aMejorar'] ?? '']);
                                }
                            }
                        }
                    }
                }
            }
            
            $db->commit();
        } catch (\Exception $ex) {
            $db->rollBack();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al procesar la cola: ' . $ex->getMessage()
            ])->setStatusCode(500);
        }

        // 2. Extraer acciones del servidor (Server -> App) 
        // Enviar todos los usuarios para que la app pueda permitir login offline de cualquier maestro
        try {
            $stmtAllUsers = $db->prepare("SELECT * FROM usuarios");
            $stmtAllUsers->execute();
            $allUsers = $stmtAllUsers->fetchAll(\PDO::FETCH_ASSOC);

            $currentUserFound = false;

            foreach ($allUsers as $u) {
                if ($u['id_usuario'] == $evaluadorId) {
                    $currentUserFound = true;
                }
                $serverActions[] = [
                    'action' => 'update',
                    'tableName' => 'usuarios',
                    'entityUuid' => '',
                    'dataPayload' => json_encode([
                        'id_usuario' => intval($u['id_usuario']),
                        'nombre_completo' => $u['nombre_completo'],
                        'email' => $u['email'],
                        'rol' => $u['rol'],
                        'password_hash' => $u['password_hash']
                    ]),
                    'timestamp' => time() * 1000
                ];
            }

            if (!$currentUserFound) {
                // Usuario logueado actual eliminado en el backend. Mandar acción especial de borrado para cerrar sesión.
                $serverActions[] = [
                    'action' => 'delete',
                    'tableName' => 'usuarios',
                    'entityUuid' => '',
                    'dataPayload' => '{}',
                    'timestamp' => time() * 1000
                ];
            }

            $stmt = $db->prepare("SELECT id_alumno, uuid, matricula, nombre_completo, semestre_grupo, correo, id_docente FROM alumnos WHERE id_docente = ?");
            $stmt->execute([$evaluadorId]);
            $students = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            foreach ($students as $st) {
                // Generar action de update implícita para sincronizar a la app
                $serverActions[] = [
                    'action' => 'update',
                    'tableName' => 'alumnos',
                    'entityUuid' => $st['uuid'] ?: '',
                    'dataPayload' => json_encode([
                        'idAlumno' => intval($st['id_alumno']),
                        'uuid' => $st['uuid'] ?: '',
                        'matricula' => $st['matricula'],
                        'nombreCompleto' => $st['nombre_completo'],
                        'semestreGrupo' => $st['semestre_grupo'],
                        'correo' => $st['correo'],
                        'idDocente' => intval($st['id_docente'])
                    ]),
                    'timestamp' => time() * 1000
                ];
            }
        } catch (\Exception $e) {}

        // También enviar las evaluaciones existentes para que la app las recupere si fue reinstalada
        try {
            $stmtEvals = $db->prepare("SELECT e.*, a.matricula as student_matricula FROM evaluaciones e LEFT JOIN alumnos a ON e.id_alumno = a.id_alumno WHERE e.id_evaluador = ?");
            $stmtEvals->execute([$evaluadorId]);
            $evals = $stmtEvals->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($evals as $eval) {
                $stmtDetails = $db->prepare("SELECT * FROM detalles_rubrica WHERE id_evaluacion = ?");
                $stmtDetails->execute([$eval['id_evaluacion']]);
                $details = $stmtDetails->fetchAll(\PDO::FETCH_ASSOC);

                $evalDto = [
                    'idEvaluacion' => intval($eval['id_evaluacion']),
                    'uuid' => $eval['uuid'],
                    'idEvaluador' => intval($eval['id_evaluador']),
                    'idAlumno' => intval($eval['id_alumno']),
                    'studentMatricula' => $eval['student_matricula'] ?? '',
                    'fechaEvaluacion' => strtotime($eval['fecha_evaluacion']) * 1000,
                    'entornoClinico' => $eval['entorno_clinico'],
                    'tipoPaciente' => $eval['tipo_paciente'],
                    'asuntoPrincipal' => $eval['asunto_principal'],
                    'complejidad' => $eval['complejidad'],
                    'tiempoObservacion' => intval($eval['tiempo_observacion']),
                    'tiempoFeedback' => intval($eval['tiempo_feedback']),
                    'calificacionTotal' => floatval($eval['calificacion_total']),
                    'firmaEvaluador' => $eval['firma_evaluador'],
                    'firmaAlumno' => $eval['firma_alumno'],
                    'isSynced' => true,
                    'createdAt' => strtotime($eval['created_at']) * 1000
                ];

                $detailsDto = [];
                foreach ($details as $detail) {
                    $detailsDto[] = [
                        'idDetalle' => intval($detail['id_detalle']),
                        'idEvaluacion' => intval($detail['id_evaluacion']),
                        'competencia' => $detail['competencia'],
                        'puntaje' => intval($detail['puntaje']),
                        'notas' => $detail['notas'],
                        'aDestacar' => $detail['a_destacar'],
                        'aMejorar' => $detail['a_mejorar']
                    ];
                }

                $serverActions[] = [
                    'action' => 'update',
                    'tableName' => 'evaluaciones',
                    'entityUuid' => $eval['uuid'] ?: '',
                    'dataPayload' => json_encode([
                        'evaluation' => $evalDto,
                        'details' => $detailsDto
                    ]),
                    'timestamp' => time() * 1000
                ];
            }
        } catch (\Exception $e) {}

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cola procesada correctamente',
            'processedIds' => [], // Local app assumes all sent were processed
            'serverActions' => $serverActions
        ]);
    }

    public function resendEmail()
    {
        $db = $this->getDb();
        $input = $this->request->getJSON(true) ?: [];
        $uuid = trim($input['uuid'] ?? '');

        if (empty($uuid)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'El UUID de la evaluación es requerido.'
            ])->setStatusCode(400);
        }

        $stmt = $db->prepare("SELECT id_evaluacion, id_alumno, asunto_principal, calificacion_total FROM evaluaciones WHERE uuid = ?");
        $stmt->execute([$uuid]);
        $ev = $stmt->fetch();

        if ($ev) {
            $id = intval($ev['id_evaluacion']);
            
            // Fetch student info
            $stmtAl = $db->prepare("SELECT nombre_completo, correo FROM alumnos WHERE id_alumno = ?");
            $stmtAl->execute([$ev['id_alumno']]);
            $alumnoInfo = $stmtAl->fetch(\PDO::FETCH_ASSOC);

            if ($alumnoInfo && !empty($alumnoInfo['correo'])) {
                $stmtAvg = $db->prepare("SELECT AVG(calificacion_total) FROM evaluaciones WHERE id_alumno = ?");
                $stmtAvg->execute([$ev['id_alumno']]);
                $promedio = floatval($stmtAvg->fetchColumn());

                require_once ROOTPATH . 'api/pdf_generator.php';
                $pdfContent = generateEvaluationPdf($db, $id);

                if (!empty($pdfContent)) {
                    require_once ROOTPATH . 'includes/email_sender.php';
                    $sent = sendEvaluationEmail(
                        $alumnoInfo['correo'],
                        $alumnoInfo['nombre_completo'],
                        $promedio,
                        $pdfContent,
                        $ev['asunto_principal'],
                        $ev['calificacion_total']
                    );
                    if ($sent) {
                        return $this->response->setJSON([
                            'success' => true,
                            'message' => 'Correo reenviado con éxito.'
                        ]);
                    } else {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Error SMTP al reenviar el correo. Verifica los logs del servidor.'
                        ])->setStatusCode(500);
                    }
                } else {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'No se pudo generar el reporte PDF para el envío.'
                    ])->setStatusCode(500);
                }
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'El alumno no tiene un correo electrónico registrado.'
                ])->setStatusCode(400);
            }
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Evaluación no encontrada localmente en el servidor.'
            ])->setStatusCode(404);
        }
    }
}

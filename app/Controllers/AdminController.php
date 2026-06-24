<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function index()
    {
        $session = session();
        $isLoggedIn = $session->get('admin_logged_in') === true;

        if (!$isLoggedIn) {
            return view('admin/login');
        }

        // Fetch data using getDbConnection()
        require_once ROOTPATH . 'config.php';
        $db = getDbConnection();

        // Run migration helper for alumnos.correo
        try { 
            @$db->exec("ALTER TABLE alumnos ADD COLUMN correo VARCHAR(255) DEFAULT ''"); 
        } catch (\PDOException $e) {}

        try {
            $statDocentes     = $db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
            $statAlumnos      = $db->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
            $statEvaluaciones = $db->query("SELECT COUNT(*) FROM evaluaciones")->fetchColumn();
            $statPromedio     = $db->query("SELECT AVG(calificacion_total) FROM evaluaciones")->fetchColumn();
            $statPromedio     = $statPromedio ? number_format($statPromedio, 2) : '0.00';

            $docentes = $db->query("SELECT * FROM usuarios ORDER BY id_usuario DESC")->fetchAll();
            $alumnos  = $db->query("SELECT a.*,u.nombre_completo AS docente_nombre FROM alumnos a LEFT JOIN usuarios u ON a.id_docente=u.id_usuario ORDER BY a.id_alumno DESC")->fetchAll();
            $evaluaciones = $db->query("SELECT e.*,u.nombre_completo AS evaluador_nombre,a.nombre_completo AS alumno_nombre,a.matricula AS alumno_matricula FROM evaluaciones e LEFT JOIN usuarios u ON e.id_evaluador=u.id_usuario LEFT JOIN alumnos a ON e.id_alumno=a.id_alumno ORDER BY e.id_evaluacion DESC")->fetchAll();

            $data = [
                'statDocentes'     => $statDocentes,
                'statAlumnos'      => $statAlumnos,
                'statEvaluaciones' => $statEvaluaciones,
                'statPromedio'     => $statPromedio,
                'docentes'         => $docentes,
                'alumnos'          => $alumnos,
                'evaluaciones'     => $evaluaciones,
            ];
        } catch (\Exception $e) {
            die("Error de datos: " . $e->getMessage());
        }

        return view('admin/dashboard', $data);
    }

    public function login()
    {
        $json = $this->request->getJSON(true) ?: [];
        $username = trim($json['username'] ?? '');
        $password = trim($json['password'] ?? '');

        $success = false;
        if ($username === 'admin' && $password === 'Retsab21ACA*') {
            $session = session();
            $session->set('admin_logged_in', true);
            $success = true;
        }

        return $this->response->setJSON([
            'success' => $success,
            'message' => $success ? 'Acceso concedido. Redirigiendo...' : 'Usuario o contraseña incorrectos.'
        ]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('admin'));
    }

    public function action()
    {
        $session = session();
        if ($session->get('admin_logged_in') !== true) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autorizado.'])->setStatusCode(401);
        }

        require_once ROOTPATH . 'config.php';
        $db = getDbConnection();

        $inputData = $this->request->getJSON(true) ?: [];
        $action = $inputData['action'] ?? '';

        switch ($action) {
            case 'add_alumnos_ajax':
                $did = intval($inputData['id_docente'] ?? 0);
                $rows = $inputData['data'] ?? [];
                if (!$did || empty($rows)) { 
                    return $this->response->setJSON(['success' => false, 'message' => 'Faltan datos.']);
                }
                $ok = 0; $err = 0;
                $db->beginTransaction();
                foreach ($rows as $r) {
                    $m = trim($r['matricula'] ?? ''); 
                    $n = trim($r['nombre'] ?? ''); 
                    $s = trim($r['semestre'] ?? '');
                    $c = trim($r['correo'] ?? '');
                    if ($m && $n && $s) {
                        try { 
                            $db->prepare("INSERT INTO alumnos (uuid,matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (UUID(),?,?,?,?,?)")->execute([$m,$n,$s,$c,$did]); 
                            $ok++; 
                        } catch (\PDOException $e) { 
                            $err++; 
                        }
                    }
                }
                $db->commit();
                return $this->response->setJSON(['success' => true, 'message' => "$ok alumnos agregados." . ($err ? " ($err omitidos)" : "")]);

            case 'add_docente':
                $nombre = trim($inputData['nombre_completo'] ?? '');
                $email  = trim($inputData['email'] ?? '');
                $pass   = trim($inputData['password'] ?? '');
                $rol    = $inputData['rol'] ?? 'Docente';
                if (!$nombre || !$email || !$pass) { 
                    return $this->response->setJSON(['success' => false, 'message' => 'Todos los campos son requeridos.']);
                }
                $db->prepare("INSERT INTO usuarios (nombre_completo,email,password_hash,rol) VALUES (?,?,?,?)")->execute([$nombre,$email,$pass,$rol]);
                return $this->response->setJSON(['success' => true, 'message' => "Docente registrado con éxito."]);

            case 'add_alumno':
                $mat = trim($inputData['matricula'] ?? ''); 
                $nom = trim($inputData['nombre_completo'] ?? '');
                $sem = trim($inputData['semestre_grupo'] ?? ''); 
                $did = intval($inputData['id_docente'] ?? 0);
                $correo = trim($inputData['correo'] ?? '');
                if (!$mat || !$nom || !$sem || !$did) { 
                    return $this->response->setJSON(['success' => false, 'message' => 'Complete todos los campos.']);
                }
                try {
                    $db->prepare("INSERT INTO alumnos (uuid,matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (UUID(),?,?,?,?,?)")->execute([$mat,$nom,$sem,$correo,$did]);
                    return $this->response->setJSON(['success' => true, 'message' => "Alumno registrado con éxito."]);
                } catch (\PDOException $e) {
                    $msg = $e->getCode() == 23000 ? 'Matrícula duplicada.' : 'Error: ' . $e->getMessage();
                    return $this->response->setJSON(['success' => false, 'message' => $msg]);
                }

            case 'add_alumnos_bulk_text':
                $did = intval($inputData['id_docente'] ?? 0); 
                $text = trim($inputData['alumnos_text'] ?? '');
                if (!$did || !$text) { 
                    return $this->response->setJSON(['success' => false, 'message' => 'Complete todos los campos.']);
                }
                $ok = 0; $err = 0;
                $db->beginTransaction();
                foreach (explode("\n", $text) as $ln) {
                    $ln = trim($ln); 
                    if (!$ln) continue;
                    $p = explode(",", $ln);
                    if (count($p) >= 3) {
                        $m = trim($p[0]);
                        $n = trim($p[1]);
                        $s = trim($p[2]);
                        $c = isset($p[3]) ? trim($p[3]) : '';
                        if ($m && $n && $s) {
                            try {
                                $db->prepare("INSERT INTO alumnos (uuid,matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (UUID(),?,?,?,?,?)")->execute([$m,$n,$s,$c,$did]);
                                $ok++;
                            } catch (\PDOException $e) {
                                $err++;
                            }
                        }
                    } else {
                        $err++;
                    }
                }
                $db->commit();
                return $this->response->setJSON(['success' => true, 'message' => "$ok alumnos agregados." . ($err ? " ($err omitidos)" : "")]);

            case 'delete_docente':
                $id = intval($inputData['id_docente'] ?? 0);
                if ($id) {
                    $db->beginTransaction();
                    try {
                        $db->prepare("DELETE FROM detalles_rubrica WHERE id_evaluacion IN (SELECT id_evaluacion FROM evaluaciones WHERE id_evaluador = ?)")->execute([$id]);
                        $db->prepare("DELETE FROM evaluaciones WHERE id_evaluador = ?")->execute([$id]);
                        $db->prepare("DELETE FROM alumnos WHERE id_docente = ?")->execute([$id]);
                        $db->prepare("DELETE FROM usuarios WHERE id_usuario=?")->execute([$id]);
                        $db->commit();
                        return $this->response->setJSON(['success' => true, 'message' => "Docente eliminado."]);
                    } catch (\Exception $e) {
                        $db->rollBack();
                        return $this->response->setJSON(['success' => false, 'message' => "Error al eliminar docente."]);
                    }
                }
                return $this->response->setJSON(['success' => false, 'message' => "ID no válido."]);

            case 'delete_alumno':
                $id = intval($inputData['id_alumno'] ?? 0);
                if ($id) {
                    $db->beginTransaction();
                    try {
                        $db->prepare("DELETE FROM detalles_rubrica WHERE id_evaluacion IN (SELECT id_evaluacion FROM evaluaciones WHERE id_alumno = ?)")->execute([$id]);
                        $db->prepare("DELETE FROM evaluaciones WHERE id_alumno = ?")->execute([$id]);
                        $db->prepare("DELETE FROM alumnos WHERE id_alumno=?")->execute([$id]);
                        $db->commit();
                        return $this->response->setJSON(['success' => true, 'message' => "Alumno eliminado."]);
                    } catch (\Exception $e) {
                        $db->rollBack();
                        return $this->response->setJSON(['success' => false, 'message' => "Error al eliminar alumno."]);
                    }
                }
                return $this->response->setJSON(['success' => false, 'message' => "ID no válido."]);

            case 'resend_email':
                $id = intval($inputData['id_evaluacion'] ?? 0);
                if (!$id) {
                    return $this->response->setJSON(['success' => false, 'message' => "ID de evaluación no válido."]);
                }

                require_once ROOTPATH . 'includes/email_sender.php';
                require_once ROOTPATH . 'api/pdf_generator.php';
                
                $stmt = $db->prepare("SELECT id_alumno, asunto_principal, calificacion_total FROM evaluaciones WHERE id_evaluacion = ?");
                $stmt->execute([$id]);
                $ev = $stmt->fetch();
                
                if ($ev) {
                    $stmtAl = $db->prepare("SELECT nombre_completo, correo FROM alumnos WHERE id_alumno = ?");
                    $stmtAl->execute([$ev['id_alumno']]);
                    $alumnoInfo = $stmtAl->fetch(\PDO::FETCH_ASSOC);
                    
                    if ($alumnoInfo && !empty($alumnoInfo['correo'])) {
                        $stmtAvg = $db->prepare("SELECT AVG(calificacion_total) FROM evaluaciones WHERE id_alumno = ?");
                        $stmtAvg->execute([$ev['id_alumno']]);
                        $promedio = floatval($stmtAvg->fetchColumn());
                        
                        $pdfContent = generateEvaluationPdf($db, $id);
                        
                        if (!empty($pdfContent)) {
                            $sent = sendEvaluationEmail(
                                $alumnoInfo['correo'],
                                $alumnoInfo['nombre_completo'],
                                $promedio,
                                $pdfContent,
                                $ev['asunto_principal'],
                                $ev['calificacion_total']
                            );
                            if ($sent) {
                                return $this->response->setJSON(['success' => true, 'message' => "Reporte enviado al correo del alumno exitosamente."]);
                            } else {
                                return $this->response->setJSON(['success' => false, 'message' => "El SMTP está configurado, pero falló el envío del correo. Revisa email_log.log para más detalles."]);
                            }
                        } else {
                            return $this->response->setJSON(['success' => false, 'message' => "No se pudo generar el reporte PDF."]);
                        }
                    } else {
                        return $this->response->setJSON(['success' => false, 'message' => "El alumno no tiene un correo electrónico registrado."]);
                    }
                } else {
                    return $this->response->setJSON(['success' => false, 'message' => "Evaluación no encontrada."]);
                }

            case 'reset_db':
                try {
                    ob_start();
                    require ROOTPATH . 'setup.php';
                    $output = ob_get_clean();
                    return $this->response->setJSON(['success' => true, 'message' => "Base de datos reconstruida con éxito. Por favor inicia sesión nuevamente."]);
                } catch (\Exception $e) {
                    if (ob_get_level() > 0) ob_end_clean();
                    return $this->response->setJSON(['success' => false, 'message' => "Error al reconstruir la base de datos: " . $e->getMessage()]);
                }

            default:
                return $this->response->setJSON(['success' => false, 'message' => "Acción desconocida."]);
        }
    }

    public function guide()
    {
        return view('admin_guide');
    }
}

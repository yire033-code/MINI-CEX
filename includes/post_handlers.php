<?php
/**
 * POST and AJAX Actions Handler
 */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* ─── Generic Response Helper ─── */
    $sendResponse = function($ok, $msg) use ($isJson, &$message, &$messageType) {
        if ($isJson) {
            echo json_encode(['success' => $ok, 'message' => $msg]);
            exit;
        }
        $message = $msg;
        $messageType = $ok ? 'success' : 'error';
    };

    /* AJAX: bulk Excel */
    if ($action === 'add_alumnos_ajax') {
        $did = intval($inputData['id_docente'] ?? 0);
        $rows = $inputData['data'] ?? [];
        if (!$did || empty($rows)) { $sendResponse(false, 'Faltan datos.'); }
        $ok = 0; $err = 0;
        $db->beginTransaction();
        foreach ($rows as $r) {
            $m = trim($r['matricula'] ?? ''); $n = trim($r['nombre'] ?? ''); $s = trim($r['semestre'] ?? '');
            $c = trim($r['correo'] ?? '');
            if ($m && $n && $s) {
                try { $db->prepare("INSERT INTO alumnos (matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (?,?,?,?,?)")->execute([$m,$n,$s,$c,$did]); $ok++; }
                catch (\PDOException $e) { $err++; }
            }
        }
        $db->commit();
        $sendResponse(true, "$ok alumnos agregados." . ($err ? " ($err omitidos)" : ""));
    }

    if ($action === 'add_docente') {
        $nombre = trim($inputData['nombre_completo'] ?? '');
        $email  = trim($inputData['email'] ?? '');
        $pass   = trim($inputData['password'] ?? '');
        $rol    = $inputData['rol'] ?? 'Docente';
        if (!$nombre || !$email || !$pass) { $sendResponse(false, 'Todos los campos son requeridos.'); }
        else {
            $db->prepare("INSERT INTO usuarios (nombre_completo,email,password_hash,rol) VALUES (?,?,?,?)")->execute([$nombre,$email,$pass,$rol]);
            $sendResponse(true, "Docente registrado con éxito.");
        }
    }

    if ($action === 'add_alumno') {
        $mat = trim($inputData['matricula'] ?? ''); $nom = trim($inputData['nombre_completo'] ?? '');
        $sem = trim($inputData['semestre_grupo'] ?? ''); $did = intval($inputData['id_docente'] ?? 0);
        $correo = trim($inputData['correo'] ?? '');
        if (!$mat||!$nom||!$sem||!$did) { $sendResponse(false, 'Complete todos los campos.'); }
        else {
            try {
                $db->prepare("INSERT INTO alumnos (matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (?,?,?,?,?)")->execute([$mat,$nom,$sem,$correo,$did]);
                $sendResponse(true, "Alumno registrado con éxito.");
            } catch (\PDOException $e) {
                $msg = $e->getCode() == 23000 ? 'Matrícula duplicada.' : 'Error: ' . $e->getMessage();
                $sendResponse(false, $msg);
            }
        }
    }

    if ($action === 'add_alumnos_bulk_text') {
        $did = intval($inputData['id_docente'] ?? 0); $text = trim($inputData['alumnos_text'] ?? '');
        if (!$did || !$text) { $sendResponse(false, 'Complete todos los campos.'); }
        else {
            $ok=0;$err=0;$db->beginTransaction();
            foreach (explode("\n",$text) as $ln) {
                $ln=trim($ln); if(!$ln) continue;
                $p=explode(",",$ln);
                if(count($p)>=3){
                    $m=trim($p[0]);$n=trim($p[1]);$s=trim($p[2]);
                    $c=isset($p[3])?trim($p[3]):'';
                    if($m&&$n&&$s){
                        try{$db->prepare("INSERT INTO alumnos (matricula,nombre_completo,semestre_grupo,correo,id_docente) VALUES (?,?,?,?,?)")->execute([$m,$n,$s,$c,$did]);$ok++;}
                        catch(\PDOException $e){$err++;}
                    }
                }else{$err++;}
            }
            $db->commit();
            $sendResponse(true, "$ok alumnos agregados.".($err?" ($err omitidos)":""));
        }
    }

    if ($action === 'delete_docente') {
        $id = intval($inputData['id_docente'] ?? 0);
        if ($id) {
            $db->prepare("DELETE FROM usuarios WHERE id_usuario=?")->execute([$id]);
            $sendResponse(true, "Docente eliminado.");
        } else { $sendResponse(false, "ID no válido."); }
    }

    if ($action === 'delete_alumno') {
        $id = intval($inputData['id_alumno'] ?? 0);
        if ($id) {
            $db->prepare("DELETE FROM alumnos WHERE id_alumno=?")->execute([$id]);
            $sendResponse(true, "Alumno eliminado.");
        } else { $sendResponse(false, "ID no válido."); }
    }

    if ($action === 'resend_email') {
        $id = intval($inputData['id_evaluacion'] ?? 0);
        if ($id) {
            // Fetch evaluation details
            require_once __DIR__ . '/email_sender.php';
            require_once __DIR__ . '/../api/pdf_generator.php';
            
            $stmt = $db->prepare("SELECT id_alumno, asunto_principal, calificacion_total FROM evaluaciones WHERE id_evaluacion = ?");
            $stmt->execute([$id]);
            $ev = $stmt->fetch();
            
            if ($ev) {
                // Fetch student info
                $stmtAl = $db->prepare("SELECT nombre_completo, correo FROM alumnos WHERE id_alumno = ?");
                $stmtAl->execute([$ev['id_alumno']]);
                $alumnoInfo = $stmtAl->fetch(PDO::FETCH_ASSOC);
                
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
                            $sendResponse(true, "Reporte enviado al correo del alumno exitosamente.");
                        } else {
                            $sendResponse(false, "El SMTP está configurado, pero falló el envío del correo. Revisa email_log.log para más detalles.");
                        }
                    } else {
                        $sendResponse(false, "No se pudo generar el reporte PDF.");
                    }
                } else {
                    $sendResponse(false, "El alumno no tiene un correo electrónico registrado.");
                }
            } else {
                $sendResponse(false, "Evaluación no encontrada.");
            }
        } else {
            $sendResponse(false, "ID de evaluación no válido.");
        }
    }
}


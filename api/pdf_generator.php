<?php
/**
 * MINI-CEX Premium PDF Report Generator using FPDF
 * Gold and blue institutional theme, robust multi-line parsing, no signatures.
 */

require_once __DIR__ . '/fpdf/fpdf.php';

/**
 * Generates clinical evaluation PDF and returns its binary string content.
 * 
 * @param PDO $db
 * @param int $evalId
 * @return string
 */
function generateEvaluationPdf($db, $evalId) {
    // Dynamically increase PHP memory limit to handle high-resolution image processing safely
    @ini_set('memory_limit', '512M');

    // 1. Fetch evaluation details
    $stmt = $db->prepare("SELECT e.*, u.nombre_completo AS evaluador_nombre, a.nombre_completo AS alumno_nombre, a.matricula AS alumno_matricula, a.semestre_grupo AS alumno_semestre FROM evaluaciones e LEFT JOIN usuarios u ON e.id_evaluador = u.id_usuario LEFT JOIN alumnos a ON e.id_alumno = a.id_alumno WHERE e.id_evaluacion = ?");
    $stmt->execute([$evalId]);
    $eval = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$eval) return "";

    // 2. Fetch details
    $stmtDetails = $db->prepare("SELECT * FROM detalles_rubrica WHERE id_evaluacion = ?");
    $stmtDetails->execute([$evalId]);
    $details = $stmtDetails->fetchAll(PDO::FETCH_ASSOC);

    // Create PDF instance
    $pdf = new FPDF('P', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetMargins(15, 15, 15);
    $pdf->SetAutoPageBreak(true, 15);
    
    // Draw Top Blue Banner
    $pdf->SetFillColor(27, 94, 150); // Institutional Blue
    $pdf->Rect(0, 0, 210, 8, 'F');
    
    // Draw Gold Line
    $pdf->SetFillColor(184, 134, 11); // Institutional Gold
    $pdf->Rect(0, 8, 210, 2, 'F');
    
    // Institutional Logo
    $logoPath = __DIR__ . '/../logo.png';
    $smallLogoPath = __DIR__ . '/../logo_small.png';
    if (file_exists($logoPath)) {
        if (!file_exists($smallLogoPath)) {
            // Dynamically scale down the high-resolution logo to avoid FPDF memory exhaustion
            try {
                $src = @imagecreatefrompng($logoPath);
                if ($src) {
                    $width = imagesx($src);
                    $height = imagesy($src);
                    $newWidth = 400; // 400px is excellent for the 22mm layout size
                    $newHeight = intval($height * ($newWidth / $width));
                    
                    $dst = imagecreatetruecolor($newWidth, $newHeight);
                    imagealphablending($dst, false);
                    imagesavealpha($dst, true);
                    $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
                    imagefilledrectangle($dst, 0, 0, $newWidth, $newHeight, $transparent);
                    
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                    imagepng($dst, $smallLogoPath, 6);
                    imagedestroy($src);
                    imagedestroy($dst);
                }
            } catch (\Exception $e) {
                // Fail silently, fallback to the original logo
            }
        }
        $activeLogoPath = file_exists($smallLogoPath) ? $smallLogoPath : $logoPath;
        $pdf->Image($activeLogoPath, 15, 15, 22);
    }
    
    // Header texts
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(27, 94, 150);
    $pdf->SetXY(42, 16);
    $pdf->Cell(0, 8, utf8_decode("TERAPIA FÍSICA Y REHABILITACIÓN"), 0, 1, 'L');
    
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(184, 134, 11);
    $pdf->SetX(42);
    $pdf->Cell(0, 5, utf8_decode("REPORTE DE EVALUACIÓN CLÍNICA (MINI-CEX)"), 0, 1, 'L');
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(71, 85, 105);
    $pdf->SetX(42);
    $pdf->Cell(0, 5, utf8_decode("Sistema de Gestión de Rúbricas Clínicas"), 0, 1, 'L');
    
    $pdf->Ln(10);
    
    // Horizontal divider
    $pdf->SetDrawColor(220, 225, 232);
    $pdf->Line(15, 42, 195, 42);
    $pdf->SetY(44);
    
    // Metadata block
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(27, 94, 150);
    $pdf->Cell(0, 6, utf8_decode("DATOS GENERALES"), 0, 1, 'L');
    $pdf->Ln(2);
    
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(30, 41, 59);
    
    // Column definitions
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Alumno:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(65, 6, utf8_decode($eval['alumno_nombre']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Evaluador:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(45, 6, utf8_decode($eval['evaluador_nombre']), 0, 1);
    
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Matrícula:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(65, 6, utf8_decode($eval['alumno_matricula']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Fecha:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(45, 6, date('d/m/Y', strtotime($eval['fecha_evaluacion'])), 0, 1);
    
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Semestre/Grupo:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(65, 6, utf8_decode($eval['alumno_semestre']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Entorno Clínico:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(45, 6, utf8_decode($eval['entorno_clinico']), 0, 1);

    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Tipo de Paciente:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(65, 6, utf8_decode($eval['tipo_paciente']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Complejidad:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(45, 6, utf8_decode($eval['complejidad']), 0, 1);

    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Asunto Principal:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(65, 6, utf8_decode($eval['asunto_principal']), 0, 0);
    $pdf->SetFont('Arial', 'B', 9); $pdf->Cell(35, 6, utf8_decode("Tiempos:"), 0, 0);
    $pdf->SetFont('Arial', '', 9);  $pdf->Cell(45, 6, utf8_decode("Obs: " . $eval['tiempo_observacion'] . " min | Feedback: " . $eval['tiempo_feedback'] . " min"), 0, 1);

    $pdf->Ln(4);
    
    // Evaluation summary card
    $currentY = $pdf->GetY();
    $pdf->SetFillColor(247, 248, 250);
    $pdf->Rect(15, $currentY, 180, 12, 'F');
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetTextColor(184, 134, 11);
    $pdf->SetY($currentY + 3);
    $pdf->SetX(20);
    $pdf->Cell(120, 6, utf8_decode("CALIFICACIÓN GLOBAL OBTENIDA:"), 0, 0);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(50, 6, number_format($eval['calificacion_total'] / 10, 1) . " / 10", 0, 1, 'R');
    
    $pdf->Ln(6);
    
    // Competencies Section
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(27, 94, 150);
    $pdf->Cell(0, 6, utf8_decode("DESGLOSE DE COMPETENCIAS"), 0, 1, 'L');
    $pdf->Ln(2);
    
    // Table Headers
    $pdf->SetFillColor(27, 94, 150);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(85, 8, utf8_decode(" Competencia"), 1, 0, 'L', true);
    $pdf->Cell(25, 8, utf8_decode("Puntaje (1-9)"), 1, 0, 'C', true);
    $pdf->Cell(70, 8, utf8_decode(" Nivel Desempeño"), 1, 1, 'L', true);
    
    $pdf->SetTextColor(30, 41, 59);
    $pdf->SetFont('Arial', '', 9);
    
    foreach ($details as $detail) {
        $pt = intval($detail['puntaje']);
        
        $level = "No Evaluado";
        if ($pt >= 1 && $pt <= 3) $level = "Insatisfactorio";
        else if ($pt >= 4 && $pt <= 6) $level = "Satisfactorio";
        else if ($pt >= 7 && $pt <= 9) $level = "Sobresaliente";
        
        $pdf->Cell(85, 8, " " . utf8_decode($detail['competencia']), 1, 0, 'L');
        $scoreStr = ($pt > 0) ? $pt : "-";
        $pdf->Cell(25, 8, $scoreStr, 1, 0, 'C');
        $pdf->Cell(70, 8, " " . utf8_decode($level), 1, 1, 'L');
    }
    
    $pdf->Ln(4);
    
    // Feedback details
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(27, 94, 150);
    $pdf->Cell(0, 6, utf8_decode("RETROALIMENTACIÓN Y PLAN DE MEJORA"), 0, 1, 'L');
    $pdf->Ln(2);
    
    foreach ($details as $detail) {
        if (!empty($detail['notas']) || !empty($detail['a_destacar']) || !empty($detail['a_mejorar'])) {
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetTextColor(184, 134, 11);
            $pdf->Cell(0, 5, utf8_decode($detail['competencia']), 0, 1, 'L');
            
            $pdf->SetTextColor(30, 41, 59);
            $pdf->SetFont('Arial', '', 9);
            
            if (!empty($detail['notas'])) {
                $pdf->SetFont('Arial', 'B', 8.5); $pdf->Cell(20, 5, utf8_decode("Notas: "), 0, 0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(0, 5, utf8_decode($detail['notas']), 0, 'L');
            }
            if (!empty($detail['a_destacar'])) {
                $pdf->SetFont('Arial', 'B', 8.5); $pdf->Cell(20, 5, utf8_decode("Destacar: "), 0, 0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(0, 5, utf8_decode($detail['a_destacar']), 0, 'L');
            }
            if (!empty($detail['a_mejorar'])) {
                $pdf->SetFont('Arial', 'B', 8.5); $pdf->Cell(20, 5, utf8_decode("Mejorar: "), 0, 0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(0, 5, utf8_decode($detail['a_mejorar']), 0, 'L');
            }
            $pdf->Ln(2);
        }
    }
    
    // Page footer / end note
    $pdf->SetY(-22);
    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(148, 163, 184);
    $pdf->Cell(0, 4, utf8_decode("Reporte digital autogenerado por la plataforma institucional MINI-CEX."), 0, 1, 'C');
    $pdf->Cell(0, 4, utf8_decode("Facultad de Terapia Física y Rehabilitación - " . date('Y')), 0, 0, 'C');
    
    return $pdf->Output('S'); // Return as string representation of PDF
}

<?php
/**
 * Data Fetching and Statistics logic
 */

if ($isLoggedIn) {
    try {
        $statDocentes     = $db->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
        $statAlumnos      = $db->query("SELECT COUNT(*) FROM alumnos")->fetchColumn();
        $statEvaluaciones = $db->query("SELECT COUNT(*) FROM evaluaciones")->fetchColumn();
        $statPromedio     = $db->query("SELECT AVG(calificacion_total) FROM evaluaciones")->fetchColumn();
        $statPromedio     = $statPromedio ? number_format($statPromedio, 2) : '0.00';

        $docentes = $db->query("SELECT * FROM usuarios ORDER BY id_usuario DESC")->fetchAll();
        $alumnos  = $db->query("SELECT a.*,u.nombre_completo AS docente_nombre FROM alumnos a LEFT JOIN usuarios u ON a.id_docente=u.id_usuario ORDER BY a.id_alumno DESC")->fetchAll();
        $evaluaciones = $db->query("SELECT e.*,u.nombre_completo AS evaluador_nombre,a.nombre_completo AS alumno_nombre,a.matricula AS alumno_matricula FROM evaluaciones e LEFT JOIN usuarios u ON e.id_evaluador=u.id_usuario LEFT JOIN alumnos a ON e.id_alumno=a.id_alumno ORDER BY e.id_evaluacion DESC")->fetchAll();
    } catch (\Exception $e) {
        die("Error de datos: " . $e->getMessage());
    }
}

<?php
/**
 * Setup script for the standalone MINI-CEX system.
 * Creates the database 'bd_minicex' and its tables, then seeds them.
 */

require_once __DIR__ . '/config.php';

try {
    // 1. Connect to MySQL without selecting a database first, to create it
    $dsn = "mysql:host=" . DB_HOST . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    echo "Reiniciando base de datos '" . DB_NAME . "'...\n";
    $pdo->exec("DROP DATABASE IF EXISTS " . DB_NAME);
    $pdo->exec("CREATE DATABASE " . DB_NAME . " CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Base de datos creada exitosamente.\n\n";

    // 2. Connect to the created database
    $db = getDbConnection();

    // 3. Create tables
    $queries = [
        "CREATE TABLE IF NOT EXISTS usuarios (
            id_usuario INT AUTO_INCREMENT PRIMARY KEY,
            nombre_completo VARCHAR(150) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password_hash VARCHAR(255) NOT NULL,
            rol VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "CREATE TABLE IF NOT EXISTS alumnos (
            id_alumno INT AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) UNIQUE NOT NULL,
            matricula VARCHAR(50) UNIQUE NOT NULL,
            nombre_completo VARCHAR(150) NOT NULL,
            semestre_grupo VARCHAR(50) NOT NULL,
            correo VARCHAR(255) DEFAULT '',
            id_docente INT NOT NULL DEFAULT 1,
            FOREIGN KEY (id_docente) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "CREATE TABLE IF NOT EXISTS evaluaciones (
            id_evaluacion INT AUTO_INCREMENT PRIMARY KEY,
            uuid VARCHAR(36) UNIQUE NOT NULL,
            id_evaluador INT NOT NULL,
            id_alumno INT NOT NULL,
            fecha_evaluacion DATE NOT NULL,
            entorno_clinico ENUM('Consulta MF', 'Piso', 'Otros') NOT NULL,
            tipo_paciente ENUM('Nuevo', 'Subsecuente') NOT NULL,
            asunto_principal VARCHAR(255) NOT NULL,
            complejidad ENUM('Baja', 'Media', 'Alta') NOT NULL,
            tiempo_observacion INT NOT NULL,
            tiempo_feedback INT NOT NULL,
            calificacion_total DECIMAL(5,2) DEFAULT 0.00,
            firma_evaluador LONGTEXT,
            firma_alumno LONGTEXT,
            is_synced BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (id_evaluador) REFERENCES usuarios(id_usuario) ON DELETE RESTRICT,
            FOREIGN KEY (id_alumno) REFERENCES alumnos(id_alumno) ON DELETE RESTRICT
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "CREATE TABLE IF NOT EXISTS sync_queue (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            action VARCHAR(20) NOT NULL,
            table_name VARCHAR(50) NOT NULL,
            entity_uuid VARCHAR(36) NOT NULL,
            data_payload LONGTEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "CREATE TABLE IF NOT EXISTS detalles_rubrica (
            id_detalle INT AUTO_INCREMENT PRIMARY KEY,
            id_evaluacion INT NOT NULL,
            competencia VARCHAR(100) NOT NULL,
            puntaje INT NOT NULL DEFAULT 0,
            notas TEXT,
            a_destacar TEXT,
            a_mejorar TEXT,
            FOREIGN KEY (id_evaluacion) REFERENCES evaluaciones(id_evaluacion) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

        "CREATE INDEX idx_fecha ON evaluaciones(fecha_evaluacion);",
        "CREATE INDEX idx_alumno ON evaluaciones(id_alumno);",
        "CREATE INDEX idx_sync ON evaluaciones(is_synced);"
    ];

    foreach ($queries as $index => $q) {
        $db->exec($q);
        echo "Tabla/Índice " . ($index + 1) . " creado con éxito.\n";
    }
    echo "\nTablas creadas exitosamente.\n\n";

    // 4. Seed user (evaluador@upe.edu.mx)
    $stmt = $db->prepare("SELECT id_usuario FROM usuarios WHERE email = ?");
    $stmt->execute(['evaluador@upe.edu.mx']);
    if ($stmt->rowCount() === 0) {
        $insert = $db->prepare("INSERT INTO usuarios (nombre_completo, email, password_hash, rol) VALUES (?, ?, ?, ?)");
        $insert->execute(['Dr. Evaluador Ejemplo', 'evaluador@upe.edu.mx', 'password123', 'Docente']);
        echo "Usuario semilla insertado.\n";
    } else {
        echo "El usuario semilla ya existe.\n";
    }

    // 5. Seed students
    $stmt = $db->query("SELECT id_alumno FROM alumnos LIMIT 1");
    if ($stmt->rowCount() === 0) {
        $insert = $db->prepare("INSERT INTO alumnos (uuid, nombre_completo, matricula, semestre_grupo, correo) VALUES (UUID(), ?, ?, ?, ?)");
        $insert->execute(['Juan Pérez', '202601', '6to A', 'juan.perez@example.com']);
        $insert->execute(['María García', '202602', '7mo B', 'maria.garcia@example.com']);
        $insert->execute(['Carlos López', '202603', '8vo C', 'carlos.lopez@example.com']);
        echo "Alumnos semilla insertados.\n";
    } else {
        echo "Los alumnos semilla ya existen.\n";
    }

    echo "\n¡Configuración del sistema MINI-CEX completada con éxito!\n";

} catch (\Exception $e) {
    throw new \Exception("Error durante la configuración: " . $e->getMessage());
}

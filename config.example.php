<?php
/**
 * MINI-CEX API Configuration File
 * 
 * === INSTRUCTIONS ===
 * 1. Copy this file to config.php
 * 2. Fill in your actual database and SMTP credentials
 * 3. NEVER commit config.php to Git (it's in .gitignore)
 */

// =================================================================
// DATABASE CONFIGURATION
// =================================================================
define('DB_HOST', 'localhost:3306');   // Host:Port
define('DB_USER', 'root');            // Database username
define('DB_PASS', '');                // Database password
define('DB_NAME', 'bd_minicex');      // Database name

// =================================================================
// SMTP EMAIL CONFIGURATION
// =================================================================
// It is strongly recommended to use an app-specific password.
define('SMTP_HOST', 'smtp.example.com'); 
define('SMTP_AUTH', true);
define('SMTP_USERNAME', 'youremail@example.com');
define('SMTP_PASSWORD', 'your-app-password'); 
define('SMTP_SECURE', 'tls'); // Use 'tls' or 'ssl'
define('SMTP_PORT', 587); 
define('SMTP_FROM_EMAIL', 'youremail@example.com');
define('SMTP_FROM_NAME', 'MINI-CEX Sistema');

// =================================================================
// DATABASE CONNECTION (PDO)
// =================================================================
function getDbConnection() {
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Intenta con múltiples configuraciones comunes (local y producción)
    $hosts = [DB_HOST, 'localhost:3306', '127.0.0.1:3306', 'localhost:33069', '127.0.0.1:33069'];
    $hosts = array_values(array_unique(array_filter($hosts)));

    $lastException = null;
    foreach ($hosts as $host) {
        $port = 3306;
        $hostname = $host;
        if (strpos($host, ':') !== false) {
            list($hostname, $port) = explode(':', $host);
        }
        
        $dsn = "mysql:host=" . $hostname . ";port=" . $port . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        try {
            return new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (\PDOException $e) {
            $lastException = $e;
        }
    }

    throw new \PDOException("No se pudo conectar a la base de datos local o remota. Último error: " . $lastException->getMessage(), (int)$lastException->getCode());
}

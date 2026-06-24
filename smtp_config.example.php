<?php
/**
 * PHPMailer SMTP Configuration
 * 
 * === INSTRUCTIONS ===
 * 1. Copy this file to smtp_config.php
 * 2. Fill in your actual SMTP credentials
 * 3. NEVER commit smtp_config.php to Git (it's in .gitignore)
 */

// ******************************************************************
// <<< --- SMTP CONFIGURATION --- >>>
// ******************************************************************

// Specify main and backup SMTP servers
define('SMTP_HOST', 'smtp.example.com'); 

// Enable SMTP authentication
define('SMTP_AUTH', true);

// SMTP username (full email address)
define('SMTP_USERNAME', 'youremail@example.com');

// SMTP password (or app-specific password)
define('SMTP_PASSWORD', 'your-app-password'); 

// Enable TLS encryption, `ssl` also accepted
define('SMTP_SECURE', 'tls');

// TCP port to connect to
define('SMTP_PORT', 587); 

// ******************************************************************
// <<< --- SENDER INFORMATION --- >>>
// ******************************************************************

// Email address to send from
define('SMTP_FROM_EMAIL', 'youremail@example.com');

// Name to send from
define('SMTP_FROM_NAME', 'MINI-CEX Sistema');

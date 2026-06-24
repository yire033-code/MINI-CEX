<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'HomeController::index');

// Admin Panel Routes
$routes->get('admin', 'AdminController::index');
$routes->post('admin/login', 'AdminController::login');
$routes->get('admin/logout', 'AdminController::logout');
$routes->post('admin/action', 'AdminController::action');

// API Routes
$routes->post('api/auth/login', 'ApiController::authLogin');
$routes->get('api/students', 'ApiController::getStudents');
$routes->post('api/sync/students', 'ApiController::syncStudents');
$routes->post('api/sync/evaluations', 'ApiController::syncEvaluations');
$routes->get('api/sync/evaluations', 'ApiController::getEvaluations');
$routes->post('api/sync/resend-email', 'ApiController::resendEmail');
$routes->post('api/sync/process_queue', 'ApiController::processQueue');

// Report Route
$routes->get('generate_report.php', 'ReportController::generate');

// API Documentation
$routes->get('api/docs', 'ApiDocsController::index');

// Admin Guide
$routes->get('admin/guide', 'AdminController::guide');

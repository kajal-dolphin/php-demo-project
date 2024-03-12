<?php
// Define the root directory path
define('ROOT_DIR', __DIR__);

// Construct the full file path
$dashboardFilePath = ROOT_DIR . '/view/admin/layout/dashboard.php';

// Include or require the file
require_once $dashboardFilePath;
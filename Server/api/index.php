<?php
require_once 'config.php';
require_once 'database/db.php';
require_once 'router/router.php';
require_once 'libs/user.php';
require_once 'libs/shop.php';
try {
    $api = new router();
    $api->run();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
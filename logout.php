<?php
// logout.php

require_once 'controllers/AuthController.php';

$auth = new AuthController();
$auth->logout();

header('Location: index.php');
exit;
?>
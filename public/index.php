<?php
session_start();
require_once '../private/core/autoload.php';
$app = new Core\App;
$app->loadController();
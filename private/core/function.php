<?php
function show($value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
}

function hash_password($value) {
    return password_hash($value, PASSWORD_DEFAULT);
}

function random_code() {
    $length = random_int(8, 20);
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

function default_date() {
    return date('Y-m-d H:i:s');
}

function redirect($page) {
    header('Location: ' . SITE . $page);
    die;
}

function escape($value) {
    return htmlspecialchars($value);
}
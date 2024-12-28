<?php
defined('ROOTHPATH') OR exit('Access denied');

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

/*
function check_extension() {
    $required_extension = [
        'gd',
        'mysqli',
        'pdo_mysql',
        'pdo_sqlite',
        'curl',
        'fileinfo',
        'intl',
        'exif',
        'mbstring',
    ];

    $not_loaded = [];

    foreach ($required_extension as $key) {
        if(!extension_loaded($key)) {
            $not_loaded[] = $key;
        }
    }

    if(!empty($not_loaded)) {
        show('Please load de extensions in your php.ini file: <br>' . implode('<br>', $not_loaded));
        die;
    }
}
//check_extension();

function get_image($image = '', $type='post') {
    $image = $image ?? '';
    if(file_exists($image)) {
        return SITE . '/' . $image;
    }

    if($type == 'user') {
        return SITE . '/assets/img/user.png';
    } else {
        return SITE . '/assets/img/no-image.png';
    }
}

function get_pagination() {
    $vars              = [];
    $vars['page']      = $_GET['page'] ?? 1;
    $vars['page']      = (int))$vars['page'];
    $vars['prev_page'] = $vars['page'] <= 1 ? 1 : $vars['page'] - 1;
    $vars['next_page'] = $vars['page'] + 1;
    return $vars;
}
*/

function old_value($key, $default = '') {
    if(!empty($_POST[$key])) {
        return $_POST[$key]; 
    }
    return $default;
}
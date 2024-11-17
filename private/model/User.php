<?php
class User {
    use \Core\Model;

    protected $table = 'user';
    protected $allowedColumns = [
        'user_firstName',
        'user_lastName',
        'user_email',
        'user_password',
        'user_image',
        'user_dateRegistered',
        'user_profile_id',
        'user_status_id',
        'user_dateStatus',
    ];
}
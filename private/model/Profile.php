<?php
defined('ROOTHPATH') OR exit('Access denied');

class Profile {
    use \Core\Model;

    protected $table = 'profile';
    protected $allowedColumns = [
        'profile_name',
        'profile_status_id',
    ];
}
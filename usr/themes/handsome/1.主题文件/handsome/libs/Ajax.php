<?php
/**
 * Created by PhpStorm.
 * User: hewro
 * Date: 2018/7/17
 * Time: 20:43
 */

if( @$_GET['action'] == 'ajax_avatar_get' && 'GET' == $_SERVER['REQUEST_METHOD'] ) {
    $email = strtolower( $_GET['email']);
    echo Utils::getAvator($email,65);
    die();
}else {
    return;
}
<?php
function connect_mysql_db() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $db_name  = 'auth54';

    $mysqli = new mysqli($host, $user, $password, $db_name);
    if (mysqli_connect_errno()) { die('con_error_mysqli'); }
    $mysqli->query('SET NAMES utf8');
    $mysqli->select_db($db_name);
    return $mysqli;
}
?>
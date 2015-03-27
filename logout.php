<?php
/*
    Copyright 2015 Dmitry Chekanov <dmamboss@gmail.com>
    Distributed under the MIT License.
    See accompanying file COPYING or copy at
    http://opensource.org/licenses/MIT
*/

require_once dirname(__FILE__) . '/class/auth.php';
$user = new my_user();

$user->logout();
header('location: index.php');
?>
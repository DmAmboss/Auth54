<?php
/*
    Copyright 2015 Dmitry Chekanov <dmamboss@gmail.com>
    Distributed under the MIT License.
    See accompanying file COPYING or copy at
    http://opensource.org/licenses/MIT
*/

ob_start();                                                          /* for Cookies */

require_once dirname(__FILE__) . '/class/auth.php';
$user = new my_user();

/* ============== Authentication ================================= */
if (isset($_POST['enter'])) {
    $enter = $_POST['enter'];
} else {
    $enter = '';
}
if ($enter == '') {                                                  /* 1. Login via Cookies */
    $user->check();
}
if ($enter != '') {                                                  /* 2. Login via Password */

    $user->login($_POST['email'],$_POST['pass']);
    if ($user->user_id == 0) {
        echo '<p style="color: red;">error login</p>';
    }
}
if ($enter == '') {                                                  /* 3. Login via Registration in next version */
                                                                     /* 4. Login via FaceBook in next version */
}
if ($_GET['logout']) {                                               /* logout */
    $user->logout();
}
/* ============== END Authentication ============================= */


/* ============== Panel from Design ============================== */
if ($user->user_id != 0) {
    echo '<p>Hi, ' . $user->user_name . '. <a href="logout.php">logout</a></p>';
    if ($user->god_mode == 1) {
        echo '<div style="background-color: #a9a9a9;">Admin panel</div>';
    }
} else {
    echo '<p><strong>User</strong><br>';
    echo 'demo@example.com<br>';
    echo '123654</p>';
    echo '<p><strong>Admin</strong><br>';
    echo 'admin@example.com<br>';
    echo '123654</p>';
    echo '<hr>';

    echo '<form action="index.php" method="post">';
    echo '<p>E-mail: <input name="email" type="text"></p>';
    echo '<p>Password: <input type="password" name="pass"></p>';
    echo '<input type="submit" value="Submit" name="enter">';
    echo '</form>';
}
/* ============== END Panel from Design ========================== */
?>
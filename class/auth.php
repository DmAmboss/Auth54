<?php
/*
    Copyright 2015 Dmitry Chekanov <dmamboss@gmail.com>
    Distributed under the MIT License.
    See accompanying file COPYING or copy at
    http://opensource.org/licenses/MIT
*/

require_once dirname(__FILE__) . ('/class/mysqli.php');

class my_user {

    public $user_id = 0;                                              /* User ID in DB */
    public $email = '';                                               /* Default e-mail */
    public $user_name = '-';                                          /* Default UserName */
    public $secret = 'auth_demo';                                     /* Secret word */
    public $last_error = 0;                                           /* Massage of last error */
    public $db_handle;                                                /* Data Base */
    public $god_mode = 0;                                             /* God mode AllTime = 0 */

    function connect_db() { $this->db_handle = connect_mysql_db(); }  /* connect_db */

    function close_db() { $this->db_handle->close(); }                /* close_db */

    /* ============== Login via Cookies ============================ */
    function check() {
        $this->user_id = 0;
        if (isset($_COOKIE['uid'])) {
            $uid = $_COOKIE['uid'];
        } else {
            $uid = '';
        }
        if (isset($_COOKIE['uhash'])) {
            $uhash = $_COOKIE['uhash'];
        } else {
            $uhash = '';
        }
        if ($uid != '' && $uhash != '') {
            $this->connect_db();
            $q =$this->db_handle->prepare("SELECT id,god_mode,username FROM users WHERE email=? and md5=? LIMIT 1;");
            $q->bind_param("ss", $uid, $uhash);
            $q->execute();
            $q->bind_result( $this->user_id, $this->god_mode, $this->user_name );
            if ($q->fetch()) {
                $this->last_error = 1;
            } else {                                                  /* User not found */
                $this->user_id = 0;
                $this->last_error = 2;
            }
            $q->close();
            $this->close_db();
        }
        return $this->user_id;
    }
    /* ============== END Login via Cookies ======================= */


    /* ============== Crypt MD5 for hash and pass ================= */
    function auth_code_md5_pass ($email, $password)                  /* md5_pass */
    {
        $key_password = md5($password);
        $key_email = md5($email);
        $key_new = md5($user->secret . $key_email . $key_password);
        $key_new = md5($key_new);
        return $key_new;
    }
    function auth_code_md5 ($email, $password)                        /* md5 */
    {
        $key_password = md5($password);
        $key_email = md5($email);
        $key_new = md5($key_password . $user->secret . $key_email);
        $key_new = md5($key_new);
        return $key_new;
    }
    /* ============== END Crypt MD5 for hash and pass ============== */


    /* ============== Login via Pass =============================== */
    function login($email, $password) {
        $this->user_id = 0;
        $user_hash = 0;

        $key_new = $this->auth_code_md5_pass ($email, $password);

        $this->connect_db();
        $q = $this->db_handle->prepare("SELECT id,md5,god_mode,username FROM users WHERE email=? and md5_pass=? LIMIT 1;");
        $q->bind_param("ss", $email, $key_new);
        $q->execute();
        $q->bind_result($this->user_id, $user_hash, $this->god_mode, $this->user_name);
        if($q->fetch()) { // refresh lifetime
            setcookie('uid', $email, time() + 3600*24*14, '/auth');
            setcookie('uhash', $user_hash, time() + 3600*24*14, '/auth');
        } else {
            $this->user_id = 0;
        }
        $q->close();
        $this->close_db();
        return $this->user_id;
    }
    /* ============== END Login via Pass =========================== */


    /* ============== Logout ======================================= */
    function logout() {
        setcookie('uid');
        setcookie('uhash');
        unset($_COOKIE['uid']);
        unset($_COOKIE['uhash']);
        return $this->user_id = 0;
    }
    /* ============== END Logout =================================== */
}
?>
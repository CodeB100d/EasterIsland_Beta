<?php

class Login_Model extends Model {

    public function getUserInfo($username) {
        $db = $this->loadDatabase();
        $user = $db->select('SELECT * FROM users WHERE username = :username', array(':username' => $username));
        return $user[0];
    }

//    public function check_if_logged_in() {
//        Session::init();
//        if (!Session::get('loggedIn') || !Session::get('userid'))
//            header('location: ' . URL . 'admin/main/login');
//    }

    public function logout() {
        Session::init();
        Session::unset_data('loggedIn');
        Session::unset_data('userid');
        header('location: ' . URL . 'admin/main/login');
    }

}

?>

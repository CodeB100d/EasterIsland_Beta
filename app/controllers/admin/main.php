<?php

class Main extends EI_Controller {

    public function index($var = NULL) {
       $this->loadSession();
       var_dump($this->sessionAuthenticate());
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          if($this->processLogin()){
               $this->setSession($_POST["username"]);
               $this->dashboard();
          }
       }
        $pages = array('admin/login');
        $this->view->render($pages, $this->data);       
//        $this->loadModel("Login_Model", "admin");
//        $pages = array(
//            'admin/headers/default',
//            'admin/sidebar',
//            'admin/dashboard',
//            'admin/footers/default');
//        $this->data['parent_page'] = $this->getUriSegment(3);
//        $this->view->render($pages, $this->data);
    }
    public function dashboard(){
            $pages = array(
                'admin/headers/default',
                'admin/sidebar',
                'admin/dashboard',
                'admin/footers/default');
            $this->data['parent_page'] = $this->getUriSegment(3);
            $this->view->render($pages, $this->data);             
    }
    public function setSession($username){
            $_SESSION["admin_username"] = $_POST["username"];
            $_SESSION["admin_auth"] = TRUE;
    }
    public function sessionAuthenticate(){
            if($_SESSION["admin_auth"]){
               $this->dashboard();
               exit();
            }else{
               return false;
            }
    }
/*
    function login() {
        $this->loadSession("start");
        $this->loadUtils("FormValidator");
        $this->loadUtils("PasswordHash");
        $this->loadModel("Login_Model", "admin");

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->FormValidator->addValidation("username", "req", "Hey! thats not fair! tell me your username!");
            $this->FormValidator->addValidation("password", "req", "Will you please tell me your password.");

            if ($this->FormValidator->ValidateForm()) {

                if ($this->_validateCredentials($_POST['username'], $_POST['password']) === false)
                    ; {
                    $this->data["form_error_message"] = array("account" => "Sorry Ugly Bitch!!! Wrong Username and Password!");
                }
            } else {
                $this->data["form_error_message"] = $this->FormValidator->GetErrors();
            }
        }

        //password hash
        /*
          $t_hasher = new PasswordHash(8, FALSE);
          $correct = 'admin';
          $hash = $t_hasher->HashPassword($correct);
          echo $hash;
         
        //end
        $pages = array('admin/login');
        $this->view->render($pages, $this->data);
    }
*/
    public function logout() {
        $this->loadModel("Login_Model", "admin");
        $this->Login_Model->logout();
    }
    public function processLogin(){
            $this->loadUtils("FormValidator"); 
            $this->FormValidator->addValidation("username", "req", "Hey! thats not fair! tell me your username!");
            $this->FormValidator->addValidation("password", "req", "Will you please tell me your password.");
            if ($this->FormValidator->ValidateForm()) {
                if ($this->_validateCredentials($_POST['username'], $_POST['password']) === false)
                {
                    $this->data["form_error_message"] = array("account" => "Sorry Ugly Bitch!!! Wrong Username and Password!");
                }else{
                    return TRUE;
                }
            } else {
                $this->data["form_error_message"] = $this->FormValidator->GetErrors();
            }       
    }
    
    private function _validateCredentials($username,$password) {       
        $this->loadModel("Login_Model", "admin");
        $user = $this->Login_Model->getUserInfo($username);
        ///var_dump($user);
        if (isset($user->username)){
            $this->loadUtils("PasswordHash");
            $t_hasher = new PasswordHash(8, FALSE);
            $check = $t_hasher->CheckPassword($password, $user->password); 
            return $check ? TRUE : FALSE;
        }else
            return false;
    }    
}

?>

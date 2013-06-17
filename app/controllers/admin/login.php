<?php
class Login extends EI_Controller{
    function index($var="") {
        $this->loadUtils("Session");
        $this->loadUtils("FormValidator");
        $this->loadUtils("PasswordHash");
        $this->loadModel("Login_Model","admin");
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $this->FormValidator->addValidation("username","req","Hey! thats not fair! tell me your username!");
            $this->FormValidator->addValidation("password","req","Will you please tell me your password.");
            
            if($this->FormValidator->ValidateForm()) {
               
                if($this->_validateCredentials($_POST['username'], $_POST['password'])===false);{
                   $this->data["form_error_message"] = array("account" => "Sorry Bitch!!! Wrong Username and Password!");
                }
                
            } else {
                $this->data["form_error_message"] = $this->FormValidator->GetErrors();
            } 
        }
        
        $this->data["calendar"] = $this->SimpleCalendar->show();
        $this->data["test"] = "THIS IS A SAMPLE TESTING!!!";
        $pages = array('admin/login2');
        $this->view->render($pages, $this->data);
    }
    function login2() {
        $this->loadUtils("FormValidator");
        $this->loadUtils("PasswordHash");
        $this->loadModel("Login_Model","admin");
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $this->FormValidator->addValidation("username","req","Hey! thats not fair! tell me your username!");
            $this->FormValidator->addValidation("password","req","Will you please tell me your password.");
            
            if($this->FormValidator->ValidateForm()) {
               
                if($this->_validateCredentials($_POST['username'], $_POST['password'])===false);{
                   $this->data["form_error_message"] = array("account" => "Sorry Bitch!!! Wrong Username and Password!");
                }
                
            } else {
                $this->data["form_error_message"] = $this->FormValidator->GetErrors();
            } 
        }
        
        $this->data["calendar"] = $this->SimpleCalendar->show();
        $this->data["test"] = "THIS IS A SAMPLE TESTING!!!";
        $pages = array('admin/login');
        $this->view->render($pages, $this->data);
    }    
    
    private function _validateCredentials(){
        if($this->Login_Model->can_login()){
            header('location: '.URL.'admin/main');
        }
        else return false;
    }

}
?>

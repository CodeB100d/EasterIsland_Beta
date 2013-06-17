<?php
class Controller {

    public $data = null;

    public function __construct($autoloads = array()) {
        //echo 'Main controller<br />';
        //
        //Initiate View inside the controller
        $this->view = new View();

        //Check for Autoload Utilities
        $this->_autoLoader($autoloads);
        //var_dump($autoloads);
        //$this->form_validate = new FormValidator();
        //$this->pagination = new Zebra_Pagination();
        //$this->calendar = new SimpleCalendar();
        //$this->encrypt = new PasswordHash(8, FALSE);
    }

    /*
     * The reason why the loaders are separate in case it will be use in an independent call
     */

    //Load Models
    public function loadModel($name, $path = null) {
        if (!empty($path))
            $path .= "/";

        $path = APP_PATH_MODEL . $path . strtolower($name) . '.php';

        if (file_exists($path)) {
            require $path;
            $this->$name = new $name();
            return true;
        }
        else
            return false;
    }

    //Load Utilities
    public function loadUtils($name, $path = null) {
        if (!empty($path))
            $path .= "/";

        $path = UTILS . $path . $name . '.php';

        if (file_exists($path)) {
            require $path;
            $this->$name = new $name();
            return true;
        }
        else
            return false;
    }

    //Load Controller
    public function loadController($name, $path = null) {
        if (!empty($path))
            $path .= "/";

        $path = APP_PATH_CONTROLLER . $path . $name . '.php';

        if (file_exists($path)) {
            require $path;
            $this->$name = new $name();
            return true;
        }
        else
            return false;
    }
    //Load Session
    public function loadSession(){
       require UTILS . 'Session.php';
       $this->Session = new Session(SESSION_TYPE,SESS_TMP_FILE_PATH,SESS_MEMCACHED_HOST,SESS_MEMCACHED_PORT, SESS_NAME, SESS_TABLE_NAME, DB_HOST, DB_USER, DB_PASS, DB_NAME);
         session_start();
       return;
    }
    public function unloadSession(){
       session_destroy();
    }
    private function _autoLoader($autoload) {
        $loaderFunc = "";
        foreach ($autoload as $loadName => $loadValue) {
            switch ($loadName) {
                case "utils":
                    $loaderFunc = "loadUtils";
                    break;
                case "model":
                    $loaderFunc = "loadModel";
                    break;
                case "controller":
                    $loaderFunc = "loadController";
                    break;
            }
            foreach ($loadValue as $l) {
                if ($this->$loaderFunc($l) == false) {
                    die("Easter Island cannot find the file <strong>$l</strong> in your $loadName directory.");
                }
            }
        }
    }

}
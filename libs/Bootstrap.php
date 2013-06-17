<?php
class Bootstrap {

    private $_url = null;
    private $_controller = null;
    private $_autoloads = array();
    private $_cstart = 0;
    private $_controllerPath = null; // Always include trailing slash
    private $_errorControllerPath = null; // Always include trailing slash
    //private $_modelPath = 'app/models/'; // Always include trailing slash
    //private $_errorFile = 'error.php';
    //private $_defaultFile = 'main.php';
    /**
     * Simula ng bootstrap
     * 
     * @return boolean
     */
    public function init()
    {
        //Initiate M-V-C
        $this->_mvcLoader();
        
        //Initialize natin yung mga configurations
        $d = opendir( APP_PATH_CONFIG );
         while( false !== ( $f = readdir ( $d ) ) ) {
                 $fName = APP_PATH_CONFIG . $f;
                 if( is_file ( $fName ) ) {
                     require_once ( $fName ) ;
                 }
         }
        //assign the autoloads
        //$this->_autoloads = $autoload;
        require(LIBS."Config.php");
        // Kelangan mong isset yung URL at gawing protected
        $this->_getUrl();
        $this->_autoloads = $autoload;
        // Load the default controller if no URL is set
        // eg: Visit http://localhost it loads Default Controller
        $defaultFileName = basename($this->_defaultFile, ".php"); 
        if (empty($this->_url[0]) or $this->_url[0] == $defaultFileName) {
            $this->_url[0] = $defaultFileName;
        }

        $this->_loadExistingController();
        $this->_callControllerMethod();
    }

    /**
     * (Optional) Set a custom path to controllers
     * @param string $path
     */
    public function setControllerPath($path)
    {
        $this->_controllerPath = trim($path, '/') . '/';
        $this->_errorControllerPath = $this->_controllerPath;
    }
    
    /**
     * (Optional) Set a custom path to models
     * @param string $path
     */
    public function setModelPath($path)
    {
        $this->_modelPath = trim($path, '/') . '/';
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: error.php
     */
    public function setErrorFile($path)
    {
        $this->_errorFile = trim($path, '/').".php";
    }
    
    /**
     * (Optional) Set a custom path to the error file
     * @param string $path Use the file name of your controller, eg: index.php
     */
    public function setDefaultFile($path)
    {
        $this->_defaultFile = trim($path, '/').".php";
    }
    
    /**
     * Fetches the $_GET from 'url'
     */
    private function _getUrl()
    {
        //var_dump($_GET['url']);
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $url);
    }
    
    /**
     * Load an existing controller if there IS a GET parameter passed
     * 
     * @return boolean|string
     */
    private function _loadExistingController()
    {
       $dir = null;
        if( $this->_checkIfDir( $this->_url[0] ) ) {
           
           $dir = $this->_url[0];
           
           $this->_controllerPath .= $this->_url[0]."/";
           unset($this->_url[0]);
           $this->_url = array_values($this->_url);
           
           if( !empty ( $this->_url[0] )){
               if( $this->_checkIfDir( $this->_url[ 0 ] ) ){
                  $this->_controllerPath .= $this->_url[0];
                  unset($this->_url[0]);
                  $this->_url = array_values($this->_url);
               }
           }
        }
      
        $page = null;
        if( isset ( $this->_url[0] ) )
           $page = $this->_url[0] ;
        else{              
           include(APP_PATH_CONFIG."routing.php");
           if(isset($route[$dir])){
            $page = $route[$dir];
           }else{  
            $this->_error();
            return false;
           }
        }
        
        $file = $this->_controllerPath . $page . '.php';
        //var_dump($this->_url);
        if (file_exists($file)) {
            require $file;
            $this->_controller = new $page($this->_autoloads);
            //$this->_controller->loadModel($this->_url[0], $this->_modelPath);
        } else {
            $this->_error();
            return false;
        }
    }
    
    /**
     * If a method is passed in the GET url paremter
     * 
     *  http://localhost/controller/method/(param)/(param)/(param)
     *  url[0] = Controller
     *  url[1] = Method
     *  url[2] = Param
     *  url[3] = Param
     *  url[4] = Param
     */
    private function _callControllerMethod()
    {
        $length = count($this->_url);

        // Make sure the method we are calling exists
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_url[1])) {
                $this->_error();
            }
        }
        
        // Determine what to load
        switch ($length) {
            case 5:
                //Controller->Method(Param1, Param2, Param3)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3], $this->_url[4]);
                break;
            
            case 4:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2], $this->_url[3]);
                break;
            
            case 3:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}($this->_url[2]);
                break;
            
            case 2:
                //Controller->Method(Param1, Param2)
                $this->_controller->{$this->_url[1]}();
                break;

            default:
                $this->_controller->{"index"}();
                break;
        }
    }
    
    /**
     * Display an error page if nothing exists
     * 
     * @return boolean
     */
    private function _error() {
        require $this->_errorControllerPath . $this->_errorFile;
        $this->_controller = new Error();
        $this->_controller->index();
        return false;
    }
    //MVC Foundation Loader
    private function _mvcLoader(){
        //Initialize natin yung mga configurations
       $lib = opendir( LIBS );
       while( false !== ( $l = readdir ( $lib ) ) ) {
               $lName = LIBS . $l;
               if( is_file ( $lName ) && $l != 'Bootstrap.php' && $l != 'Config.php') {
                   require_once ( $lName ) ;
               }
       }
       require_once (APP_PATH."crux/EI_Controller.php");
    }
    private function _checkIfDir($dir){
      $path = APP_PATH_CONTROLLER; // '.' for current
      foreach (new DirectoryIterator($path) as $file)
      {
          if($file->isDot()) continue;

          if( $file->isDir())
          {
              if( $file->getFilename() == $dir)
                 return true;
          }
      }    
    }
}
<?php

class View {
  
    function __construct() {
        //echo 'this is the view';
    }

    public function render($pages,$data=array())
    {
        if( ! empty ( $data ) ) 
        {
            foreach($data as $d => $dVal)
            {
               $$d = $dVal;
            }
        }
        //for($x=0; $x < count($pages); $x++) if(!file_exists(APP_PATH_VIEW . $pages[$x] . '.php')) $y++;
            //if($noInclude) require APP_PATH . 'views/header.php';
            foreach($pages as $p){
                if(file_exists(APP_PATH_VIEW . $p . '.php')) require APP_PATH_VIEW . $p . '.php';
                else die("Easter Island cannot find the <strong>". $p . "</strong> file for view.");
            }
            //if(!empty($page_error)) echo '<p>Unable to load</p>'.$page_error;
            //if($noInclude) require APP_PATH . 'views/footer.php';
    }
    
    public function loadFunc($name){
        $path = APP_PATH_FUNCTION . $name.'.php';
        
        if (file_exists($path)) {
            require APP_PATH_FUNCTION .$name.'.php';
             return true;
        }
        else die("Cannot Load the function <strong>$name</strong>.");       
    }

    public function __set($name, $value) {
        die("Cannot add new property \$$name to instance of " . __CLASS__);
    }
     
    
}
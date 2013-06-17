<?php
class Main extends EI_Controller{
    
   function index() {
         //$this->view->calendar = $this->calendar->show();
         $pages = array('headers/index_header','index','footers/index_footer');
         $this->view->render($pages, false);
    }
    public function blahblah(){
       echo "blah blah";
    }
	public function churva($arg1=null){
		echo "Blah blah".$arg1;
	}	
}
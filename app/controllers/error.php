<?php

class Error extends Controller {

    function __construct() {
        parent::__construct();
    }
    
    function index() {
        //$this->view->page_title = '404 Page not found'; //->custom page_title
        //$this->view->msg = 'Are you lost? I\'m very sory but the page you are looking for does not exist.'; //-> custom body for error
        $page = array('error/index');
        $this->view->render($page, false);
        exit();
    }
}
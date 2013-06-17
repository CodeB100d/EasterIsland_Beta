<?php

class Pages extends EI_Controller {

    function __construct() {
        parent::__construct();
        $this->loadModel("Login_Model", "admin");
        $this->Login_Model->check_if_logged_in();
    }

    function index() {
        $pages = array(
            'admin/headers/default',
            'admin/sidebar',
            'admin/pages',
            'admin/footers/default');
        $this->data['parent_page'] = $this->getUriSegment(3);
        $this->view->render($pages, $this->data);
    }
    
    function manage_templates(){
        $pages = array(
            'admin/headers/pages_header',
            'admin/sidebar',
            'admin/manage_templates',
            'admin/footers/default');
        $this->data['parent_page'] = $this->getUriSegment(3);
        
        //pagination
        $this->loadUtils("Zebra_Pagination");
        $records_per_page = 1;
        $pagination = new Zebra_Pagination();
        $pagination->base_url="pages/manage_templates/";
        $pagination->uri_segment = 5;
        $pagination->records(3);
        $pagination->records_per_page($records_per_page);
        //--->
        $this->loadModel("pages_model","admin");
        $this->data['templates'] = $this->pages_model->get_templates($pagination->get_page(), $records_per_page);
        $this->data['page_link'] = $pagination->render();
        $this->view->render($pages, $this->data);
    }

    function add_page_template() {

        $this->loadUtils("FormValidator");

        if (isset($_POST['save_file'])) {
            $this->FormValidator->addValidation("template_title", "req", "Please enter template title.");
            if ($this->FormValidator->ValidateForm()) {
                //do upload here
                //initialize
                $this->loadUtils("FileUpload");
                if (count($_FILES) > 0) {
                    $fileUpload = new FileUpload(array('naming' => 'random')); // All properties can be set on stand-alone lines or within an array when instantiating the FileUpload object
                    $fileUpload->file = $_FILES['template_file'];
                    $fileUpload->target_path = 'public/uploads/';
                    $fileUpload->allow = array('php');
                    $fileUpload->max_filesize = 500; //kb
                    if ($fileUpload->upload_file()) {
                        $this->loadModel("Pages_model","admin");
                        $this->Pages_model->add_template($_POST['template_title'], $fileUpload->file['name']);
                        $this->data["success_msg"] = 'New template added';
                    }
                    else
                        $this->data["upload_error"] = $fileUpload->file['error'];
                }
            } else {
                $this->data["title_error"] = $this->FormValidator->GetErrors();
            }
        }

        $pages = array(
            'admin/headers/pages_header',
            'admin/sidebar',
            'admin/add_page_template',
            'admin/footers/pages_footer');

        $this->data['parent_page'] = $this->getUriSegment(3);
        $this->view->render($pages, $this->data);
    }

    function sample($var = NULL) {
        var_dump($var);
    }

}

?>

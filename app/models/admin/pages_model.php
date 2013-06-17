<?php

class Pages_Model extends Model {
    
    function add_template($title, $file){
        Session::init();
        $data = array(
            'title'=>$title,
            'file'=>$file,
            'user_id'=>Session::get('userid')
        );
        $this->db->insert('templates', $data);
    }
    
    function count_all_templates(){
        
    }


    function get_templates($page, $records_per_page){
        $limit = (!empty($page))?(($page - 1) * $records_per_page).', ':'';
        return $this->db->select('SELECT templates.*, users.* FROM templates, users WHERE templates.user_id = users.id ORDER BY templates.user_id DESC LIMIT '.$limit.$records_per_page);
    }
}

?>

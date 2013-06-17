<?php

class Model {

    function __construct() {
       if(DB_AUTOLOAD) $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }
    public function loadDatabase($db_type = DB_TYPE, $db_host = DB_HOST, $db_name = DB_NAME, $db_pass = DB_PASS){
       return new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

}
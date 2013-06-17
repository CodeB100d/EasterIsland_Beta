<?php
function set_value($name, $val=NULL){
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        return $_POST[$name];
    }else{
        return $val;
    }
}
?>
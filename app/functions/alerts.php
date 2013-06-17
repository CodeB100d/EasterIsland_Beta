<?php
function success_alert($msg=NULL){
    return '<div class="alert alert-success"><i class="icon-ok"></i> <button type="button" class="close" onclick="$(this).parent().slideUp(200)">&times;</button>'.$msg.'</div>';
}
function error_alert($msg=NULL){
    return '<div class="alert alert-error"><i class="icon-exclamation-sign"></i> <button type="button" class="close" onclick="$(this).parent().slideUp(200)">&times;</button>'.$msg.'</div>';
}
function default_alert($msg=NULL){
    return '<div class="alert"><i class="icon-exclamation-sign"></i> <button type="button" class="close" onclick="$(this).parent().slideUp(200)">&times;</button>'.$msg.'</div>';
}
function info_alert($msg=NULL){
    return '<div class="alert alert-info"><i class="icon-question-sign"></i> <button type="button" class="close" onclick="$(this).parent().slideUp(200)">&times;</button>'.$msg.'</div>';
}
?>
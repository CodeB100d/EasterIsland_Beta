<?php

/**
 * @author Ben Cooling <office@bcooling.com.au> 
 * @package cl
 * @subpackage cl_FileUpload
 * @license http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 */

/**
 * <b>File Upload</b>
 * 
 * Upload files easily. Allow or deny specific files by their extention. Force
 * filesnames to be unique or allow copies or produce random unique names.
 *
 * @package cl
 * @subpackage cl_FileUpload
 * @author Ben Cooling <office@bcooling.com.au> 
 * @version 0.1
 *
 */
class FileUpload {

    private $file;
    private $file_ext;
    private $target_path = 'uploads/';
    private $naming = 'unique';
    private $max_filesize = NULL;
    private $allow = false;
    private $deny = false;
    private $new_name = NULL;

    public function __set($name, $value) {
        if ($name == 'file_ext')
            return false;
        if ($name == 'naming' && $this->check_naming($value) == false)
            return false;
        if ($name == 'file') {
            $file_arr = explode('.', $value['name']);
            $this->file_ext = end($file_arr);
        }
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __construct($config = null) {
        if (is_array($config))
            foreach ($config as $k => $v) {
                if (isset($this->$k))
                    $this->$k = $v;
            }
    }

    public function upload_file() {
        switch ($this->naming) {
            case 'copies':
                if (file_exists($this->target_path . $this->file['name'])) {
                    $file_arr = explode('.', $this->file['name']);
                    $this->file['name'] = $file_arr[0] . ' copy.' . $this->file_ext;
                    if (file_exists($this->target_path . $this->file['name']))
                        $this->file['name'] = $file_arr[0] . ' copy 2.' . $this->file_ext;
                    if (file_exists($this->target_path . $this->file['name']))
                        $this->increment_copy();
                }
                break;
            case 'random':
                $this->generate_random();
                break;
            default: // unique
                if (file_exists($this->target_path . $this->file['name'])) {
                    $this->file['error'] = 'The filename already exists';
                    return false;
                }
        }
        if (!$this->check_ext())
            $this->file['error'] = 'Invalid file';

        if ($this->max_filesize != NULL) {
            $max_size = $this->max_filesize * 1024;
            if ($this->file['size'] > $max_size)
                $this->file['error'] = 'The file size exceeds the maximum size';
        }

        if ($this->file['error'] !== 0)
            return false;

        move_uploaded_file($this->file['tmp_name'], $this->target_path . $this->file['name']);
        return true;
    }

    private function generate_random($len = 32) {
        $str = md5(uniqid(rand(), true));
        $this->file['name'] = substr($str, 0, $len) . '.' . $this->file_ext;
        if (file_exists($this->target_path . $this->file['name']))
            $this->generate_random();
        else
            return true;
    }

    private function increment_copy() {
        $file_arr = explode('.', $this->file['name']);
        $cur_number = substr($file_arr[0], -1);
        $cur_name = substr($file_arr[0], 0, -1);
        $cur_number = $cur_number + 1;
        $this->file['name'] = $cur_name . $cur_number . '.' . $this->file_ext;
        if (file_exists($this->target_path . $this->file['name']))
            $this->increment_copy();
    }

    private function check_naming($value) {
        $naming_arr = array('copies', 'random', 'unique');
        if (in_array($value, $naming_arr))
            return true;
        else
            return false;
    }

    private function check_ext() {
        if (is_array($this->deny)) {
            if (in_array($this->file_ext, $this->deny))
                return false;
            else
                return true;
        }
        if (is_array($this->allow)) {
            if (in_array($this->file_ext, $this->allow))
                return true;
            else
                return false;
        }
    }
   
}
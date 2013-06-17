<?php
class Session {
    protected $savePath;
    protected $sessionName;
    protected $sessionTable;
    protected $DBH;
    
    public function __construct($type="native", $path=null, $memcached_host=null, $memcache_port=null, $session_name=null, $sessionTable=null, $host, $user, $pass, $dbname) {
       session_name($session_name);
       $this->savePath = $path;
       switch($type){
          case "native":
               session_save_path($path); //sess_tmp_file_path
               break;
          case "memcached":
               session_set_save_handler("memcached");
               $memcache = new Memcached;
               $memcache->connect($memcached_host, $memcache_port) or die ("Could not connect to memcached host");                      break;
          case "database":
               $this->sessionTable = $sessionTable;
               try {
                  # MySQL with PDO_MYSQL
                  $this->DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
               }
               catch(PDOException $e) {
                   die($e->getMessage());
               }

               session_set_save_handler(
                   array($this, "open"),
                   array($this, "close"),
                   array($this, "read"),
                   array($this, "write"),
                   array($this, "destroy"),
                   array($this, "gc")
               );
               break;
       }
    }

    public function open($savePath, $sessionName) {
        $this->savePath = $savePath;
        $this->sessionName = $sessionName;
        return true;
    }

    public function close() {
        // your code if any
        return true;
    }

    public function read($sess_id) {
        $read = $this->DBH->prepare("SELECT Data FROM ".$this->sessionTable." WHERE SessionID = :sessid;") or die(mysql_error());
        $read->bindParam(":sessid", $sess_id);
        $read->execute();
        $result = $read->fetch(PDO::FETCH_OBJ);
        $CurrentTime = time();
        if (!$read->rowCount()) {
            $ins = $this->DBH->prepare("INSERT INTO ".$this->sessionTable." (SessionID, DateTouched) VALUES (:sessid, :currenttime);");
            $ins->bindParam(":sessid", $sess_id);
            $ins->bindParam(":currenttime", $CurrentTime);
            $ins->execute();
            return '';
        } else {
            //extract(mysql_fetch_array($result), EXTR_PREFIX_ALL, 'sess');
            //mysql_query("UPDATE ".$this->sessionDbase." SET DateTouched = $CurrentTime WHERE SessionID = '$sess_id';");
            
            $up = $this->DBH->prepare("UPDATE ".$this->sessionTable." SET DateTouched = :currenttime WHERE SessionID = :sessid;");
            $up->bindParam(":sessid", $sess_id);
            $up->bindParam(":currenttime", $CurrentTime);
            $up->execute();
            return $result->Data;
        }       
        // your code
    }

    public function write($sess_id, $data) {
        $CurrentTime = time();
        $write = $this->DBH->prepare("UPDATE ".$this->sessionTable." SET Data = :data, DateTouched = :currtime WHERE SessionID = :sessid;");
        $write->bindParam(":sessid", $sess_id);
        $write->bindParam(":currtime", $CurrentTime);
        $write->bindParam(":data", $data);
        $write->execute();
        //mysql_query("UPDATE ".$this->sessionTable." SET Data = '$data', DateTouched = $CurrentTime WHERE SessionID = '$sess_id';");
        return true;       
        // your code
    }

    public function destroy($sess_id) {
        $des = $this->DBH->prepare("DELETE FROM ".$this->sessionTable." WHERE SessionID = :sessid");
        $des->bindParam(":sessid", $sess_id);     
        $des->execute();
        return true;
        //mysql_query("DELETE FROM ".$this->sessionTable." WHERE SessionID = '$sess_id';");
        // your code
    }

    public function gc($sess_maxlifetime) {
        $CurrentTime = time();
        $gc = $this->DBH->prepare("DELETE FROM ".$this->sessionTable." WHERE DateTouched + $sess_maxlifetime < $CurrentTime;");  
        $gc->execute();        
        //mysql_query("DELETE FROM ".$this->sessionTable." WHERE DateTouched + $sess_maxlifetime < $CurrentTime;");
        return true;       
        // your code
    }
}

//class Session {
//
//    public static function init() {
//        @session_start();
//    }
//
//    public static function set($key, $value) {
//        $_SESSION[$key] = $value;
//    }
//
//    public static function unset_data($key) {
//        unset($_SESSION[$key]);
//    }
//
//    public static function get($key) {
//        if (isset($_SESSION[$key]))
//            return $_SESSION[$key];
//        else
//            return false;
//    }
//
//    public static function destroy() {
//        session_destroy();
//    }
//
//}


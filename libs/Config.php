<?php
/*
 * Preparing all Configuration Fields to be defined
 */
if( isset ( $config ) ){
   foreach($config as $k => $v)
   {
      $cname = strtoupper ( $k );
      define( $cname, $v);
   }
} else {
   die ( "There is an error in the Configuration File." );
}

/*
 * Setting up the the Database Fields
 */
if( isset ($database ) ){
   foreach($database as $db => $dbval){
      $dbfields = strtoupper($db);
      define( $dbfields, $dbval);
   }
} else {
   die ( "There is an error in the Database Configuration Fields." );
}


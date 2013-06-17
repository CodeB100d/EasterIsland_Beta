<?php
/*
 * CONFIGURATION FILE: 
 * Changing the array configuration names will affect your whole program static variables.
 */

/*
 * Base Url
 */
$config['base_url'] = "http://localhost/EasterIsland_Alpha/";
/*
 * Character Set Path
 */
$config['charset'] = 'UTF-8';
/*
 * Cache Path
 */
$config['cache_path'] = 'database';
/* 
 * Encryption Configuration
 */
$config['hash_general_key'] = "MixitUp200";
$config['hash_password_key'] = "catsFLYhigh2000miles";
/*
 * Session Configuration
 * Session Settings can change to different values
 * memcached = install memcache in your apache server
 * native
 * database
 */

$config['session_type'] = "database";

$config['sess_expiration']	= 7200;
$config['sess_expire_on_close']	= TRUE;
$config['sess_name'] = "phpei";
//set table name if session type is database
$config['sess_table_name'] = 'ei_sessions';
$config['sess_security'] = TRUE;
$config['sess_time_to_update']	= 300;
//set file path if session type is native
$config['sess_tmp_file_path'] = "/var/www/EasterIsland_Alpha/app/cache";
//session settings for memcached, if using memcache use tcp as prefix
$config["sess_memcached_host"] = "locahost" ; 
$config["sess_memcached_port"] = "11211" ; 
/*
 * Cross Site Scripting Filtering
 */
$config['global_xss_filtering'] = TRUE;
/*
 * Cross Site Request Forgery
 */
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_ei_';
$config['csrf_cookie_name'] = 'csrf_ei_';
$config['csrf_expire'] = 7200;
/*
 * Time Reference Local
 */
$config['time_reference'] = 'local';
<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

define('PHP_LOG_STORAGE_TYPE','file');

spl_autoload_register(function($name){
    $namespace = array(
        'PhpLog\Library'=>PHP_LOG_ROOT_DIR.'library/',
        'PhpLog\Storage'=>PHP_LOG_ROOT_DIR.'storage/',
        'PhpLog'=>PHP_LOG_ROOT_DIR,
        'PhpLog\Virtual'=>PHP_LOG_ROOT_DIR.'interface/',
    );
    $splitPoint = strrpos(trim($name,"\\"), "\\");
    if($splitPoint){
        $_namespace = substr($name, 0, $splitPoint);
        if(!isset($namespace[$_namespace])){
            throw new Exception('please config the dir of '.$_namespace);
        }
        $dir = $namespace[$_namespace];
        $fileName = $dir.trim(substr($name, $splitPoint), "\\").'.php';
        if(file_exists($fileName)){
            require_once $fileName;
        }
    }

});
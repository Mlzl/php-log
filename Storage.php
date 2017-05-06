<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog;


use PhpLog\Storage\FileHandle;
use PhpLog\Storage\RedisHandle;
use PhpLog\Virtual\IHandle;

class Storage implements IHandle{
    private $handle;
    public function __construct($name){
        switch (strtolower(PHP_LOG_STORAGE_TYPE)){
            case 'redis':
                $this->handle = new RedisHandle($name);
                break;
            default :
                $this->handle = new FileHandle($name);
                break;
        }
    }
    public function clear(){
        $this->handle->clear();
    }
    public function push($message){
        $this->handle->push($message);
    }
    public function write(){
        $this->handle->write();
    }
}
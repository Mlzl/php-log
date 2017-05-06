<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Storage;


use PhpLog\Virtual\IHandle;

class RedisHandle implements IHandle  {
    private $handle;
    private $content = array();
    private $queueName = '';
    public function __construct($queueName){
        $this->initCheck();
        $this->handle = new \Redis();
        $this->handle->connect(PHP_LOG_REDIS_HOST, PHP_LOG_REDIS_PORT);
        $this->queueName = $queueName;
        if(!$this->handle){
            throw new \Exception("connect redis error,socket:".
                PHP_LOG_REDIS_HOST.PHP_LOG_REDIS_PORT);
        }
    }

    private function initCheck(){
        if(!extension_loaded('redis')){
            throw new \Exception('extension redis is not found');
        }
    }

    public function push($message){
        $this->content[] = $message;
    }
    public function write(){
        foreach ($this->content as $message){
            $this->handle->rPush($this->queueName, $message);
        }
        $this->clear();
    }
    public function clear(){
        $this->content = array();
    }
    public function __destruct(){
        $this->handle->close();
    }
}
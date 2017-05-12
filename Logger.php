<?php
namespace PhpLog;
use PhpLog\Library\Common;
use PhpLog\Library\Constant;
use PhpLog\Library\Content;
use PhpLog\Library\Formatter;
use PhpLog\Virtual\ILog;
use PhpLog\Storage\FileHandle;
use PhpLog\Storage\RedisHandle;
use PhpLog\Virtual\IHandle;

date_default_timezone_set('PRC');
defined('PHP_LOG_ROOT_DIR') or define('PHP_LOG_ROOT_DIR',dirname(__FILE__).'/');
require_once PHP_LOG_ROOT_DIR.'init.php';
/**
 * User: ambi
 * Date: 2017/4/9
 */
class Logger implements ILog {
    private $formatter;
    private $storage;
    private $startTransaction = false;
    private $level = 0;

    public function __construct($filePath){
        $this->storage = new Storage($filePath);
        $this->formatter = new Formatter("[%date%][%point%][%pid%] %message%");
        $this->formatter->setDateFormat('Y-m-d H:i:s');
    }

    /**
     * @param Formatter $formatter
     * 设置格式
     */
    public function setFormatter(Formatter $formatter){
        $this->formatter = $formatter;
    }

    /**
     * @param $type
     * @return bool
     * 判断当前日志级别是否可写
     */
    private function isWrite($type){
        return $this->level < Constant::LEVEL[$type];
    }

    /**
     * @param $message
     * @param $type
     * @return bool
     * 预处理消息体
     */
    private function preWrite($message, $type){
        if(!$this->isWrite($type)){
            return true;
        }
        $content = new Content($this->formatter);
        $data = array(
            'point'=>Common::getRecordPoint(),
            'type'=>$type,
            'pid'=>Common::getProcessId(),
            'message'=>$message,
            'date'=>date($this->formatter->getDateFormat())
        );
        $content->setData($data);
        $this->storage->push($content);
        $this->write();
        return true;
    }

    /**
     * 写入载体
     */
    private function write(){
        if(!$this->startTransaction){
            $this->storage->write();
        }
    }

    /**
     * @param $level
     * 设置日志级别 此级别以上日志会被记录
     */
    public function setLevel($level){
        $this->level = $level;
    }

    /**
     * @param $message
     * write a log which type is debug
     */
    public function debug($message){
        $this->preWrite($message, Constant::DEBUG);
    }

    /**
     * @param $message
     * write a log which type is info
     */
    public function info($message){
        $this->preWrite($message,Constant::INFO);
    }

    /**
     * @param $message
     * write a log which type is warning
     */
    public function warning($message)
    {
        $this->preWrite($message,Constant::WARNING);
    }

    /**
     * @param $message
     * write a log which type is error
     */
    public function error($message){
        $this->preWrite($message,Constant::ERROR);
    }

    /**
     * @param $message
     * write a log which type is exception
     */
    public function exception($message)
    {
        $this->preWrite($message,Constant::EXCEPTION);
    }

    /**
     * @param $message
     * write a log which type is alert
     */
    public function alert($message){
        $this->preWrite($message,Constant::ALERT);
    }

    /**
     * start a transaction
     */
    public function startTransaction(){
        $this->startTransaction = true;
    }

    /**
     * submit current transaction
     */
    public function submit(){
        $this->startTransaction = false;
        $this->storage->write();
    }

    /**
     * cancel current transaction
     */
    public function cancel(){
        $this->storage->clear();
    }
}



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

    /**
     * clear stream on storage
     */
    public function clear(){
        $this->handle->clear();
    }

    /**
     * @param $message
     * push a log stream to sotorage
     */
    public function push($message){
        $this->handle->push($message);
    }

    /**
     * write log
     */
    public function write(){
        $this->handle->write();
    }
}

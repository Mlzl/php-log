<?php
namespace PhpLog;
use PhpLog\Library\Common;
use PhpLog\Library\Constant;
use PhpLog\Library\Content;
use PhpLog\Library\Formatter;
use PhpLog\Virtual\ILog;

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

    public function setFormatter(Formatter $formatter){
        $this->formatter = $formatter;
    }

    private function isWrite($type){
        return $this->level < Constant::LEVEL[$type];
    }

    public function preWrite($message, $type){
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

    public function write(){
        if(!$this->startTransaction){
            $this->storage->write();
        }
    }

    public function setLevel($level){
        $this->level = $level;
    }

    public function debug($message){
        $this->preWrite($message, Constant::DEBUG);
    }

    public function info($message){
        $this->preWrite($message,Constant::INFO);
    }

    public function warning($message)
    {
        $this->preWrite($message,Constant::WARNING);
    }

    public function error($message){
        $this->preWrite($message,Constant::ERROR);
    }

    public function exception($message)
    {
        $this->preWrite($message,Constant::EXCEPTION);
    }

    public function alert($message){
        $this->preWrite($message,Constant::ALERT);
    }

    public function startTransaction(){
        $this->startTransaction = true;
    }

    public function submit(){
        $this->startTransaction = false;
        $this->storage->write();
    }

    public function cancel(){
        $this->storage->clear();
    }
}


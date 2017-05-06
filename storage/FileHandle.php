<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Storage;


use PhpLog\Virtual\IHandle;

class FileHandle implements IHandle  {
    private $handle;
    private $content = '';
    public function __construct($filename){
        $this->initCheck($filename);
        $this->handle = fopen($filename, 'a');
        if(!$this->handle){
            throw new \Exception('open file error.filename is '.$filename);
        }
    }

    private function initCheck($filename){
        if(file_exists($filename)){
            return true;
        }
        $pathInfo = pathinfo($filename);

        if(isset($pathInfo['dirname']) && !file_exists($pathInfo['dirname'])){
            mkdir($pathInfo['dirname'], 0777, true);
        }
        return true;
    }

    public function push($message){
        $this->content .= $message;
    }
    public function write(){
        fwrite($this->handle, $this->content);
        $this->clear();
    }
    public function clear(){
        $this->content = '';
    }
    public function __destruct(){
        fclose($this->handle);
    }
}
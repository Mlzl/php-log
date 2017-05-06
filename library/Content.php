<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Library;


class Content{
    private $content = '';
    private $data = array();
    private $formatter;
    public function __construct(Formatter $formatter){
        $this->formatter = $formatter;
    }
    public function __toString()
    {
        $formatList = Formatter::FORMATTER;
        $this->content = strtolower($this->formatter->getFormat());
        foreach ($formatList as $_format){
            if(stripos($this->content, $_format)){
                $method = trim($_format, Formatter::SPLIT);
                $content = $this->$method;
                $this->content = str_replace($_format, $content, $this->content);
            }
        }
        return $this->content.PHP_EOL;
    }
    public function setData($data = array()){
        $this->data = $data;
    }

    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : $name;
    }

}
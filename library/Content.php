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
        $settingFormat = strtolower($this->formatter->getFormat());
        $this->content = preg_replace_callback('(\%.*?\%)',function ($match)use($formatList){
            if(in_array($match[0], $formatList)){
                $_format = $match[0];
                $method = trim($_format, Formatter::SPLIT);
                $content = $this->$method;
                return $content;
            }
            return $match[0];
        }, $settingFormat);
        return $this->content.PHP_EOL;
    }
    public function setData($data = array()){
        $this->data = $data;
    }

    public function __get($name){
        return isset($this->data[$name]) ? $this->data[$name] : $name;
    }

}
<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Library;


class Formatter{
    const FORMATTER = array(
        '%message%',
        '%type%',
        '%pid%',
        '%date%',
        '%point%',
    );

    const SPLIT = '%';
    private $format;

    private $dateFormat = 'Y-m-d h:i:s';
    /**
     * Formatter constructor.
     * @param $format
     */
    public function __construct($format){
        $this->format = $format;
    }

    public function setFormat($format){
        $this->format = $format;
    }

    public function getFormat(){
        return $this->format;
    }
    public function setDateFormat($dateFormat){
        $this->dateFormat = $dateFormat;
    }
    public function getDateFormat(){
        return $this->dateFormat;
    }
}
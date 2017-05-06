<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Library;


class Common{
    public static function getProcessId(){
        static $pid = 0;
        if($pid){
            return $pid;
        }
        $pid = intval(getmypid());
        return $pid;
    }

    public static function getRecordPoint(){
        $backtrace = debug_backtrace(2);
        $last_function = array();
        foreach($backtrace as $item){
            if(!isset($item['class']) || $item['class'] != __CLASS__){
                $callFunction = $item;
                break;
            }
            $callFunction = $item;
            $last_function = $item;
        }
        $line = isset($last_function['line']) ? $last_function['line'] : '';
        $file = isset($callFunction['file']) ? $callFunction['file'] : $callFunction['file'];
        return $file.' '. $line;
    }
}
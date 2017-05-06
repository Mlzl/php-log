<?php
namespace PhpLog\Virtual;
/**
 * User: ambi
 * Date: 2017/4/9
 */
Interface ILog{

    public function debug($message);

    public function info($message);

    public function warning($message);

    public function exception($message);

    public function alert($message);

    public function error($message);

    public function startTransaction();

    public function submit();

    public function cancel();

    public function setLevel($level);

}
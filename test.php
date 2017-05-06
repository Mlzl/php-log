<?php
require_once 'Logger.php';
use \PhpLog\Library\Formatter;
/**
 * User: ambi
 * Date: 2017/4/9
 */
function ss(){
    $log = new \PhpLog\Logger('log.txt');
    $formatter = new Formatter('');
    $formatter->setFormat('[%type%][%date%][%pid%][%point%] %message%');
    $formatter->setDateFormat('Y-m-d');
    $log->setFormatter($formatter);
    $log->startTransaction();
    $log->info('s');
    $log->submit();
}

ss();



<?php
require_once 'Logger.php';
/**
 * User: ambi
 * Date: 2017/4/9
 */
function ss(){
    $log = new \PhpLog\Logger('log.txt');
    $log->setLevel(\PhpLog\Library\Constant::INFO);
    $formatter = new \PhpLog\Library\Formatter('');
    $formatter->setFormat('[%type%][%date%][%pid%][%point%] %message%');
    $formatter->setDateFormat('Y-m-d');
    $log->setFormatter($formatter);
    $log->startTransaction();
    $log->info('i am info');
    $log->debug('i am debug');
    $log->exception('i am exception');
    $log->alert('i am alert');
    $log->error('i am error');
    $log->warning('i am warning');
    $log->submit();
    $log->startTransaction();
    $log->warning('i am warning.start transaction but not submit');
}

ss();



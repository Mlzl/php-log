<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Library;


class Constant
{
    const DEBUG = 'DEBUG';

    const INFO = 'INFO';

    const WARNING = 'WARNING';

    const ERROR = 'ERROR';

    const ALERT = 'ALERT';

    const LEVEL = array(
        self::DEBUG =>  8,
        self::INFO  =>  16,
        self::WARNING=> 32,
        self::ERROR =>  64,
        self::ALERT =>  128,
    );
}
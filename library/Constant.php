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

    const EXCEPTION = 'EXCEPTION';

    const ALERT = 'ALERT';

    const ERROR = 'ERROR';

    const LEVEL = array(
        self::DEBUG =>  8,
        self::INFO  =>  16,
        self::WARNING=> 32,
        self::ALERT =>  64,
        self::EXCEPTION => 128,
        self::ERROR =>  256,
    );
}
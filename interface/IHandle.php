<?php
/**
 * User: ambi
 * Date: 2017/4/9
 */

namespace PhpLog\Virtual;


Interface IHandle {
    public function push($message);

    public function clear();

    public function write();
}
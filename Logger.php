<?php
class Logger {

    static function info($message) {

    }

    static function warning($message) {

    }

    static function error($message) {
        error_log($message);
    }
}

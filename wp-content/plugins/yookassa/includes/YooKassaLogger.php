<?php


class YooKassaLogger
{
    const MESSAGE_TYPE = 3;

    const LEVEL_INFO = 'info';
    const LEVEL_WARNING = 'warning';
    const LEVEL_ERROR = 'error';

    public static function info($message)
    {
        self::log(self::LEVEL_INFO, $message);
    }

    public static function error($message)
    {
        self::log(self::LEVEL_ERROR, $message);
    }

    public static function warning($message)
    {
        self::log(self::LEVEL_ERROR, $message);
    }

    public static function log($level, $message)
    {
        $filePath = WP_CONTENT_DIR.'/yookassa-debug.log';
        $isDebugEnabled = get_option('yookassa_debug_enabled');
        if ($isDebugEnabled) {
            if ( ! file_exists($filePath)) {
                touch($filePath);
                chmod($filePath, 0644);
            }

            $messageFormatted = self::formatMessage($level, $message);
            error_log($messageFormatted, self::MESSAGE_TYPE, $filePath);
        }
    }

    private static function formatMessage($level, $message)
    {
        $date = date('Y-m-d H:i:s');

        return sprintf("[%s] [%s] Message: %s \r\n", $date, $level, $message);
    }
}
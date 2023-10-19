<?php

/**
 * Fired during plugin install.
 */
class YooKassaInstaller
{
    public static function log($level, $message)
    {
        $filePath = WP_CONTENT_DIR.'/yookassa-debug.log';
        if ( ! file_exists($filePath)) {
            touch($filePath);
            chmod($filePath, 0644);
        }

        $messageFormatted = self::formatMessage($level, $message);
        error_log($messageFormatted, 3, $filePath);
    }

    private static function formatMessage($level, $message)
    {
        $date = date('Y-m-d H:i:s');

        return sprintf("[%s] [%s] Message: %s \r\n", $date, $level, $message);
    }
}

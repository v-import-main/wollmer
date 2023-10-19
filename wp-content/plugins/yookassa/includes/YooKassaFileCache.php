<?php

class YooKassaFileCache
{
    private $expire;

    public function __construct($expire = 3600)
    {
        $this->expire = $expire;

        $this->checkCacheDir();

        $files = glob($this->getCacheDir() . '*');

        if ($files) {
            foreach ($files as $file) {
                $time = substr(strrchr($file, '.'), 1);

                if ($time < time()) {
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }
            }
        }
    }

    public function get($key)
    {
        $files = glob($this->getCacheDir() . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files) {
            $handle = fopen($files[0], 'r');

            flock($handle, LOCK_SH);

            $data = fread($handle, filesize($files[0]));

            flock($handle, LOCK_UN);

            fclose($handle);

            return json_decode($data, true);
        }

        return false;
    }

    public function set($key, $value)
    {
        $this->delete($key);

        $file = $this->getCacheDir() . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.' . (time() + $this->expire);

        $handle = fopen($file, 'w');

        flock($handle, LOCK_EX);

        fwrite($handle, json_encode($value));

        fflush($handle);

        flock($handle, LOCK_UN);

        fclose($handle);
    }

    public function delete($key)
    {
        $files = glob($this->getCacheDir() . preg_replace('/[^A-Z0-9\._-]/i', '', $key) . '.*');

        if ($files) {
            foreach ($files as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }
    }

    private function getCacheDir()
    {
        return WP_CONTENT_DIR . '/uploads/yookassa-cache/';
    }

    private function checkCacheDir()
    {
        $dir = $this->getCacheDir();
        if (!is_dir($dir)) {
            @mkdir($dir);
            file_put_contents($dir . '.htaccess', 'deny from all');
        }

        return is_dir($dir);
    }
}
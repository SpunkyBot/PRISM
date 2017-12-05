<?php

class Cache
{
    private $_cache_time;
    private $_cache_file;

    // Constructor takes the cachetime
    public function __construct($cachetime)
    {
        $folder = dirname(__DIR__) . '/cache';
        if (!file_exists($folder)) { mkdir($folder, 0777, true); }
        $this->_cache_time = strval($cachetime);
        $this->_cache_file = $folder . '/' . $_SERVER['PHP_SELF']; // Location to lookup or store cached file
    }

    public function checkCache()
    {
        // Check if the cached file is still fresh. If it is, serve it up and exit
        if (file_exists($this->_cache_file) && time() - $this->_cache_time < filemtime($this->_cache_file))
        {
            readfile($this->_cache_file); // The cached copy is still valid, read it into the output buffer
            exit;
        }
        // if there is either no file OR the file to too old, render the page and capture the HTML
        ob_start();
    }

    public function saveCache()
    {
        // Save the cached content to a file
        file_put_contents($this->_cache_file, ob_get_contents());
        ob_end_flush();
    }
}
?>

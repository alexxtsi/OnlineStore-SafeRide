<?php

namespace application\core;

/**
 * View class acts as an object wrapper for HTML pages with embedded PHP
 */
class View
{
    public $path;
    public $route;
    public $layout = 'default';

    public function __construct($route)
    {
        $this->route = $route;
        $this->path = $route['controller'] . '/' . $route['view'];
    }    
    /**
     * this function loads relevant view page with relevant layout
     *
     * @param  string $title title for the page
     * @param  array  $vars varibales for the page
     */
    public function render(string $title, $vars = [])
    {
        if (isset($vars['admin']))
            $this->layout = 'admin';
        //load current page view to $content
        ob_start();
        require 'application/views/' . $this->path . '.php';
        $content = ob_get_clean();
        require  'application/views/layouts/' . $this->layout . '.php'; # load layout

    }    
    /**
     * this function redirects to passed url
     *
     * @param  string $url
     */
    public function redirect($url)
    {
        header('location: ' . $url);
        exit;
    }    
    /**
     * this fanction load error page 
     */
    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'application/views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }
}

<?php

/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 29/03/2017
 * Time: 18:44
 * Main  Abstract Controller class
 */
abstract class controller
{
    protected $data = array();

    protected $view = "";


    public function redirect($url)
    {
        header("Location: /$url");
        exit;
        header("Connection: close");

    }

    public function renderView()
    {

    }
}
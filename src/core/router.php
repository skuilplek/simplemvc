<?php

class Router {

    private $model = 'shoppinglist'; //Defaul model
    private $action = 'browse'; //Default method
    private $id = 0; //Default id
    
    public function __construct() {
        //TODO Sanitize
        //TODO Autodetect _POST routes
        if(isset($_GET['ctrl']) && !empty($_GET['ctrl']))
            $this->model = $_GET['ctrl'];
        if (isset($_GET['action']) && !empty($_GET['action']))
            $this->action = $_GET['action'];
        if(isset($_GET['id']))
            $this->id = intval($_GET['id']);
    }

    public function render() {
        // echo 'Calling '.$this->model.'->'.$this->action;
        $class = new $this->model($this->id);
        $action = $this->action;
        return $class->$action();
    }


}
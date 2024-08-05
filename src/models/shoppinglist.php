<?php


class ShoppingList {

    private $id = 0;

    public function __construct($id = 0) {
        $this->id = $id;
    }

    public function browse() {
        $db = Database::obtain();
        $sql = "SELECT * FROM `shopping_list`";
        $entries = $db->query_array($sql);
        $view = viewFile('browse');
        include($view);
        exit;
    }

    public function add() {
        $name = '123213';
        $checked = null;
        $db = Database::obtain();
        $sql = "INSERT INTO `shopping_list` (`name`,`checked`) VALUES('" . $db->escape($name) . "','".$db->escape($checked)."')";
        $id = $db->query($sql);
        return $this->browse(); //TODO Redirect to prevent double form submission - or fix that issue
    }

    public function edit() {
        if(isset($_POST['name'])) {
            $name = $_POST['name']; 
            $validation = "/[^A-Za-z0-9]+/";
            $name = preg_replace($validation, "", $name);
            if(empty($name))
                $name = 'Invalid name - use only A-Za-z0-9';
            $db = Database::obtain();
            if($this->id > 0)
                $sql = "UPDATE `shopping_list` SET `name`='" . $db->escape($name) . "' WHERE `id`='".intval($this->id)."'";
            else 
                $sql = "INSERT INTO `shopping_list` (`name`) VALUES('".$db->escape($name)."')";
            $data = $db->query_var($sql);
            return $this->browse();//TODO Show msg of fail or success
        }

        $id = $this->id;
        $name = '';
        if($this->id > 0) {
            $db = Database::obtain();
            $sql = "SELECT `name` FROM `shopping_list` WHERE `id`='".intval($this->id)."'";
            $data = $db->query_var($sql);
            if(!empty($data)) {
                $name = $data;
            }
        }
        $view = viewFile('edit');
        include ($view);
        exit;
    }

    public function delete() {
        if ($this->id > 0) {
            $db = Database::obtain();
            $sql = "DELETE FROM `shopping_list` WHERE `id`='" . intval($this->id) . "'";
            $db->query($sql);
        }
        return $this->browse();
    }

    public function check() {
        if ($this->id > 0) {
            $db = Database::obtain();
            $sql = "SELECT `checked` FROM `shopping_list` WHERE `id`='" . intval($this->id) . "'";
            $checked = intval($db->query_var($sql));
            $checked = intval(!$checked);
            //UPDATE `shopping_list` SET `checked`=!checked will do too
            $sql = "UPDATE `shopping_list` SET `checked`='".$checked."' WHERE `id`='" . intval($this->id) . "'";
            $db->query($sql);
        }
        return $this->browse();
    }



}
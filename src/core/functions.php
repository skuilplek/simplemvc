<?php

function viewFile($name) {
    //TODO Check if file exists and return file or error file
    //Convert to 'n class that will handle rendering automatically
    return dirname(dirname(__FILE__)).'/views/'.$name.'.php';
}



function object_to_array($data) {
    if (is_array($data) || is_object($data)) {
        $result = array();
        foreach ($data as $key => $value)
            $result[$key] = object_to_array($value);
        return $result;
    }
    return $data;
}
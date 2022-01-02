<?php

function __autoload($class){
    try {
        if (strHas($class, "Controller", true)) {
            $cnt = strtolower(str_replace("Controller", '', $class));
            require_once(getcwd() . '/mvc/controller/' . $cnt . '.php');
            return;
        }
    }catch (Exception $e){
        echo $e->getMessage();
        exit;
    }

    try {
        if (strHas($class, "Model", true)) {
            $cnt = strtolower(str_replace("Model", '', $class));
            require_once(getcwd() . '/mvc/model/' . $cnt . '.php');
            return;
        }
    }catch (Exception $e){
        echo $e->getMessage();
    }

}

?>
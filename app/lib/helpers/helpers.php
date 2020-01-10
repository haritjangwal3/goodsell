<?php 
    // Display and Die
    function dnd($data){
        echo '<pre>';
        var_dump($data);
        echo '<pre>';
        die();
    }


    function sanitize($value){
        return htmlentities($value, ENT_QUOTES, 'UTF-8');
    }

    function currentUser(){
        return Users::currentLoggedInUser();
    }

    function Clog($var){
        if(is_object($var))
        {
            $json =  @json_encode($var);
            echo "<script type='text/javascript'>console.log(" . $json .");</script>";
        }
        else {
            
            echo "<script>console.log('Debug Objects: " . strval($var) . "' );</script>";
        }
        die();
    }

    function posted_values($posted_values){
        $clean_array = [];
        foreach ($posted_values as $key => $value){
            $clean_array[$key] = sanitize($value);
        }
        return $clean_array;
    }
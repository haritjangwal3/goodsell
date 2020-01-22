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
        return User::currentLoggedInUser();
    }

    function echo_p($val, $val2 = '', $val3 = ''){
        $ary = [$val, $val2, $val3];
        foreach($ary as $val){
            echo '<pre>';
            if($val != ''){
                
                var_dump($val);
                
            }
            echo '</pre>';
        }
        
    }

    function JSalert($value){
        if(is_object($value) || is_array($value))
        {
            $json =  @json_encode($value);
            echo "<script type='text/javascript'>alert(" . $json .");</script>";
        }
        else {
            
            echo "<script>alert('Debug Objects: " . strval($value) . "' );</script>";
        }
    }

    function Clog($var){
        if(is_object($var) || is_array($var))
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

    
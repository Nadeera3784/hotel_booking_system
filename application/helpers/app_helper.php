<?php
if (!function_exists('is_session_exist')){
    
function is_session_exist($key, $current_session){
    if(array_key_exists($key,$_SESSION) && !empty($_SESSION[$key])) {
        return $current_session;
    }else{
        return false;
    }
}

}

if(!function_exists('alert')){
    function alert($type, $message){
        echo '<div class="alert alert-'.$type.'" role="alert">';
        echo  $message;
        echo '</div>';
    }
}

if(!function_exists('alert-dismissable')){
    function alert_dismissable($type, $message){
        switch ($type) {
            case "success":
                $icon = "check";
                break;
            case "info":
                $icon = "info-outline";
                break;
            case "warning":
                $icon = "alert-circle-o";
                break;
            default:
                $icon = "block";
                break;
        }
        echo '<div class="alert alert-'.$type.' alert-dismissable alert-style-1"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i class="zmdi zmdi-'. $icon.'"></i>'. $message.'</div>';
    }
}

if(!function_exists('get_extension')){
    function get_extension($str){
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }
}







<?php 
class Source{

    public static function nulltype(){
        return "SET:NULL";
    }

    public static function type($type){
        header("Content-Type: $type");
    }
    
    public static function set($page, $variables = [], $format = "application/json") {

        $projectRoot = dirname(__DIR__); 

        if ($format != "SET:NULL") {
            header("Content-Type: $format");
        }

        $spage = $projectRoot . "/source/$page.src.php";

        if (is_file($spage)) {
            if (!empty($variables)) {
                extract($variables); 
            }

            ob_start();
            include $spage;
            $html = ob_get_clean();
            echo $html;
        } else {
            include $projectRoot . "/.config/_404.php";
        }
    }

    public static function empty(&$var, $value){
        if(!isset($var)){
            $var = $value;
        }
    }
}
?>

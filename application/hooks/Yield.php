<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 //Yield 클래스명은 예약어이니 사용 불가 다른 클래스명 사용
class Yield_class {
    function doYield(){
        global $OUT;
        $CI =& get_instance();
        $output = $CI->output->get_output();
        $CI->yield = isset($CI->yield) ? $CI->yield : TRUE;
        $CI->layout = isset($CI->layout) ? $CI->layout : 'default';
        if ($CI->yield === TRUE)
        {
            if (!preg_match('/(.+).php$/', $CI->layout))
            {
                $CI->layout .= '.php';
            }
            $requested = APPPATH . 'views/layouts/' . $CI->layout;
            $layout = $CI->load->file($requested, true);
            $view = str_replace("{yield}", $output, $layout);
        }
        else
        {
            $view = $output;
        }
        $OUT->_display($view);
    }
}
?>
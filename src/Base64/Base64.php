<?php


namespace Hahadu\Encrypt\Base64;


class Base64
{
    /****
     * base64编码
     * @param $string
     * @return string|string[]
     */
    public function url_safe_b64encode ($string) {
        $data = base64_encode ($string);
        $data = str_replace ( array('+', '/', '=') , array('-', '_', '') , $data );
        return $data;
    }

    /*****
     * base64解码
     * @param $string
     * @return false|string
     */
    public function url_safe_b64decode ($string) {
        $data = str_replace ( array('-', '_') , array('+', '/') , $string );
        $mod4 = strlen ($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }


}
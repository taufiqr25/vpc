<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Encryptions extends CI_Model
{

    function encrypt($str)
    {
        $str=$this->enkripsi->encode($str);
        $str=str_replace(array('+', '/', '='), array('-', '_', '~'), $str);
        return $str;
        
    }

    function decrypt($str)
    {
        $str=str_replace(array('-', '_', '~'), array('+', '/', '='), $str);
        $str=$this->enkripsi->decode($str);
        return $str;
        
    }
}
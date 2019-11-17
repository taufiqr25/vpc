<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Encryptions extends CI_Model
{

    function encrypt($str)
    {
        $str = $this->enkripsi->encode($str);
        return $str;
        
    }

    function decrypt($str)
    {
        $str = $this->enkripsi->decode($str);
        return $str;
        
    }
}
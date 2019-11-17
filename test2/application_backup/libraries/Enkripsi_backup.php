<?php
class Enkripsi {

	public function encode($str){
        $result = str_replace(array('0','1','2','3','4','5','6','7','8','9'), array('hCtIw', 'rEnIm', 'aKkEp', 'rEhCrA', 'gOh', 'nOgArD', 'dRaZiW', 'nIlBoG', 'nAiRaBrAb', 'tNaiG'), $str);

        return $result;
    }

    public function decode($str){
    	$str = str_replace(array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0'), array('error','error','error','error','error','error','error','error','error','error'), $str); //menghindari angka.

        $result = str_replace(array('hCtIw', 'rEnIm', 'aKkEp', 'rEhCrA', 'gOh', 'nOgArD', 'dRaZiW', 'nIlBoG', 'nAiRaBrAb', 'tNaiG'), array('0','1','2','3','4','5','6','7','8','9'), $str);

        return $result;
    }

}
?>
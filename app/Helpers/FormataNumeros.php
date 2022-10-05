<?php


namespace App\Helpers;


class FormataNumeros
{
    public static function somenteNumeros($dado)
    {
        return preg_replace("/[^0-9]/", "", $dado);
    }

    public static function formataCPF($cpf)
    {
        return self::mask($cpf, '###.###.###-##');
    }

    private static function mask($val, $mask) {
        $maskared = '';
        $k = 0;
        for($i = 0; $i<=strlen($mask)-1; $i++) {
            if($mask[$i] == '#') {
                if(isset($val[$k])) $maskared .= $val[$k++];
            } else {
                if(isset($mask[$i])) $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }
}
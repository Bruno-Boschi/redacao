<?php


namespace App\Helpers;


class FormataData
{
    public static function dataBrParaDb($data)
    {
        return implode('-', array_reverse(explode('/', $data)));
    }

    public static function dataDbParaBr($data)
    {
        $date = new \DateTime($data);
        return $date->format('d/m/Y');
    }

    public static function dataHoraDbParaBr($data)
    {
        $date = new \DateTime($data);
        return $date->format('d/m/Y H:i');
    }
    
    public static function mesDescricao($data)
    {
        $date = new \DateTime($data);
        switch ($date->format('m')) {
            case "01": 
                $mes = 'Janeiro';     
                break;
            case "02": 
                $mes = 'Fevereiro';   
                break;
            case "03": 
                $mes = 'Março';       
                break;
            case "04": 
                $mes = 'Abril';       
                break;
            case "05": 
                $mes = 'Maio';        
                break;
            case "06": 
                $mes = 'Junho';       
                break;
            case "07": 
                $mes = 'Julho';       
                break;
            case "08": 
                $mes = 'Agosto';      
                break;
            case "09": 
                $mes = 'Setembro';    
                break;
            case "10": 
                $mes = 'Outubro';     
                break;
            case "11": 
                $mes = 'Novembro';    
                break;
            case "12": 
                $mes = 'Dezembro';    
                break; 
     }
     
     return $mes;
    }

    public static function diaData($data)
    {
        $date = new \DateTime($data);
        return $date->format('d');
    }

    public static function anoData($data)
    {
        $date = new \DateTime($data);
        return $date->format('Y');
    }

    public static function formataHora($data)
    {
        $date = new \DateTime($data);
        return $date->format('H:i');
    }
}
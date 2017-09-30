<?php

/* Classe criada para obter data e hora corrente do servidor
 * 
 * Marcelo Barbosa
 * novembro, 2015.
 */

// declaracao do namespace
namespace SM\Library\Utils;

// importacao de recursos
use SM\Library\Generic\Generic;

//declaracao da classe
class TimeStamp extends Generic
{
    // declaracao de atributos
    private $dateFormat;
    private $timeFormat;
    
    // declaracao de metodos
    public function __construct($dateFormat = "d/m/Y", $timeFormat = "H:i:s", $timezone = "Brazil/East") 
    {
        // metodo construtor
        // configura o timezone a ser utilizado
        date_default_timezone_set($timezone);        
        
        // inicializa os atributos
        $this->dateFormat = $dateFormat;
        $this->timeFormat = $timeFormat;
    }
    
    public function setDateFormat($dateFormat)
    {
        $this->dateFormat = $dateFormat;
    }
    
    public function getDateFormat()
    {
        return $this->dateFormat;
    }
    
    public function setTimeFormat($timeFormat)
    {
        $this->timeFormat = $timeFormat;
    }
            
    public function getTimeFormat()
    {
        return $this->timeFormat;
    }
    
    public function getCurrentDate()
    {
        // obtem a data corrente
        return date($this->getDateFormat());
    }
    
    public function getCurrentDay($dateFormat = "d")
    {
        // obtem o dia corrente
        return date($dateFormat);
    }
    
    public function getCurrentMonth($dateFormat = "m")
    {
        // obtem o mes corrente
        return date($dateFormat);
    }
    
    public function getCurrentYear($dateFormat = "Y")
    {
        // obtem o ano corrente
        return date($dateFormat);
    }
    
    public function getCurrentSeconds($timeFormat = "s")
    {
        // retorna os segundos correntes
        return date($timeFormat);
    }
    
    public function getCurrentMinutes($timeFormat = "i")
    {
        // retorna os minutos correntes
        return date($timeFormat);
    }
    
    public function getCurrentHours($timeFormat = "H")
    {
       // retorna a hora corrente
        return date($timeFormat);
    }
    
    public function getCurrentTime()
    {
        // retorna o tempo corrente
        return date($this->getTimeFormat());
    }
    
    public function getTimeBySeconds($seconds = 0)
    {
        // retorna um periodo de tempo referente aos segundos informados
        
        if($seconds < 0)
        {
           $seconds = 0;
        }
        
        return date($this->getTimeFormat(), mktime(0, 0, $seconds, 0, 0, 0));
    }
    
    public function getSecondsByTime($hours, $minutes, $seconds)
    {
        // retorna os segundos de um periodo temporal
        $seconds += ($hours * 3600) + ($minutes * 60);
        
        return $seconds;
    }
    
    public function getStrTimeToSeconds($time = "00:00:00")
    {
        // retorna o tempo em segundos de um periodo temporal através de uma string
        if(strlen($time) == 8)
        {
            // obtencao das medidas de tempo em horas, minutos e segundos
            $hours = substr($time, 0, 2);            
            $minutes = substr($time, 3, 2);
            $seconds = substr($time, 6, 2);            
            
            if($hours == "00")
            {
                $hours = "24";
            }
            
            // retorno de valor
            return $this->getSecondsByTime($hours, $minutes, $seconds);
        }else
            {
                return -1;
            }
    }
    
    public function getTimestamp()
    {
        // retorna a data e hora atual
        return date($this->getDateFormat()) . " - " . date($this->getTimeFormat());
    }
    
    public function currentTimeSeconds()
    {
        // retorna a data em milisegundos
        return mktime($this->getCurrentHours(), 
                      $this->getCurrentMinutes(), 
                      $this->getCurrentSeconds(), 
                      $this->getCurrentMonth(), 
                      $this->getCurrentDay(), 
                      $this->getCurrentYear());
    }
    
    public function getTimeSeconds($month = 1, $day = 1, $year = 1997)
    {
        // retorna, em milisegundos, uma data
        return mktime(0, 
                      0, 
                      0, 
                      $month, 
                      $day, 
                      $year);
    }
    
    public function getStrDateToSeconds($date = "01/01/1997")
    {
        // retorna o tempo em segundos a partir de uma data
        if(strlen($date) == 10)
        {
            // obtencao das medidas de tempo em horas, minutos e segundos
            $day = substr($date, 0, 2);            
            $month = substr($date, 3, 2);
            $year = substr($date, 6, 4);
            
            // retorno de valor
            return $this->getTimeSeconds($month, $day, $year);
        }else
            {
                return -1;
            }
    }
    
    public function getWeekday()
    {
        // retona o dia da semana
        return date("l", $this->getTimeSeconds($this->getCurrentMonth(),
                                              $this->getCurrentDay(), 
                                              $this->getCurrentYear()));
    }
    
    public function getWorkingWeekday()
    {
        // retona o dia da semana
        $weekday = date("l", $this->getTimeSeconds($this->getCurrentMonth(),
                                              $this->getCurrentDay(), 
                                              $this->getCurrentYear()));        
        switch($weekday)
        {
            case "Sunday":
                return "Sunday";
            break;
        
            case "Saturday":
                return "Saturday";
            break;  
        
            default:
                return "WorkingDays";
            break;
        }
    }
    
    public function toString() 
    {
        // retorna os dados da classe em uma string
        return "Date format: " . $this->getDateFormat()
            ."<br>Time format: " . $this->getTimeFormat()
            ."<br>Current day: " . $this->getCurrentDay()
            ."<br>Current month: " . $this->getCurrentMonth()
            ."<br>Current year: " . $this->getCurrentYear()
            ."<br>Weekday: " . $this->getWeekday()
            ."<br>Date: " . $this->getCurrentDate()
            ."<br>Time: " . $this->getCurrentTime()                
            ."<br><br>Timestamp: " . $this->getTimestamp()
            ."<br><br>Current Time Seconds: " . $this->currentTimeSeconds()
            ."<br><br>Date to Time Seconds: " . $this->getTimeSeconds($this->getCurrentMonth(),
                                                            $this->getCurrentDay(), 
                                                            $this->getCurrentYear());
    }
}
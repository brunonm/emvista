<?php

namespace EmVista\EmVistaBundle\Util;

class Date extends \DateTime{

    /**
     * @param string $date - padrão brasileiro, sem timezone
     * @return \DateTime
     */
    public static function buildDateTime($date, $format = 'd/m/Y'){
        return self::createFromFormat($format, $date);
    }

    /**
     * Exemplo: 2011-12-30 12:10:00 -> 30/12/2011
     * @param string $date - timezone, padrão ISO8601
     * @return string
     */
    public static function formatdmY($date){
        if($date instanceof \DateTime){
            return $date->format('d/m/Y');
        }else{
            return date('d/m/Y', strtotime($date));
        }
    }

    /**
    * Constrói um objeto datetime com data retroativa, diminuindo os dias informados via parâmetro
    * @param integer $daysAgo
    * @return Date
    */
    public static function buildDateInPast($daysAgo){
        $date = new self();
        return $date->add(\DateInterval::createFromDateString("-$daysAgo days"));
    }

    /**
    * Constrói um objeto datetime com data futura, acrescentendo os dias informados via parâmetro
    * @param integer $daysAgo
    * @return Date
    */
    public static function buildDateInFuture($days){
        $date = new self();
        return $date->add(\DateInterval::createFromDateString("+$days days"));
    }

    /**
     * Retorna a diferença entre a data atual e a do projeto
     * @param \EmVista\EmVistaBundle\Entity\Projeto $projeto
     * @param \DateInterval $format
     */
    public static function getDateDiff($projeto){
        return date_diff(new self('now'), $projeto->getDataFim());
    }
}
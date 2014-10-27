<?php

namespace EmVista\EmVistaBundle\Util;

class Money
{
    /**
     * @param string
     * @param string $thousands
     * @param string $decimal
     *
     * @return number
     */
    public static function revert($money, $thousands = '.', $decimal = ',')
    {
        $money = str_replace($thousands, 'A', $money);
        $money = str_replace($decimal, 'B', $money);
        $money = str_replace('A', '', $money);
        $money = str_replace('B', '.', $money);
        return $money;
    }

    public static function convert($money, $thousands = '.', $decimal = ',')
    {
        return number_format($money, 2, $decimal, $thousands);
    }
}

<?php

namespace EmVista\EmVistaBundle\Tests\Util;

use EmVista\EmVistaBundle\Tests\TestCase;
use EmVista\EmVistaBundle\Core\ServiceLayer\ServiceData;
use EmVista\EmVistaBundle\Util\Date;

class DateTest extends TestCase{

    /**
     * @test
     */
    public function deveFormatarDataAPartirDeUmaStringComSucesso(){
        $date = '2011-12-30';
        $formattedDate = Date::formatdmY($date);
        $this->assertEquals('30/12/2011', $formattedDate);
    }

    /**
     * @test
     */
    public function deveFormatarDataAPartirDeUmDateTimeComSucesso(){
        $date = new \DateTime('2011-12-30');
        $formattedDate = Date::formatdmY($date);
        $this->assertEquals('30/12/2011', $formattedDate);
    }

    /**
     * @test
     */
    public function deveCriarDateTimeComSucesso(){
        $date = '10/11/2011';
        $datetime = Date::buildDateTime($date);
        $this->assertInstanceOf('\DateTime', $datetime);
        $this->assertEquals($date, $datetime->format('d/m/Y'));
    }
}
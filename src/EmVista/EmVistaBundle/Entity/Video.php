<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use EmVista\EmVistaBundle\Entity\SiteVideo;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\Video
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Video extends EntityAbstract{

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $identificador
     *
     * @ORM\Column(name="identificador", type="string", length=255)
     */
    private $identificador;

    /**
     * @var SiteVideo $siteVideo
     *
     * @ManyToOne(targetEntity="SiteVideo")
     * @JoinColumn(name="site_video_id", referencedColumnName="id", nullable=false)
     */
    private $siteVideo;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set identificador
     *
     * @param string $identificador
     * @return Video
     */
    public function setIdentificador($identificador){
        $this->identificador = $identificador;
        return $this;
    }

    /**
     * Get identificador
     *
     * @return string
     */
    public function getIdentificador(){
        return $this->identificador;
    }

    /**
     * Set siteVideo
     *
     * @param SiteVideo $siteVideo
     * @return SiteVideo
     */
    public function setSiteVideo($siteVideo){
        $this->siteVideo = $siteVideo;
        return $this;
    }

    /**
     * Get siteVideo
     *
     * @return SiteVideo
     */
    public function getSiteVideo(){
        return $this->siteVideo;
    }

    /**
     * @return string
     */
    public function getEmbed(){
        return str_replace('{IDENTIFICADOR}', $this->getIdentificador(), $this->getSiteVideo()->getEmbed());
    }

    /**
     * @return string
     */
    public function getWatchUrl(){
        return str_replace('{IDENTIFICADOR}', $this->getIdentificador(), $this->getSiteVideo()->getWatchUrl());
    }
}
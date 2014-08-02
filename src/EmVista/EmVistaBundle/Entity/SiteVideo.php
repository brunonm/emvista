<?php

namespace EmVista\EmVistaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use EmVista\EmVistaBundle\Core\Entity\EntityAbstract;

/**
 * EmVista\EmVistaBundle\Entity\SiteVideo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SiteVideo extends EntityAbstract{

    const YOUTUBE = 1;
    const VIMEO   = 2;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nome
     *
     * @ORM\Column(name="nome", type="string", length=100)
     */
    private $nome;

    /**
     * @var string $embed
     *
     * @ORM\Column(name="embed", type="text")
     */
    private $embed;

    /**
     * @var string $watchUrl
     *
     * @ORM\Column(name="watch_url", type="string")
     */
    private $watchUrl;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return SiteVideo
     */
    public function setNome($nome){
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome(){
        return $this->nome;
    }

    /**
     * Set embed
     *
     * @param string $embed
     * @return SiteVideo
     */
    public function setEmbed($embed){
        $this->embed = $embed;

        return $this;
    }

    /**
     * Get embed
     *
     * @return string
     */
    public function getEmbed(){
        return $this->embed;
    }

    /**
     * @param string $watchUrl
     */
    public function setWatchUrl($watchUrl){
        $this->watchUrl = $watchUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getWatchUrl(){
        return $this->watchUrl;
    }
}
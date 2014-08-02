<?php

namespace EmVista\EmVistaBundle\Core\ServiceLayer;

use EmVista\EmVistaBundle\Core\Exceptions\ServiceDataException;

class ServiceData implements \ArrayAccess{

    protected $data = null;
    protected $file = null;

    private function __construct(){}

    /**
     * carrega no objeto o array passado
     * @param array $data
     */
    public function load(array $data){
        $this->data = $data;
    }

    /**
     * carrega no objeto o array passado
     * @param array $file
     */
    public function loadFile(array $file){
        $this->file = $file;
    }

    /**
     * fabrica um objeto, podendo opcionalmente carregar os dados
     * @param array $data
     * @return ServiceData
     */
    static public function build(array $data = null){
        $sd = new self();
        if($data !== null){
            $sd->load($data);
        }
        return $sd;
    }
    /**
     * fabrica um objeto, podendo opcionalmente carregar os dados
     * @param array $data
     * @return ServiceData
     */
    static public function buildFile(array $file = null){
        $sd = new self();
        if($file !== null){
            $sd->loadFile($file);
        }
        return $sd;
    }



    /**
     * alias para o metodo offsetSet()
     * @param string || integer $offset
     * @param mixed $value
     */
    public function set($offset, $value){
        $this->offsetSet($offset, $value);
        return $this;
    }

    /**
     * alias para o metodo offsetSet()
     * @param string || integer $offset
     * @param mixed $value
     */
    public function setFile($offset, $value){
        $this->offsetSetFile($offset, $value);
        return $this;
    }

    /**
     * alias para o metodo offsetGet(). Se nao for passado o $offset, retorna o array inteiro.
     * @param string || integer || null $offset
     * @return mixed
     */
    public function get($offset = null){
        if($offset === null){
            if(empty($this->data)){
                throw new ServiceDataException('O objeto ainda nao foi carregado.');
            }
            return $this->data;
        }
        return $this->offsetGet($offset);
    }

    /**
     * alias para o metodo offsetGetFile(). Se nao for passado o $offset, retorna o array inteiro.
     * @param string || integer || null $offset
     * @return mixed
     */
    public function getFile($offset = null){
        if($offset === null){
            if(empty($this->file)){
                throw new ServiceDataException('O objeto ainda nao foi carregado.');
            }
            return $this->file;
        }
        return $this->offsetGetFile($offset);
    }


    /**
     * @param string || integer $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value){
        $this->data[$offset] = $value;
        return $this;
    }


    /**
     * @param string || integer $offset
     * @param mixed $value
     */
    public function offsetSetFile($offset, $value){
        $this->file[$offset] = $value;
        return $this;
    }

    /**
     * @param  string || integer $offset
     * @return bool
     */
    public function offsetExists($offset){
        return isset($this->data) && array_key_exists($offset, $this->data);
    }


    /**
     * @param  string || integer $offset
     * @return bool
     */
    public function offsetExistsFile($offset){
        return isset($this->file) && array_key_exists($offset, $this->file);
    }

    /**
     * @param string || integer $offset
     */
    public function offsetUnset($offset){
        unset($this->data[$offset]);
    }


    /**
     * @param string || integer $offset
     */
    public function offsetUnsetFile($offset){
        unset($this->file[$offset]);
    }

    /**
     * @param string || integer || null $offset
     * @return mixed
     */
    public function offsetGet($offset){
        if($this->offsetExists($offset)){
            return $this->data[$offset];
        }else{
            throw new \InvalidArgumentException($offset . ' nao existe.');
        }
    }
    /**
     * @param string || integer || null $offset
     * @return mixed
     */
    public function offsetGetFile($offset){
        if($this->offsetExists($offset)){
            return $this->file[$offset];
        }else{
            throw new \InvalidArgumentException($offset . ' nao existe.');
        }
    }

    /**
     * alias para set('user', $user)
     * @param \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function setUser($user){
        $this->set('user', $user);
        return $this;
    }

    /**
     * alias para get('user')
     * @return \EmVista\EmVistaBundle\Entity\Usuario
     */
    public function getUser(){
        return $this->get('user');
    }
}
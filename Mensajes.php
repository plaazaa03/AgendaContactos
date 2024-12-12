<?php
class Mensaje {
    private $id;
    private $texto;
    private $fechaEnvio;
    private $idContacto;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
    }

    public function getFechaEnvio() {
        return $this->fechaEnvio;
    }

    public function setFechaEnvio($fechaEnvio) {
        $this->fechaEnvio = $fechaEnvio;
    }

    public function getIdContacto() {
        return $this->idContacto;
    }

    public function setIdContacto($idContacto) {
        $this->idContacto = $idContacto;
    }
}
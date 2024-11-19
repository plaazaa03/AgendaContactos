<?php
class Mensajes {
    private $id;
    private $texto;
    private $fechaEnvio;
    private $idContacto;

    public function __construct($id, $texto, $fechaEnvio, $idContacto) {
        $this->id = $id;
        $this->texto = $texto;
        $this->fechaEnvio = $fechaEnvio;
        $this->idContacto = $idContacto;
    }

    public function getId() {
        return $this->id;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function getFechaEnvio() {
        return $this->fechaEnvio;
    }

    public function getIdContacto() {
        return $this->idContacto;
    }
}


?>
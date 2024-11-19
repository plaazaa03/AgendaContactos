<?php
class Contacto {

    private $id;
    private $telefono;
    private $apellidos;
    private $telefonoCon;
    private $foto;

    public function __construct($id, $telefono, $apellidos, $telefonoCon, $foto) {
        $this->id = $id;
        $this->telefono = $telefono;
        $this->apellidos = $apellidos;
        $this->telefonoCon = $telefonoCon;
        $this->foto = $foto;
    }

    private function getId() {
        return $this->id;
    }

    private function getTelefono() {
        return $this->telefono;
    }

    private function getApellidos() {
        return $this->apellidos;
    }

    private function getTelefonoCon() {
        return $this->telefonoCon;
    }

    private function getFoto() {
        return $this->foto;
    }
}


?>
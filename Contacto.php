<?php
class Contacto {
    private $id;
    private $nombre;
    private $apellidos;
    private $telefono;
    private $foto;
    private $idUsuario;

    public function __construct($id, $nombre, $apellidos, $telefono, $foto, $idUsuario) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->telefono = $telefono;
        $this->foto = $foto;
        $this->idUsuario = $idUsuario;
    }

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }
}
?>
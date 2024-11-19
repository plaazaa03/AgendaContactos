<?php
class Usuario {
    private $id;
    private $telefono;
    private $password;

    public function __construct($id, $telefono, $password) {
        $this->id = $id;
        $this->telefono = $telefono;
        $this->password = $password;
    }

    public function getId() {
        return $this->id;
    }

    public function getTelefono() {
        return $this->telefono;
    }

    public function getPassword() {
        return $this->password;
    }
}
?>
<?php
class Usuario {
    private $id;
    private $telefono;
    private $password;
    private $avatar;

    public function __construct($id, $telefono, $password, $avatar) {
        $this->id = $id;
        $this->telefono = $telefono;
        $this->password = $password;
        $this->avatar = $avatar;
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

    public function getAvatar() {
        return $this->avatar;
    }
}
?>
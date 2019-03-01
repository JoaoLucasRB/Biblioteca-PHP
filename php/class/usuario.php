<?php

class Usuario {

    private $id;
    private $nome_usuario;
    private $email;
    private $senha;
    private $privilegio;
    private $datauser;

    public function __construct($id, $nome_usuario, $email, $senha, $privilegio, $datauser){
        $this->setId($id);
        $this->setNome($nome_usuario);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setPrivilegio($privilegio);
        $this->setData($datauser);
    }

    # Getter e Setter ID
    public function setId($valor){
        $this->id = $valor;
    }
    public function getId(){
        return $this->id;
    }
    # Getter e Setter NOME DE USUARIO
    public function setNome($valor){
        $this->nome_usuario = $valor;
    }
    public function getNome(){
        return $this->nome_usuario;
    }

    # Getter e Setter EMAIL
    public function setEmail($valor){
        $this->email = $valor;
    }
    public function getEmail(){
        return $this->email;
    }

    # Getter e Setter SENHA
    public function setSenha($valor){
        $this->senha = $valor;
    }
    public function getSenha(){
        return $this->senha;
    }

    # Getter e Setter NIVEL DE PRIVILEGIO
    public function setPrivilegio($valor){
        $this->privilegio = $valor;
    }
    public function getPrivilegioId(){
        return $this->privilegio->getId();
    }
    public function getPrivilegioNome(){
        return $this->privilegio->getNome();
    }

    # Getter e Setter DATA
    public function setData($valor){
        $this->datauser = $valor;
    }
    public function getData(){
        return $this->datauser;
    }

}
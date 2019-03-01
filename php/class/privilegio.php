<?php

class Privilegio {

    private $id;
    private $nome;

    public function __construct($id, $nome){
        $this->setId($id);
        $this->setNome($nome);
    }

    # Getter e Setter ID
    public function setId($valor){
        $this->id = $valor;
    }
    public function getId(){
        return $this->id;
    }

    # Getter e Setter NOME
    public function setNome($valor){
        $this->nome = $valor;
    }
    public function getNome(){
        return $this->nome;
    }
}
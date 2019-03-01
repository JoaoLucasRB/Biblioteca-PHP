<?php

class Categoria {
    
    # Variaveis caracteristicas da categoria
    private $id;
    private $nome;

    # Construtor da class
    public function __construct($id, $nome){
        $this->setId($id);
        $this->setNome($nome);
    }

    # Getter e Setter ID da categoria
    public function setId($valor){
        $this->id=$valor;
    }
    public function getId(){
        return $this->id;
    }

    #Getter e Setter NOME da categoria
    public function setNome($valor){
        $this->nome=$valor;
    }
    public function getNome(){
        return $this->nome;
    }
}
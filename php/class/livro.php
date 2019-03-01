<?php

class Livro {

    # Variaveis caracteristicas do eBook
    private $id;
    private $nome;
    private $descricao;
    private $categoriaId;
    private $data;
    private $nomeImagem;
    private $nomeArquivo;

    # Construtor da classe
    public function __construct($id, $nome, $descricao, $categoriaId, $data, $nomeImagem, $nomeArquivo){
        $this->setId($id);
        $this->setNome($nome);
        $this->setDescricao($descricao);
        $this->setCategoriaId($categoriaId);
        $this->setData($data);
        $this->setImagem($nomeImagem);
        $this->setArquivo($nomeArquivo);
    }

    # Getter e Setter ID do eBook
    public function setId($valor){
        $this->id=$valor;
    }
    public function getId(){
        return $this->id;
    }

    # Getter e Setter NOME do eBook
    public function setNome($valor){
        $this->nome=$valor;
    }
    public function getNome(){
        return $this->nome;
    }

    # Getter e Setter DESCRICAO do eBook
    public function setDescricao($valor){
        $this->descricao=$valor;
    }
    public function getDescricao(){
        return $this->descricao;
    }

    # Getter e Setter CATEGORIA_ID do eBook
    public function setCategoriaId($valor){
        $this->categoriaId=$valor;
    }
    public function getCategoriaId(){
        return $this->categoriaId;
    }

    # Getter e Setter DATA_DE_CRIACAO do eBook
    public function setData($valor){
        $this->data=$valor;
    }
    public function getData(){
        return $this->data;
    }

    # Getter e Setter IMAGEM do eBook
    public function setImagem($valor){
        $this->nomeImagem=$valor;
    }
    public function getImagem(){
        return $this->nomeImagem;
    }

    # Getter e Setter ARQUIVO do eBook
    public function setArquivo($valor){
        $this->nomeArquivo=$valor;
    }
    public function getArquivo(){
        return $this->nomeArquivo;
    }

}
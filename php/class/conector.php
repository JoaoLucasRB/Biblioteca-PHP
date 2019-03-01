<?php

class Conector {

    # Variavel de conexao (equivalente mysqli)
    private $conexaoBD;

    # Construtor da classe
    public function __construct(){
        $this->estabelecerConexao();
    }

    # Funcao para estabelecer comunicacao com o servidor do banco de dados
    private function estabelecerConexao(){
        $this->conexaoBD = new mysqli('localhost','root','', 'ebook');
        #$this->conexaoBD = new mysqli('localhost','cenep_biblio','rjt.PVCZM^IW', 'cenep_bibliotecadigital');
    }

    # Funcao que retorna o valor da variavel de conexao
    public function getConexao(){
        return $this->conexaoBD;
    }
}
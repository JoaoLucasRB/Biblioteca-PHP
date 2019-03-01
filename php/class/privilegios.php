<?php

# Importacoes necessarias
require_once("conector.php"); # Conexao ao BD
require_once("banco-privilegio.php"); # Funcoes do banco de dados

class Privilegios {

    public function getPrivilegios(){
        $conector = new Conector();
        $banco = new BancoPrivilegio();
        return $banco->getPrivilegios($conector->getConexao());
    }
}
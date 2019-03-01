<?php

# Importacoes necessarias
require_once("privilegio.php"); # Classe do objeto

class BancoPrivilegio {

    public function getPrivilegios($conexaoBD){
        $query = "select id,nome from privilegio";
        $resultado = $conexaoBD->query($query);
        $privilegios = array();
        while($privilegio = $resultado->fetch_assoc()){
            array_push($privilegios, new Privilegio($privilegio['id'], $privilegio['nome']));
        }
        return $privilegios;
    }
}
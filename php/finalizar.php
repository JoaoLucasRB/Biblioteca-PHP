<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();

$chaveReg = $_GET['chave'];
$cadastro = $controlador->getCadastro($chaveReg);
$controlador->finalizarCadastro($cadastro, $chaveReg);

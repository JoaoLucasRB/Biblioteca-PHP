<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();

if($_POST['nome'] != ""){
    $nome = $_POST['nome'];
    $controlador->adicionarCategoria($nome);
} else {
    $_SESSION['warning'] = "O campo nome ficou vazio, tente novamente.";
    header("Location: ../php/categorias.php");
}
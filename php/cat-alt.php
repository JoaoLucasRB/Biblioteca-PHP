<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();

if($_POST['nomeCategoria'] != ""){
    $nome = $_POST['nomeCategoria'];
    $id = $_POST['idCategoria'];
    $controlador->alterarCategoria($id, $nome);
} else {
    $_SESSION['warning'] = "O campo nome ficou vazio. Tente novamente";
    header("Location: ../php/categorias.php");
}
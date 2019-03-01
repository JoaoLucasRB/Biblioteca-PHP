<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();

$id = $_POST['idUser'];
$controlador->removerUsuario($id);

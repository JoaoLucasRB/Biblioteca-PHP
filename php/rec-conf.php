<?php

# Importacoes necessarias
require_once("class/controlador.php");
$controlador = new Controlador();

$chaveRec = $_POST['chave'];
$id = $_POST['id'];
$sen = $_POST['senUsuario'];
$conf = $_POST['confSen'];

echo $sen;
$controlador->alterarSenha($id, $sen);
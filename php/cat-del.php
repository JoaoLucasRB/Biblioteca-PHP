<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();

$id = $_POST['idCatDel'];
$controlador->removerCategoria($id);

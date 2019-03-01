<?php

# Importacoes Necessarias
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();

$controlador->logout();
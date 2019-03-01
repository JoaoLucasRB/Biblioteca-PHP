<?php

require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();

$idEbook = $_POST['idEbook'];
$imgEbook = $_POST['imgEbook'];
$arqEbook = $_POST['arqEbook'];
$controlador->removerLivro($idEbook, $imgEbook, $arqEbook);


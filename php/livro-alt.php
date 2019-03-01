<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();

if(($_POST['idEbook'] != "") && ($_POST['nome'] != "") && ($_POST['descricao'] != "") && ($_POST['categoria'] != "")){
    
    $idEbook = $_POST['idEbook'];
    $nomeEbook = $_POST['nome'];
    $descEbook = $_POST['descricao'];
    $catEbook = $_POST['categoria'];

    if($_FILES["arquivo"]["error"] == 4) {
        $novoArq = 0;
    } else {
        $arquivo = $_FILES['arquivo'];
        $arqEbook = $arquivo['name'];
        $tipoArq = $arquivo['type'];
        $arqAntigo = $_POST['arqAtual'];
        $novoArq = 1;
    }

    if($_FILES["imagem"]["error"] == 4) {
        $novoImg = 0;
    } else {
        $imagem = $_FILES['imagem'];
        $imgEbook = $imagem['name'];
        $tipImg = $imagem['type'];
        $imgAntigo = $_POST['imgAtual'];
        $novoImg = 1;
    }

    if(($novoArq == 1) && ($novoImg == 1)){
        $case = 4;
        $controlador->alterarLivro($idEbook, $nomeEbook, $descEbook, $catEbook, $imagem, $imgEbook, $imgAntigo, $arquivo, $arqEbook, $arqAntigo, $case);
    } else if (($novoArq == 1) && ($novoImg == 0)) {
        $case = 2;
        $controlador->alterarLivro($idEbook, $nomeEbook, $descEbook, $catEbook, "", "", "", $arquivo, $arqEbook, $arqAntigo, $case);
    } else if (($novoArq == 0) && ($novoImg == 1)) {
        $case = 3;
        $controlador->alterarLivro($idEbook, $nomeEbook, $descEbook, $catEbook, $imagem, $imgEbook, $imgAntigo, "", "", "", $case);
    } else if (($novoArq == 0) && ($novoImg == 0)) {
        $case = 1;
        $controlador->alterarLivro($idEbook, $nomeEbook, $descEbook, $catEbook, "", "", "", "", "", "", $case);
    }

} else {
    $_SESSION = "Algum campo ficou vazio, tente novamente.";
    header("Location: ../php/ebooks.php");
}

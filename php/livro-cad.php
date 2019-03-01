<?php

# Importacoes necessarias
require_once("class/controlador.php"); # Interface de comunicacao com o back-end
$controlador = new Controlador();
$controlador->verificarAcesso();
# Verifica se os campos foram preenchidos
if(($_POST['nome'] != "") && ($_POST['descricao'] != "") && ($_POST['categoria'] != "")){

    # Verifica se os arquivos foram upados com sucesso
    if(($_FILES["arquivo"]["error"] == 4) || ($_FILES["arquivo"]["error"] == 4)){
        $_SESSION['warning'] = "Algum campo importante ficou em branco. Tente novamente.";
        header("Location: ebooks.php");
    } else {
        # Informacoes do objeto
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $categoria = $_POST['categoria'];

        # Informacoes do arquivo
        $nome_imagem = $_FILES['imagem']['name'];
        $tipo_imagem = $_FILES['imagem']['type'];

        # Informacoes da imagem
        $nome_arquivo = $_FILES['arquivo']['name'];
        $tipo_arquivo = $_FILES['arquivo']['type'];

        # Verificacao do tipo da Imagem/Arquivo
        if( ($tipo_imagem=="image/png" || $tipo_imagem=="image/jpeg") && $tipo_arquivo == "application/pdf"){
            $controlador->cadastrarLivro($nome, $descricao, $categoria, $_FILES['imagem'], $nome_imagem, $_FILES['arquivo'], $nome_arquivo);
        # Caso o tipo/formato do arquivo seja invalido
        } else {
            # Redireciona para o upload notificando o erro
            $_SESSION['warning'] = "Falha ao enviar o arquivo: Formato invavlido";
            header("Location: ebooks.php");
        }
    }
} else {
    $_SESSION['warning'] = "Algum campo importante ficou em branco. Tente novamente.";
    header("Location: ebooks.php");
}
die();
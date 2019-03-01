<?php

# Importacoes necessaria
require_once("banco-livro.php"); # Funcoes do banco de dados
require_once("conector.php"); # Conexao ao BD
require_once("livro.php"); # Classe do Objeto
require_once("logica-usuario.php"); # Funcoes de gerenciamento do usuario (restricao de acesso a pagina)

class Livros {

    # Funcao para inserir um livro
    public function cadastrarLivro($nome, $descricao, $categoriaId, $imagem, $nomeImagem, $arquivo, $nomeArquivo){
        $conector = new Conector();
        $banco = new BancoLivro();
        $dirUploadImg = "../imgUp/";
        $dirUploadArq = "../arqUp/";
        $livro = new Livro(0, $nome, $descricao, $categoriaId, 0, $nomeImagem, $nomeArquivo);
        try{
            if($banco->cadastrarLivro($conector->getConexao(), $livro)){
                $livro->setId($banco->getUltimoId($conector->getConexao()));
                if($this->cadastrarImagem($banco, $conector, $livro, $imagem, $dirUploadImg)){
                    if($this->cadastrarArquivo($banco, $conector, $livro, $arquivo, $dirUploadArq)){
                        $_SESSION['success'] = "eBook cadastrado com sucesso.";
                    } else {
                        $_SESSION['danger'] = "Falha ao inserir livro no banco de dados.";
                        $this->removerLivro($livro->getId(), $livro->getImagem(), $livro->getArquivo());
                    }
                } else {
                    $_SESSION['danger'] = "Falha ao inserir livro no banco de dados.";
                    $this->removerLivro($livro->getId(), $livro->getImagem(), $livro->getArquivo());
                }
            } else {
                $_SESSION['danger'] = "Falha ao inserir livro no banco de dados.";
            }
        } catch (Exception $e) {
            $_SESSION['danger'] = "Falha ao inserir livro no banco de dados.";
            $this->removerLivro($livro->getId(), $livro->getImagem(), $livro->getArquivo());
        }
        header("Location: ../php/ebooks.php");
    }

    #Funcao para remover um livro do banco de dados
    public function removerLivro($id, $nomeImagem, $nomeArquivo){
        $conector = new Conector();
        $banco = new BancoLivro();
        $dirUploadImg = "../imgUp/";
        $dirUploadArq = "../arqUp/";
        try{
            if($this->removerArquivo($banco, $conector, $id, $dirUploadArq, $nomeArquivo) && $this->removerImagem($banco, $conector, $id, $dirUploadImg, $nomeImagem)){
                if($banco->removerLivro($conector->getConexao(), $id)){
                    $_SESSION['success'] = "eBook removido com sucesso.";
                } else {
                    $_SESSION['danger'] = "Falha ao remover livro do banco de dados.";
                }
            } else {
                $_SESSION['danger'] = "Falha ao remover livro do banco de dados.";
            }
        } catch (Exception $e) {
            $_SESSION['danger'] = "Falha ao remover livro do banco de dados.";
        }
        header("Location: ../php/ebooks.php");
    }

    # Funcao para alterar os dados de um livro no banco de dados
    public function alterarLivro($id, $nome, $descricao, $categoriaId, $imagem, $nomeImagem, $nomeImagemAntigo, $arquivo, $nomeArquivo, $nomeArquivoAntigo, $case){
        $conector = new Conector();
        $banco = new BancoLivro();
        $dirUploadImg = "../imgUp/";
        $dirUploadArq = "../arqUp/";
        $livro = new Livro($id, $nome, $descricao, $categoriaId, 0, $nomeImagem, $nomeArquivo);
        try{
            switch($case){
                case 1: # Apenas dados do livro
                    if($banco->alterarLivro($conector->getConexao(), $livro)){
                        $_SESSION['success'] = "eBook alterado com sucesso.";
                    } else {
                        $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                    }
                    break;
                
                case 2: # Livro e Arquivo
                    if($this->alterarArquivo($banco, $conector,  $livro, $arquivo, $nomeArquivoAntigo, $dirUploadArq)){
                        if($banco->alterarLivro($conector->getConexao(), $livro)){
                            $_SESSION['success'] = "eBook alterado com sucesso.";
                        } else {
                            $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                        }
                    } else {
                        $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                    }
                    break;

                case 3: # Livro e Imagem
                    if($this->alterarImagem($banco, $conector, $livro, $imagem, $nomeImagemAntigo, $dirUploadImg)){
                        if($banco->alterarLivro($conector->getConexao(), $livro)){
                            $_SESSION['success'] = "eBook alterado com sucesso.";
                        } else {
                            $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                        }
                    } else {
                        $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                    }
                    break;

                case 4: # Livro, Arquivo e Imagem
                    if($this->alterarArquivo($banco, $conector, $livro, $arquivo, $nomeArquivoAntigo, $dirUploadArq) && $this->alterarImagem($banco, $conector, $livro, $imagem, $nomeImagemAntigo, $dirUploadImg)){
                        if($banco->alterarLivro($conector->getConexao(), $livro)){
                            $_SESSION['success'] = "eBook alterado com sucesso.";
                        } else {
                            $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                        }
                    } else {
                        $_SESSION = "Falha ao alterar arquivo, tente novamente.";
                    }
                    break;
            }
        } catch(Exception $e) {
            $_SESSION = "Falha ao alterar arquivo, tente novamente.";
        }
        header("Location: ../php/ebooks.php");
    }

    # Funcao para inserir uma imagem no banco de dados
    private function cadastrarImagem(BancoLivro $banco, Conector $conector, Livro $livro, $imagem, $dirUploadImg){
        move_uploaded_file($imagem['tmp_name'], $dirUploadImg.$livro->getImagem());
        return $banco->cadastrarImagem($conector->getConexao(), $livro);
    }

    # Funcao para remover uma imagem do banco de dados
    private function removerImagem(BancoLivro $banco, Conector $conector, $id, $dirUploadImg, $nomeImagem){
        unlink($dirUploadImg.$nomeImagem);
        return $banco->removerImagem($conector->getConexao(), $id);
    }

    # Funcao para alterar os dados de uma imagem no banco de dados
    private function alterarImagem(BancoLivro $banco, Conector $conector, Livro $livro, $imagem, $nomeImagemAntigo, $dirUploadImg){
        unlink($dirUploadImg.$nomeImagemAntigo);
        move_uploaded_file($imagem['tmp_name'], $dirUploadImg.$livro->getImagem());
        return $banco->alterarImagem($conector->getConexao(), $livro);
    }

    # Funcao para inserir um arquivo no banco de dados
    private function cadastrarArquivo(BancoLivro $banco, Conector $conector, Livro $livro, $arquivo, $dirUploadArq){
        move_uploaded_file($arquivo['tmp_name'], $dirUploadArq.$livro->getArquivo());
        return $banco->cadastrarArquivo($conector->getConexao(), $livro);
    }

    # Funcao para remover um arquivo do banco de dados
    private function removerArquivo(BancoLivro $banco, Conector $conector, $id, $dirUploadArq, $nomeArquivo){
        unlink($dirUploadArq.$nomeArquivo);
        return $banco->removerArquivo($conector->getConexao(), $id);
    }

    # Funcao para alterar os dados de um arquivo no banco de dados
    private function alterarArquivo(BancoLivro $banco, Conector $conector, Livro $livro, $arquivo, $nomeArquivoAntigo, $dirUploadArq){
        unlink($dirUploadArq.$nomeArquivoAntigo);
        move_uploaded_file($arquivo['tmp_name'], $dirUploadArq.$livro->getArquivo());
        return $banco->alterarArquivo($conector->getConexao(), $livro);
    }

    # Funcao para obter uma lista dos livros no banco de dados
    public function getLivros($pagina, $quantidade){
        $conector = new Conector();
        $banco = new BancoLivro();
        return $banco->getLivros($conector->getConexao(), $pagina, $quantidade);
    }

    # Funcao para obter uma lista dos livros no banco de dados com um filtro de pesquisa
    public function getLivrosPesquisa($pagina, $quantidade, $ordem, $nomeRes, $categoria){
        $conector = new Conector();
        $banco = new BancoLivro();
        return $banco->getLivrosPesquisa($conector->getConexao(), $pagina, $quantidade, $ordem, $nomeRes, $categoria);
    }
}
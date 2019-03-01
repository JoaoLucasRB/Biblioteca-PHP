<?php

# Importacoes necessarias
require_once("logica-usuario.php"); # Funcoes de gerenciamento do usuario (restricao de acesso a pagina)
require_once("livro.php"); # Classe do Objeto

class BancoLivro {

    # Funcao que retorna o ultimo id inserido no banco de dados
    public function getUltimoId($conexaoBD){
        return $conexaoBD->insert_id;
    }

    # Funcao para cadastrar um novo livro no banco de dados
    public function cadastrarLivro($conexaoBD, Livro $livro){
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $descricao = $conexaoBD->real_escape_string($livro->getDescricao());
        $categoria_id = $conexaoBD->real_escape_string($livro->getCategoriaId());
        $query = "insert into livro (nome, descricao, categoria_id) values ('{$nome}', '{$descricao}', {$categoria_id})";
        return $conexaoBD->query($query);
    }

    # Funcao para cadastrar uma nova imagem de um livro no banco de dados
    public function cadastrarImagem($conexaoBD, Livro $livro){
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $imagem = $conexaoBD->real_escape_string($livro->getImagem());
        $livro_id = $conexaoBD->real_escape_string($livro->getId());
        $query = "insert into imagens (nome, imagem, livro_id) values ('{$nome}', '{$imagem}', {$livro_id})";
        return $conexaoBD->query($query);
    }

    # Funcao para cadastrar um novo arquivo de um livro no banco de dados
    public function cadastrarArquivo($conexaoBD, Livro $livro){
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $arquivo = $conexaoBD->real_escape_string($livro->getArquivo());
        $livro_id = $conexaoBD->real_escape_string($livro->getId());
        $query = "insert into arquivos (nome, arquivo, livro_id) values ('{$nome}', '{$arquivo}', {$livro_id})";
        return $conexaoBD->query($query);
    }

    # Funcao para remover um livro do banco de dados
    public function removerLivro($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from livro where id={$id}";
        return $conexaoBD->query($query);
    }
    
    # Funcao para remover uma imagem do banco de dados
    public function removerImagem($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from imagens where livro_id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para remover um arquivo do banco de dados
    public function removerArquivo($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from arquivos where livro_id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para alterar os dados de um livro no banco de dados
    public function alterarLivro($conexaoBD, Livro $livro){
        $id = $conexaoBD->real_escape_string($livro->getId());
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $descricao = $conexaoBD->real_escape_string($livro->getDescricao());
        $categoria_id = $conexaoBD->real_escape_string($livro->getCategoriaId());
        $query = "update livro set nome='{$nome}', descricao='{$descricao}', categoria_id={$categoria_id} where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para alterar os dados de uma imagem no banco de dados
    public function alterarImagem($conexaoBD, Livro $livro){
        $id = $conexaoBD->real_escape_string($livro->getId());
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $nomeImagem = $conexaoBD->real_escape_string($livro->getImagem());
        $query = "update imagens set nome='{$nome}', imagem='{$nomeImagem}' where livro_id={$id}";
        return $conexaoBD->query($query);
    }
    # Funcao para alterar os dados de um arquivo no banco de dados
    public function alterarArquivo($conexaoBD, Livro $livro){
        $id = $conexaoBD->real_escape_string($livro->getId());
        $nome = $conexaoBD->real_escape_string($livro->getNome());
        $nomeArquivo = $conexaoBD->real_escape_string($livro->getArquivo());
        $query = "update arquivos set nome='{$nome}', arquivo='{$nomeArquivo}' where livro_id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao que retorna a lista de todos os livros no banco de dados
    public function getLivros($conexaoBD, $pagina, $quantidade){
        $inicio = 0 + ($quantidade * ($pagina - 1));
        $inicio = $conexaoBD->real_escape_string($inicio);
        $quantidade = $conexaoBD->real_escape_string($quantidade);
        $query = "select l.id, l.nome, l.descricao, l.categoria_id, l.data, a.arquivo, i.imagem from livro l join 
                    imagens i on i.livro_id = l.id join 
                    arquivos a on a.livro_id = l.id 
                    limit {$inicio},{$quantidade}";
        $resultado = $conexaoBD->query($query);
        $livros = array();
        while($livro = $resultado->fetch_assoc()){
            array_push($livros, new Livro($livro['id'], $livro['nome'], $livro['descricao'], $livro['categoria_id'], $livro['data'], $livro['imagem'], $livro['arquivo']));
        }
        return $livros;
    }

    # Funcao que retorna a lista de livros de acordo com o filtro de pesquisa
    public function getLivrosPesquisa($conexaoBD, $pagina, $quantidade, $ordem, $nomeRes, $categoria){
        if($ordem == 1){
            $ordem = "p.data desc";
        } else if($ordem == 2){
            $ordem = "p.nome";
        }
        # posicao de inicio de acordo com a quantidade por pagina
        $inicio = 0 + ($quantidade * ($pagina - 1));
    
        $ordem = $conexaoBD->real_escape_string($ordem);
        $categoria_id = $conexaoBD->real_escape_string($categoria);
        $quantidade = $conexaoBD->real_escape_string($quantidade);
        $inicio = $conexaoBD->real_escape_string($inicio);
        if($nomeRes == ""){
            # Caso alguma categoria esteja selecionada
            if($categoria_id != 0){
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from livro p join 
                    imagens i on i.livro_id = p.id join 
                    arquivos a on a.livro_id = p.id join 
                    categoria c on p.categoria_id = c.id where c.id={$categoria_id} order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = $conexaoBD->query($query);
                while($produto = $resultado->fetch_assoc()){
                    array_push($produtos, new Livro($produto['id'], $produto['nome'], $produto['descricao'], 0, $produto['data'], $produto['imagem'], $produto['arquivo']));
                }
                return $produtos;
            # Caso nenhuma categoria esteja selecionada
            } else {
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from livro p join
                imagens i on i.livro_id = p.id join
                arquivos a on a.livro_id = p.id  
                order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = $conexaoBD->query($query);
                while($produto = $resultado->fetch_assoc()){
                    array_push($produtos, new Livro($produto['id'], $produto['nome'], $produto['descricao'], 0, $produto['data'], $produto['imagem'], $produto['arquivo']));
                }
                return $produtos;
            }
        } else {
            $nomeRes = $conexaoBD->real_escape_string($nomeRes);
            # Caso alguma categoria esteja selecionada
            if($categoria_id != 0){
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from livro p join
                        imagens i on i.livro_id = p.id join
                        arquivos a on a.livro_id = p.id
                        categoria c on p.categoria_id = c.id where c.id={$categoria_id} and p.nome like '%{$nomeRes}%' order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = $conexaoBD->query($query);
                while($produto = $resultado->fetch_assoc()){
                    array_push($produtos, new Livro($produto['id'], $produto['nome'], $produto['descricao'], 0, $produto['data'], $produto['imagem'], $produto['arquivo']));
                }
                return $produtos;
            # Caso nenhuma categoria esteja selecionada
            } else {
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from livro p join
                imagens i on i.livro_id = p.id join
                arquivos a on a.livro_id = p.id 
                where p.nome like '%{$nomeRes}%' order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = $conexaoBD->query($query);
                while($produto = $resultado->fetch_assoc()){
                    array_push($produtos, new Livro($produto['id'], $produto['nome'], $produto['descricao'], 0, $produto['data'], $produto['imagem'], $produto['arquivo']));
                }
                return $produtos;
            }
        }
    }
}
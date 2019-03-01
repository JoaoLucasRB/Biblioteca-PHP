<?php

# Importacoes necessarias
require_once("categoria.php"); # Classe do Objeto

class BancoCategoria {

    # Funcao para adicionar uma nova categoria no banco de dados
    public function adicionarCategoria($conexaoBD, Categoria $categoria){
        $nome = $conexaoBD->real_escape_string($categoria->getNome());
        $query = "insert into categoria (nome_categoria) values ('{$nome}')";
        return $conexaoBD->query($query);
    }

    # Funcao para remover uma categoria do banco de dados
    public function removerCategoria($conexaoBD, $id){
        $id = $conexaoBD->real_escape_string($id);
        $query = "delete from categoria where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao para alterar uma categoria no banco de dados
    public function alterarCategoria($conexaoBD, Categoria $categoria){
        $id = $conexaoBD->real_escape_String($categoria->getId());
        $nome = $conexaoBD->real_escape_string($categoria->getNome());
        $query = "update categoria set nome_categoria='{$nome}' where id={$id}";
        return $conexaoBD->query($query);
    }

    # Funcao que retorna uma lista com todas as categorias no banco de dados
    public function getCategorias($conexaoBD){
        $query = "select id, nome_categoria from categoria";
        $resultado = $conexaoBD->query($query);
        $categorias = array();
        while($categoria = $resultado->fetch_assoc()){
            array_push($categorias, new Categoria($categoria['id'], $categoria['nome_categoria']));
        }
        return $categorias;
    }

}
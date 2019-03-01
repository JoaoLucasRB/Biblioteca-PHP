<?php

require_once("banco-paginacao.php");
require_once("conector.php");

class Paginacao {

    # Funcao que retorna a pagina anterior
    public function anteriorPagina($pagina){
        if($pagina == 1){
            return 1;
        } else {
            return $pagina-1;
        }
    }

    # Funcao que retorna a proxima pagina
    public function proximaPagina($pagina){
        return $pagina+1;
    }

    # Funcao que retorna o total de paginas
    public function getPaginas(){
        $conector = new Conector();
        $banco = new BancoPaginacao();
        return $banco->getPaginas($conector->getConexao());
    }

    # Funca para listar os eBooks seguindo a paginacao | gerenciar eBooks
    public function getEbooks($conexao, $pagina){
        $quantidade = 15;
        $inicio = 0 + ($quantidade * ($pagina - 1));
        $inicio = mysqli_real_escape_string($conexao, $inicio);
        $quantidade = mysqli_real_escape_string($conexao, $quantidade);

        $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from produto p join 
                    imagens i on i.produto_id = p.id join 
                    arquivos a on a.produto_id = p.id 
                    limit {$inicio},{$quantidade}";
        $resultado = mysqli_query($conexao, $query);
        $categorias = array();
        while($categoria = mysqli_fetch_assoc($resultado)){
            array_push($categorias, $categoria);
        }
        return $categorias;
    }

    # Funcao para listar os eBooks seguindo a paginacao | home
    public function getLimEb($conexao, $pagina, $quantidade, $ordem, $nomeRes, $categoria_id){
        if($ordem == 1){
            $ordem = "p.data desc";
        } else if($ordem == 2){
            $ordem = "p.nome";
        }
        # posicao de inicio de acordo com a quantidade por pagina
        $inicio = 0 + ($quantidade * ($pagina - 1));

        $ordem = mysqli_real_escape_string($conexao, $ordem);
        $categoria_id = mysqli_real_escape_string($conexao, $categoria_id);
        $quantidade = mysqli_real_escape_string($conexao, $quantidade);
        $inicio = mysqli_real_escape_string($conexao, $inicio);
        if($nomeRes == ""){
            # Caso alguma categoria esteja selecionada
            if($categoria_id != 0){
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from produto p join 
                    imagens i on i.produto_id = p.id join 
                    arquivos a on a.produto_id = p.id join 
                    categoria c on p.categoria_id = c.id where c.id={$categoria_id} order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = mysqli_query($conexao, $query);
                while($produto = mysqli_fetch_assoc($resultado)){
                    array_push($produtos, $produto);
                }
                return $produtos;
            # Caso nenhuma categoria esteja selecionada
            } else {
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from produto p join
                imagens i on i.produto_id = p.id join
                arquivos a on a.produto_id = p.id  
                order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = mysqli_query($conexao, $query);
                while($produto = mysqli_fetch_assoc($resultado)){
                    array_push($produtos, $produto);
                }
                return $produtos;
            }
        } else {
            $nomeRes = mysqli_real_escape_string($conexao, $nomeRes);
            # Caso alguma categoria esteja selecionada
            if($categoria_id != 0){
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from produto p join
                        imagens i on i.produto_id = p.id join
                        arquivos a on a.produto_id = p.id
                        categoria c on p.categoria_id = c.id where c.id={$categoria_id} and p.nome like '%{$nomeRes}%' order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = mysqli_query($conexao, $query);
                while($produto = mysqli_fetch_assoc($resultado)){
                    array_push($produtos, $produto);
                }
                return $produtos;
            # Caso nenhuma categoria esteja selecionada
            } else {
                $query = "select p.id, p.nome, p.descricao, p.data, a.arquivo, i.imagem from produto p join
                imagens i on i.produto_id = p.id join
                arquivos a on a.produto_id = p.id 
                where p.nome like '%{$nomeRes}%' order by {$ordem} limit {$inicio},{$quantidade}";
                $produtos = array();
                $resultado = mysqli_query($conexao, $query);
                while($produto = mysqli_fetch_assoc($resultado)){
                    array_push($produtos, $produto);
                }
                return $produtos;
            }
        }
        
    }
}

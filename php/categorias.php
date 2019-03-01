<?php
# Include do codigo de funcoes de gerenciamento do usuario
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();
# Include de arquivo com codigo do cabecalho/<head>
require_once("cabecalho.php");

if(isset($_GET['pagina'])){
    $pagina = $_GET['pagina'];
} else {
    $pagina = 1;
}

if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php unset($_SESSION['success']);
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>
    <?php unset($_SESSION["danger"]);
}
?>

<div class="row">
    <!-- Coluna esquerda -->
    <div class="col-6">
        <!-- Tabela categorias -->
        <div class="row">
            <div class="col">
                <div class="row table-bordered">
                    <div class="col-1 table-bordered">
                        <p>Id</p>
                    </div>
                    <div class="col-9 table-bordered">
                        <p>Nome</p>
                    </div>
                </div>
                <?php
                $categorias = $controlador->getCategorias();
                foreach($categorias as $categoria){ ?>
                    <div class="row">
                        <div class="col-1 table-bordered">
                            <p><?=$categoria->getId()?></p>
                        </div>
                        <div class="col-9 table-bordered">
                            <p><?=$categoria->getNome()?></p>
                        </div>
                        <div class="col-2 table-bordered">
                            <form enctype="multipart/form-data" action="categorias.php" method="post">
                                <input type="hidden" name="idCat" value="<?=$categoria->getId()?>" />
                                <input type="hidden" name="nomeCat" value="<?=$categoria->getNome()?>" />
                                <input type="hidden" name="editar" />
                                <button type="submit" class="btn btn-primary">Editar</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div> 
        </div>
        <!-- FIm tabela -->

        <!-- Div botao novo ebook | Paginacao -->
        <div class="row">
            <!-- Div Paginacao -->
            <div class="col">
                <div align="center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            # Verifica se a variavel categoria foi passada como parametro
                            if(isset($_GET['categoria'])){
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="categorias.php?pagina=<?=$controlador->anteriorPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Previous</a></li>
                                <?php } ?>
                            <li class="page-item"><a class="page-link"><?=$pagina?></a></li>
                            <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="categorias.php?pagina=<?=$controlador->proximaPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Next</a></li>
                            <?php } ?>
                                
                            <?php } else { 
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="categorias.php?pagina=<?=$controlador->anteriorPagina($pagina)?>">Anterior</a></li>
                                <?php } ?>
                                <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                                <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="categorias.php?pagina=<?=$controlador->proximaPagina($pagina)?>">Proxima</a></li>
                                <?php } 
                            } ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /Div Paginacao -->                
        </div>
        <!-- /Div Botao/Paginacao -->

    </div>

    <div class="col-6">
        
        <!-- Criar categoria -->
        <div class="row">
            <div class="col">
                <form enctype="multipart/form-data" action = "cat-cad.php" method="post">
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="nome">Nome da Categoria</label>
                                <input type="text" id="nome" name="nome" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <div align="center">
                                <button type="submit" class="btn btn-success">Criar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Alterar Categoria -->
        <?php
        if(isset($_POST['editar'])){ 
            $idC = $_POST['idCat'];
            $nomeC = $_POST['nomeCat']?>
            <div class="row">
                <div class="col">
                    <div align="center">
                        <h5>Alterar Categoria<h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <form enctype="multipart/form-data" action="cat-alt.php" method="post">
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="nomeCategoria">Nome da categoria</label>
                                    <input type="text" id="nomeCategoria" name="nomeCategoria" class="form-control" value="<?=$nomeC?>" />
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-6">
                                <div align="right">
                                    <input type="hidden" name="idCategoria" value="<?=$idC?>" />
                                    <button type="submit" class="btn btn-warning">Alterar</button>
                                </div>
                            </div>   
                    </form>
                            <div class="col-6">
                                <div align="left">
                                    <form enctype="multipart/form-data" action="cat-del.php" method="post">
                                        <input type="hidden" name="idCatDel" value="<?=$idC?>" />
                                        <button type="submit" class="btn btn-danger">Remover</button> 
                                    </form>  
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php
require_once("class/controlador.php");
$controlador = new Controlador();
$controlador->verificarAcesso();
require_once("cabecalho.php");
if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php unset($_SESSION['success']);
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>
    <?php unset($_SESSION["danger"]);
} ?>

<!-- Conteudo -->
<div class="row">
    <!-- Coluna esquerda -->
    <div class="col-6">
        <!-- Div tabela grid -->
        <div class="row">
            <div class="col">
                <div class="row table-bordered">
                    <div class="col-1 table-bordered">
                        <p>Id</p>
                    </div>
                    <div class="col-5 table-bordered">
                        <p>Nome de Usuario</p>
                    </div>
                    <div class="col-4 table-bordered">
                        <p>Data de criacao</p>
                    </div>
                </div>
                <?php
                # Verifica se a variavel pagina foi passada como parametro
                if(isset($_GET['pagina'])){
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina = 1;
                }
                $usuarios = $controlador->getUsuarios($pagina);
                if($controlador->privilegio() == 1){
                    foreach($usuarios as $usuario){ ?>
                        <div class="row">
                            <div class="col-1 table-bordered">
                                <p><?=$usuario->getId()?></p>
                            </div>
                            <div class="col-5 table-bordered">
                                <p><?=$usuario->getNome()?></p>
                            </div>
                            <div class="col-4 table-bordered">
                                <p><?php $date = new DateTime($usuario->getData()); echo $date->format('d/m/Y | H:i:s'); ?></p>
                            </div>
                            <div class="col-2 table-bordered">
                                <form enctype="multipart/form-data" action="usuarios.php" method="post">
                                    <input type="hidden" name="idUser" value="<?=$usuario->getId()?>" />
                                    <input type="hidden" name="nomeUser" value="<?=$usuario->getNome()?>" />
                                    <input type="hidden" name="emailUser" value="<?=$usuario->getEmail()?>" />
                                    <input type="hidden" name="privTipo" value="<?=$usuario->getPrivilegioId()?>" />
                                    <input type="hidden" name="privUser" value="<?=$usuario->getPrivilegioNome()?>" />
                                    <input type="hidden" name="dataUser" value="<?=$usuario->getData()?>" />
                                    <input type="hidden" name="editar" />
                                    <button type="submit" class="btn btn-primary">Editar</button>
                                </form>
                            </div>
                        </div>
                    <?php }
                } else {
                    foreach($usuarios as $usuario){ 
                        if($usuario->getPrivilegioId() > $controlador->privilegio()){ ?>
                            <div class="row">
                                <div class="col-2 table-bordered">
                                    <p><?=$usuario->getId()?></p>
                                </div>
                                <div class="col-4 table-bordered">
                                    <p><?=$usuario->getNome()?></p>
                                </div>
                                <div class="col-4 table-bordered">
                                    <p><?php $date = new DateTime($usuario->getData()); echo $date->format('d/m/Y | H:i:s'); ?></p>
                                </div>
                                <div class="col-2 table-bordered">
                                    <form enctype="multipart/form-data" action="usuarios.php" method="post">
                                        <input type="hidden" name="idUser" value="<?=$usuario->getId()?>" />
                                        <input type="hidden" name="nomeUser" value="<?=$usuario->getNome()?>" />
                                        <input type="hidden" name="emailUser" value="<?=$usuario->getEmail()?>" />
                                        <input type="hidden" name="privTipo" value="<?=$usuario->getPrivilegioId()?>" />
                                        <input type="hidden" name="privUser" value="<?=$usuario->getPrivilegioNome()?>" />
                                        <input type="hidden" name="dataUser" value="<?=$usuario->getData()?>" />
                                        <input type="hidden" name="editar" />
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                    </form>
                                </div>
                            </div>
                        <?php }
                    }  
                } ?>
                
            </div>
        </div>
        <!-- /tabela grid -->  
        <!-- Div botao novo ebook | Paginacao -->
        <div class="row">
            <!-- Div botao -->
            <div class="col-6">
                <div align="center">
                    <?php if($pagina != 1){ ?>
                        <a href="usuarios.php?pagina=<?=$pagina?>" class="btn btn-success" role="button">Novo Usuario</a>
                    <?php } else { ?>
                        <a href="usuarios.php" class="btn btn-success" role="button">Novo Usuario</a>
                    <?php } ?>
                </div>
            </div>
            <!-- /Div botao -->
            <!-- Div Paginacao -->
            <div class="col-6">
                <div align="center">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <?php
                            # Verifica se a variavel categoria foi passada como parametro
                            if(isset($_GET['categoria'])){
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="usuarios.php?pagina=<?=$controlador->anteriorPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Previous</a></li>
                                <?php } ?>
                            <li class="page-item"><a class="page-link"><?=$pagina?></a></li>
                            <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="usuarios.php?pagina=<?=$controlador->proximaPagina($pagina)?>&categoria=<?=$_GET['categoria']?>">Next</a></li>
                            <?php } ?>
                                
                            <?php } else { 
                                if($pagina > 1){ ?>
                                <li class="page-item"><a class="page-link" href="usuarios.php?pagina=<?=$controlador->anteriorPagina($pagina)?>">Anterior</a></li>
                                <?php } ?>
                                <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                                <?php if($pagina < $controlador->getPaginas()){ ?>
                                <li class="page-item"><a class="page-link" href="usuarios.php?pagina=<?=$controlador->proximaPagina($pagina)?>">Proxima</a></li>
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
    <!-- /Coluna esquerda -->
    <!-- Coluna direita -->
    <div class="col-6"> 
        <?php
        if(isset($_POST['editar'])){   # Tela-Editar 
            $idUser = $_POST['idUser'];
            $privId = $_POST['privTipo'];
            $nomeUser = $_POST['nomeUser'];
            $emailUser = $_POST['emailUser'];
            $privNome = $_POST['privUser'];?> 
            <div class="row">
                <div class="col">
                    <div align="center">
                        <h4>Editar Usuario</h4>
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data" action="user-alt.php" method="post">
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nomeUsuario">Nome de Usuario</label>
                            <input type="text" name="nomeUsuario" id="nomeUsuario" class="form-control" value="<?=$nomeUser?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="emailUsuario">Email</label>
                            <input type="text" name="emailUsuario" id="emailUsuario" class="form-control" value="<?=$emailUser?>">
                        </div>
                    </div>
                </div>
                <?php
                if($controlador->privilegio() == 1){ ?>
                    <div class="form-row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="privUser">Nivel de acesso</label>
                                <select name="privUser" id="privUser" class="form-control">
                                    <?php
                                    $privilegios = $controlador->getPrivilegios();
                                    foreach($privilegios as $privilegio){
                                        if($privilegio->getNome() == $privNome){ ?>
                                            <option value="<?=$privilegio->getId()?>" selected><?=$privilegio->getNome()?></option>
                                        <?php } else { ?>
                                            <option value="<?=$privilegio->getId()?>"><?=$privilegio->getNome()?></option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" value="<?=$privId?>" />
                <?php } ?>

                <div class="form-row">
                    <div class="col-6">
                        <div align="right">
                            <input type="hidden" name="idUser" value="<?=$idUser?>" />
                            <input type="hidden" name="nomeUsuarioAntigo" value="<?=$nomeUser?>" />
                            <input type="hidden" name="emailUsuarioAntigo" value="<?=$emailUser?>" />
                            <button type="submit" class="btn btn-warning">Alterar</button>
                        </div>
                    </div>
            </form>            
                    <div class="col-6">
                        <div align="left">
                            <form enctype="multipart/form-data" action="user-del.php" method="post">
                                <input type="hidden" name="idUser" value="<?=$idUser?>" />
                                <button type="submit" class="btn btn-danger">Deletar</button>
                            </form>
                        </div>
                    </div>
                </div>
        <?php } else { ?> <!-- Tela cadastro -->
            <div class="row">
                <div class="col">
                    <div align="center">
                        <h4>Cadastrar Usuario</h4>
                    </div>
                </div>
            </div>
            <form enctype="multipart/form-data" action="user-cad.php" method="post"> 
                <!-- Div nome do usuario/email do usuario -->
                <div class="form-row">
                    <!-- Div nome -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="nomeUsuario">Nome de Usuario</label>
                            <input type="text" name="nomeUsuario" id="nomeUsuario" class="form-control" />
                        </div>
                    </div>
                    <!-- Div email -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="emailUsuario">Email</label>
                            <input type="email" name="emailUsuario" id="emailUsuario" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- /Div nome do usuario/email do usuario -->
                <!-- Div senha -->
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="senUsuario">Senha</label>
                            <input type="password" name="senUsuario" id="senUsuario" onchange="confirmacao()" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="confSen">Confirme a senha</label>
                            <input type="password" name="confSen" id="confSen" onchange="confirmacao()" class="form-control">
                        </div>
                    </div>
                </div>
                <!-- /Div senha -->
                <!-- Div privilegios (Master apenas) -->
                <?php
                if($controlador->privilegio() == 1){ ?>
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="selPriv">Nivel de acesso</label>
                                <select id="selPriv" name="privUsuario" class="form-control">
                                    <?php
                                    $privilegios = $controlador->getPrivilegios();
                                    foreach($privilegios as $privilegio){ ?>
                                        <option value="<?=$privilegio->getId()?>"><?=$privilegio->getNome()?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <input type="hidden" value="3" name="privUsuario" />
                <?php } ?>
                <!-- Div confirmacao / botao cadastrar -->
                <div class="form-row">
                    <div class="col-6">
                        <div id="confirmacao" class="form-group">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div align="center">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Div confirmacao /botao cadastrar -->
            </form>
        <?php } ?>
    </div>
    <!-- /Coluna direita -->
</div>
<!-- /Conteudo -->
<script>
function confirmacao(){
    if(document.getElementById("confSen").value != document.getElementById("senUsuario").value){
        document.getElementById("confirmacao").innerHTML = "<p class='alert alert-warning'>As senhas nao sao iguais</p>";
    } else {
        document.getElementById("confirmacao").innerHTML = "<p class='alert alert-success'>As senhas sao iguais</p>";
    }
}
</script>
<?php include("rodape.php"); ?>
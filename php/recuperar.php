<?php

require_once("class/controlador.php");
$controlador = new Controlador();

if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php unset($_SESSION['success']);
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>;
    <?php unset($_SESSION["danger"]);
} 

$chaveRec = $_GET['chave'];
$recuperacao = $controlador->getRecuperacao($chaveRec);
?>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>TesteArquivos</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/shop-homepage.css" rel="stylesheet">

</head>

<body>
    <div class="row">
    </div>
    <div class="row">
        <div class="col-4">
        </div>
        <div class="col-4">
            <div align="center">
                <form enctype="multipart/form-data" action="rec-conf.php" method="post"> 

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

                    <!-- Div confirmacao / botao cadastrar -->
                    <div id="confirmacao" class="form-row">
                        
                    </div>
                    <!-- /Div confirmacao /botao cadastrar -->

                </form>
            </div>
        </div>
        <div class="col-4">
        </div>
    </div>
    <div class="row">
    </div>

<script>
function confirmacao(){
    if(document.getElementById("confSen").value != document.getElementById("senUsuario").value){
        document.getElementById("confirmacao").innerHTML = "<p class='alert alert-warning'>As senhas nao sao iguais</p>";
    } else {
        document.getElementById("confirmacao").innerHTML = "<div class='col-6'><div class='form-group'><p class='alert alert-success'>As senhas sao iguais</p></div></div><div class='col-6'><div class='form-group'><div align='center'><input type='hidden' name='chave' value='<?=$chaveRec?>'/><input type='hidden' name='id' value='<?=$recuperacao['idRec']?>'/><button type='submit' class='btn btn-success'>Enviar</button></div></div></div>";
    }
}
</script>

</body>

</html>
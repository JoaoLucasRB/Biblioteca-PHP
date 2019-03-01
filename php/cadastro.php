<?php
session_start();
if(isset($_SESSION['success'])){ ?>
    <p class='alert alert-success'><?=$_SESSION['success']?></p>
    <?php unset($_SESSION['success']);
} else if (isset($_SESSION["warning"])){ ?>
    <p class='alert alert-warning'><?=$_SESSION['warning']?></p>
    <?php unset($_SESSION["warning"]);
} else if (isset($_SESSION["danger"])){ ?>
    <p class='alert alert-danger'><?=$_SESSION["danger"]?></p>;
    <?php unset($_SESSION["danger"]);
} ?>

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Cadastro Biblioteca Cenep</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/shop-homepage.css" rel="stylesheet">

</head>

<body>
    <!-- div linha esquerda | alinhamento -->
    <div class="row">
    </div>

    <!-- div linha central | informacoes de cadastro -->
    <div class="row">

        <!-- div coluna esquerda | alinhamento -->
        <div class="col-4">
        </div>

        <!-- div coluna central | informacoes de cadastro -->
        <div class="col-4">
            <div align="center">
                <form enctype="multipart/form-data" action="novo-user.php" method="post"> 

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

                    <!-- privilegio -->
                    <input type="hidden" value="3" name="privUsuario" />

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
            </div>
        </div>
        <!-- /fim Coluna central -->

        <!-- Div Coluna direita | alinhamento -->
        <div class="col-4">
        </div>

    </div>
    <!-- /fim Div linha central -->

    <!-- Div linha baixo | Alinhamento -->
    <div class="row">
    </div>

<!-- Script comparacao senhas -->
<script>
function confirmacao(){
    if(document.getElementById("confSen").value != document.getElementById("senUsuario").value){
        document.getElementById("confirmacao").innerHTML = "<p class='alert alert-warning'>As senhas nao sao iguais</p>";
    } else {
        document.getElementById("confirmacao").innerHTML = "<p class='alert alert-success'>As senhas sao iguais</p>";
    }
}
</script>

</body>

</html>
<?php
session_start();
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

<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Recuperacao de Senha</title>

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
                <form enctype="multipart/form-data" action="rec-user.php" method="post"> 

                    <!-- email do usuario -->
                    <div class="form-row">
                        <div class="col">
                            <div class="form-group">
                                <label for="emailUsuario">Email</label>
                                <input type="email" name="emailUsuario" id="emailUsuario" class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- /Div nome do usuario/email do usuario -->

                    <!-- Div confirmacao / botao cadastrar -->
                    <div class="form-row">
                        <div class="col">
                            <div align="center">
                                <button type="submit" class="btn btn-success">Enviar</button>
                            </div>
                        </div>
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

</body>

</html>
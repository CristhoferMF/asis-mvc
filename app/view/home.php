<?php 
require_once 'app/controller/home_controller.php';

?>
<!doctype html>
<html lang="es">

<head>
    <title>Pagina Principal</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS Material Design -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css"
        integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="public/assets/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap Script Material Design -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9"
        crossorigin="anonymous"></script>
    <script src="public/assets/js/home.js"></script>
    <script>
        $(document).ready(function () {
            $('body').bootstrapMaterialDesign();
        });
    </script>
</head>

<body>
    <div class="main col-xl-11 col-md-12 col-12 row">
        <div class="contenedor col-xl-6">
        <div class="formulario-marcar">
            <h2>MARCAR ASISTENCIA</h2>
                <div class="form-row">
                    <div class="form-group col-12">
                        <select class="custom-select" id="select-practicante">
                            <option selected value="0">Escoger</option>
                            <?php for ($i=0; $i < sizeof($totPracticantes) ; $i++) { 
                               echo "<option class='";
                               if(empty($totPracticantes[$i]['horEntrada'])){
                                echo "incompleto";
                               }elseif(empty($totPracticantes[$i]['horSalida'])){
                                echo "salida";
                               }else{
                                echo "completo";
                               }
                               echo "' value='".$totPracticantes[$i]['dni']."'>".$totPracticantes[$i]['nomCompleto']."</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                        <div id="nombre-practicante" class='col-md-5 nombre-practicante'>
                            <p>
                                <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                <span>Ningun practicante seleccionado</span>
                            </p>
                        </div>
                        <div id="opciones-practicante" class='col-md-7 row m-auto'>
                            <div class="col-12 col-md-6" id="div-button-ingreso">
                            <button class='btn btn-default col disabled' data-action='disable'>Registrar Entrada</button>
                            </div>
                            <div class="col-12 col-md-6" id="div-button-salida">
                            <button class='btn btn-default col disabled' data-action='disable'>Registrar Salida</button>
                            </div>
                        </div>
                </div>
        </div>
        </div>
        <div class="contenedor col-xl-6">
        <div class="formulario-marcar">
            <h2>TABLA DE ASISTENCIA <?php echo date("d/m/Y"); ?></h2>
            <form action="">
                <div class="table-responsive">
                   <table class="table table-hover">
                       <thead>
                           <tr>
                               <th>DNI</th>
                               <th>NOMBRES COMPLETOS</th>
                               <th>HORA LLEGADA</th>
                               <th>HORA SALIDA</th>
                           </tr>
                       </thead>
                       <tbody id="table-body">
                           
                       </tbody>
                   </table>
                </div>
            </form>
        </div>
        </div>
    </div>

</body>

</html>

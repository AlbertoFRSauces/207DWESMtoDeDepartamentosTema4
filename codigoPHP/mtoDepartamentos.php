<?php
//Comprobar si se ha pulsado el boton volver
        if (isset($_REQUEST['volver'])) {
            header('Location: ../indexProyectoMtoDepartamentosTema4.php');
            exit;
        }
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Alberto Fernandez Ramirez">
        <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
        <title>MtoDepartamentosTema4</title>
    </head>
    <body>
        <?php
        /*
         * @author: Alberto Fernandez Ramirez
         * @version: 1.2 Realizacion del ejercicio
         * @since: Version 1.0
         * @copyright: Copyright (c) 2021, Alberto Fernandez Ramirez
         * Created on: 16-Noviembre-2021
         * Ejercicio 9. Aplicación resumen MtoDepartamentosTema4.
         */
        //Incluyo las variables de la conexion
        require_once '../config/configDBPDO.php';
        //Incluyo la libreria de validacion
        require_once '../core/210322ValidacionFormularios.php';
        
        //Variable OPCIONAL inicializada a 0
        define("OPCIONAL", 0);

        //Variables maximos y minimos
        define("TAMANO_MAXIMO_DESCDEPARTAMENTO", 255); //Maximo del campo DescDepartamento
        
        //Variable de entrada correcta inicializada a true
        $entradaOK = true;

        //Creo el array de errores y lo inicializo a null
        $aErrores = [
            'descDepartamento' => null
        ];

        //Creo el array de respuestas y lo incializo a null
        $aRespuestas = [
            'descDepartamento' => null
        ];

        
        ?>
        <form name="formulario" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form">
            <fieldset>
                <p> MtoDepartamentos 
                    <input class="botones" id="add" type="submit" name="add" value="Añadir"/>
                    <input class="botones" id="export" type="submit" name="export" value="Exportar"/>
                    <input class="botones" id="import" type="submit" name="import" value="Importar"/>
                </p>
                <ul>
                    <!--Campo Alfabetico DescDepartamento OBLIGATORIO para realizar la busqueda-->
                    <li>
                        <div>
                            <label for="descDepartamento"><strong>Descripcion Departamento</strong></label>
                            <input name="descDepartamento" id="descDepartamento" type="text" value="<?php echo isset($_REQUEST['descDepartamento']) ? $_REQUEST['descDepartamento'] : ''; ?>" placeholder="Introduzca la Descripcion del Departamento">
                            <?php echo '<span>' . $aErrores['descDepartamento'] . '</span>' ?>
                            <!--Campo Boton Enviar-->
                            <input class="enviar" id="enviar" type="submit" name="enviar" value="Buscar"/>
                        </div>
                    </li>
                </ul>
            </fieldset>
        </form>
        
        <?php
        //Comprobar si se ha pulsado el boton enviar en el formulario
        if (isset($_REQUEST['enviar'])) {
            //Comprobar si el campo DescDepartamento esta bien rellenado
            $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], TAMANO_MAXIMO_DESCDEPARTAMENTO, OPCIONAL);

            //Comprobar si algun campo del array de errores ha sido rellenado
            foreach ($aErrores as $campo => $error) {//recorro el array errores
                if ($error != null) {//compruebo si hay algun error
                    $_REQUEST[$campo] = ''; //limpio el campo
                    $entradaOK = false; //le doy el valor false a entradaOK
                }
            }
        } else {//si el usuario no le ha dado a enviar
            $_REQUEST['descDepartamento'] = "";
            
        }

        if ($entradaOK) { // si la entrada es true recojo los valores del array aRespuestas
            $aRespuestas['descDepartamento'] = $_REQUEST['descDepartamento'];
            
            //Realizo la conexion
            try {
                //Hago la conexion con la base de datos
                $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
                // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
                $DAW207DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                //INSERCION DE DATOS EN DEPARTAMENTOS
                //Creacion de la consulta que inserta los datos en Departamento
                $consulta = "SELECT * FROM Departamento WHERE DescDepartamento LIKE '%{$_REQUEST['descDepartamento']}%';";

                $resultadoConsulta = $DAW207DBDepartamentos->prepare($consulta); // Preparo la consulta antes de ejecutarla

                $resultadoConsulta->execute(); // Ejecuto la consulta pasando los parametros del array de parametro

                if ($resultadoConsulta->rowCount() > 0) { //Si la consulta devuelve algun registro
                    ?>
                    <table>
                        <tr>
                            <th>CodDepartamento</th>
                            <th>DescDepartamento</th>
                            <th>FechaBaja</th>
                            <th>VolumenNegocio</th>
                        </tr>
                    <?php
                    
                    $oDepartamento = $resultadoConsulta->fetchObject(); // Obtengo el primer registro de la consulta como un objeto
                    while ($oDepartamento) { // recorro los registros que devuelve la consulta de la consulta
                        $codDepartamento = $oDepartamento->CodDepartamento; // obtengo el valor del codigo del departamento del registro actual y lo almaceno en una variable
                        ?>
                        <tr>
                            <td><?php echo $codDepartamento; // obtengo el valor del codigo del departamento del registro actual  ?></td>
                            <td><?php echo $oDepartamento->DescDepartamento; // obtengo el valor de la descripcion del departamento del registro actual  ?></td>
                            <td><?php echo $oDepartamento->FechaBaja; // obtengo el valor de la fecha de baja del departamento del registro actual   ?></td>
                            <td><?php echo $oDepartamento->VolumenNegocio; // obtengo el valor de la fecha de baja del departamento del registro actual   ?></td>
                            <td class="botonestabla"><a href="../codigoPHP/mtoDepartamentosEditar.php?<?php echo 'CodigoDepartamento='.$codDepartamento;?>"><img src="../webroot/css/img/lapiz.png" class="imagenboton" alt="Lapiz" /></a></td>
                            <td class="botonestabla"><img src="../webroot/css/img/papelera.png" class="imagenboton" alt="Papelera" /></td>
                            <td class="botonestabla"><img src="../webroot/css/img/ojo.png" class="imagenboton" alt="Ojo" /></td>
                        </tr>
                        <?php
                        $oDepartamento = $resultadoConsulta->fetchObject(); // guardo el registro actual como un objeto y avanzo el puntero al siguiente registro de la consulta 
                        }
                        ?>
                    </table>
                    <?php
                }
            } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
                $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
                $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException

                echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
                echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
            } finally {
                //Cierro la conexion
                unset($DAW207DBDepartamentos);
            }
        }
        ?>

        <form name="formularioBotonVolver" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="submit" class="volver" name="volver" value="Volver">
        </form>
        <footer class="piepagina">
            <a href="../indexProyectoMtoDepartamentosTema4.php"><img src="../webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
            <a href="https://github.com/AlbertoFRSauces/207DWESMtoDepartamentosTema4" target="_blank"><img src="../webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
            <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
            <p>Ultima actualización: 16/11/2021 21:00</p>
        </footer>
    </body>
</html>




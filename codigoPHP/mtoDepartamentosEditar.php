<?php
/*
 * @author: Alberto Fernandez Ramirez
 * @version: 1.0 Realizacion del ejercicio
 * @since: Version 1.0
 * @copyright: Copyright (c) 2021, Alberto Fernandez Ramirez
 * Created on: 18-Noviembre-2021
 * Ejercicio 9. Aplicación resumen MtoDepartamentosTema4.
 */

//Comprobar si se ha pulsado el boton volver
if (isset($_REQUEST['cancelar'])) {
    header('Location: ../codigoPHP/mtoDepartamentos.php');
    exit;
}

require_once '../config/configDBPDO.php';//Incluyo las variables de la conexion
require_once '../core/210322ValidacionFormularios.php';//Incluyo la libreria de validacion

define("OBLIGATORIO", 1);//Variable obligatorio inicializada a 1
$entradaOK = true;//Variable de entrada correcta inicializada a true

//Creo el array de errores y lo inicializo a null
$aErrores = [
    'descDepartamento' => null,
    'volumenNegocio' => null
];
//Creo el array de respuestas y lo incializo a null
$aRespuestas = [
    'descDepartamento' => null,
    'volumenNegocio' => null
];

try {//Obtengo el contenido de la base de datos dentro del try
    //Hago la conexion con la base de datos
    $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
    // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
    $DAW207DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //Creacion de la consulta que obtiene los datos del Departamento seleccionado
    $consulta = "SELECT * FROM Departamento WHERE codDepartamento=:codDepartamento;";

    $resultadoConsulta = $DAW207DBDepartamentos->prepare($consulta); //Preparo la consulta antes de ejecutarla
    $aParametrosEnCurso = [':codDepartamento' => $_REQUEST['CodigoDepartamento']]; //Asigno el codigo de departamento del formulario en el array
    $resultadoConsulta->execute($aParametrosEnCurso); //Ejecuto la consulta pasando los parametros del array de parametros en curso
        
    $oDepartamento = $resultadoConsulta->fetchObject(); //Obtengo el primer registro como un objeto
        
    $codDepartamentoEnCurso = $oDepartamento->CodDepartamento; //Guardo el codigo del departamento obtenido de la DB en una variable
    $descDepartamentoEnCurso = $oDepartamento->DescDepartamento; //Guardo la descripcion del departamento obtenido de la DB en una variable
    $fechaBajaEnCurso = $oDepartamento->FechaBaja; //Guardo la fecha de baja del departamento obtenido de la DB en una variable
    $volumenNegocioEnCurso = $oDepartamento->VolumenNegocio; //Guardo el volumen del negocio del departamento obtenido de la DB en una variable
} catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
    $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
    $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
    echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
    echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
} finally {
    //Cierro la conexion
    unset($DAW207DBDepartamentos);
}

//Comprobar si se ha pulsado el boton enviar en el formulario y valido los campos
if (isset($_REQUEST['aceptar'])) {
    //Comprobar si el campo alfabetico esta bien rellenado
    $aErrores['descDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['descDepartamento'], 255, 1, OBLIGATORIO);
    //Comprobar si el campo float esta bien rellenado
    $aErrores['volumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['volumenNegocio'], 3.402823466E+38, 0, OBLIGATORIO);
    
    //Comprobar si algun campo del array de errores ha sido rellenado
    foreach ($aErrores as $campo => $error) {
        if ($error != null) {
            //Limpio el campo
            $_REQUEST[$campo] = '';
            $entradaOK = false;
        }
    }
} else {
    $entradaOK = false;
}

//Si los datos han sido introducidos correctamente, los mostramos 
if ($entradaOK) {
    //Código que se ejecuta cuando se envía el formulario correctamente
    try {
        //Hago la conexion con la base de datos
        $DAW207DBDepartamentos = new PDO(HOST, USER, PASSWORD);
        // Establezco el atributo para la aparicion de errores con ATTR_ERRMODE y le pongo que cuando haya un error se lance una excepcion con ERRMODE_EXCEPTION
        $DAW207DBDepartamentos->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Creacion de la consulta que actualiza los datos en Departamento
        $consulta = "UPDATE Departamento SET DescDepartamento=:descDepartamento, VolumenNegocio=:volumenNegocio WHERE codDepartamento=:codDepartamento;";

        $resultadoConsulta = $DAW207DBDepartamentos->prepare($consulta); // Preparo la consulta antes de ejecutarla
                
        //Asigno dentro del array parametros, cada parametro con su valor obtenido en el formulario para ejecutar la consulta UPDATE
        $aParametros = [
            ':descDepartamento' => $_REQUEST['descDepartamento'],
            ':volumenNegocio' => $_REQUEST['volumenNegocio'],
            ':codDepartamento' => $codDepartamentoEnCurso
        ];

        $resultadoConsulta->execute($aParametros); // Ejecuto la consulta pasando los parametros del array de parametros
    } catch (PDOException $excepcion) {//Codigo que se ejecuta si hay algun error
        $errorExcepcion = $excepcion->getCode(); //Obtengo el codigo del error y lo almaceno en la variable errorException
        $mensajeException = $excepcion->getMessage(); //Obtengo el mensaje del error y lo almaceno en la variable mensajeException
        echo "<span style='color: red'>Codigo del error: </span>" . $errorExcepcion; //Muestro el codigo del error
        echo "<span style='color: red'>Mensaje del error: </span>" . $mensajeException; //Muestro el mensaje del error
    } finally {
        //Cierro la conexion
        unset($DAW207DBDepartamentos);
    }
    header('Location: ../codigoPHP/mtoDepartamentos.php');
} 
?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="author" content="Alberto Fernandez Ramirez">
            <link href="../webroot/css/estiloejercicio.css" rel="stylesheet" type="text/css">
            <link rel="icon" href="../webroot/css/img/home.png" type="image/x-icon">
            <title>MtoDepartamentosTema4 - Editar</title>
        </head>
        <body>
            <main>
                <form name="formulario" action="<?php echo $_SERVER['PHP_SELF'] . "?CodigoDepartamento=" . $codDepartamentoEnCurso; ?>" method="post" class="formularioeditar">
                    <fieldset class="fieldsetEditar">
                        <p>Editar departamento</p>
                        <ul>
                            <!--Campo Codigo de Departamento-->
                            <li>
                                <div>
                                    <label for="codDepartamento"><strong>Código de departamento</strong></label>
                                    <input name="codDepartamento" id="codDepartamento" type="text" value="<?php echo $codDepartamentoEnCurso?>" readonly>
                                    
                                </div>
                            </li>
                            <!--Campo Descripcion Departamento-->
                            <li>
                                <div>
                                    <label for="descDepartamento"><strong>Descripción de departamento</strong></label>
                                    <input name="descDepartamento" id="descDepartamento" type="text" value="<?php
                                    if(isset($_REQUEST['descDepartamento'])){//Compruebo si la variable descDepartamento esta definida y no es null
                                        if($aErrores['descDepartamento'] != null){//Si existe, compruebo que no se encuentra en el array de errores
                                            echo $descDepartamentoEnCurso;//Si no se encuentra en el array de errores imprimo el contenido de la variable de la base de datos
                                        }else{
                                            echo $_REQUEST['descDepartamento'];//Si se encuentra en el array de errores imprimo el contenido de $_REQUEST
                                        }
                                    }else{
                                        echo $descDepartamentoEnCurso;//Si no existe imprimo el contenido de la variable de la base de datos
                                    }
                                    ?>" placeholder="Introduzca la descripción del departamento">
                                    <?php echo ($aErrores['descDepartamento'] != null ? '<span>' . $aErrores['descDepartamento'] . '</span>' : null); ?>
                                </div>
                            </li>
                            <!--Campo Fecha de baja-->
                            <li>
                                <div>
                                    <label for="fechaBaja"><strong>Fecha de Baja</strong></label>
                                    <input name="fechaBaja" id="fechaBaja" type="text" value="<?php echo empty($fechaBajaEnCurso) ? "NULL" : $fechaBajaEnCurso;?>" readonly>
                                </div>
                            </li>
                            <!--Campo Volumen de Negocio-->
                            <li>
                                <div>
                                    <label for="volumenNegocio"><strong>Volumen de negocio</strong></label>
                                    <input name="volumenNegocio" id="volumenNegocio" type="text" value="<?php
                                    if(isset($_REQUEST['volumenNegocio'])){//Compruebo si la variable descDepartamento esta definida y no es null
                                        if($aErrores['volumenNegocio'] != null){//Si existe, compruebo que no se encuentra en el array de errores
                                            echo $volumenNegocioEnCurso;//Si no se encuentra en el array de errores imprimo el contenido de la variable de la base de datos
                                        }else{
                                            echo $_REQUEST['volumenNegocio'];//Si se encuentra en el array de errores imprimo el contenido de $_REQUEST
                                        }
                                    }else{
                                        echo $volumenNegocioEnCurso;//Si no existe imprimo el contenido de la variable de la base de datos
                                    }
                                    ?>" placeholder="Introduzca el volumen de negocio">
                                    <?php echo ($aErrores['volumenNegocio'] != null ? '<span>' . $aErrores['volumenNegocio'] . '</span>' : null); ?>
                                </div>
                            </li>
                            <!--Campo Boton Aceptar y Cancelar-->
                            <li>
                                <input class="botoneditar" id="aceptar" type="submit" name="aceptar" value="Aceptar"/>
                                <input class="botoneditar" id="cancelar" type="submit" name="cancelar" value="Cancelar"/>
                            </li>
                        </ul>
                    </fieldset>
                </form>
            </main>
            <footer class="piepagina">
                <a href="../codigoPHP/mtoDepartamentos.php"><img src="../webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
                <a href="https://github.com/AlbertoFRSauces/207DWESMtoDepartamentosTema4" target="_blank"><img src="../webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
                <p>Ultima actualización: 18/11/2021 12:51</p>
            </footer>
        </body>
</html>


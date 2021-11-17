<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Web Alberto Fernandez Ramirez</title>
        <meta charset ="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">       
        <meta name="author" content="Alberto Fernandez Ramirez">
        <meta name="application-name" content="Proyecto 2021 DAW">
        <meta name="description" content="Mi pagina web DAW">
        <meta name="keywords" content="analítica web, seo, web semántica, seo semántico, analytics" >
        <meta name="robots" content="index, follow">
        <link href="webroot/css/estilo.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../207DWESMtoDepartamentosTema4/webroot/css/img/home.png" type="image/x-icon">
        <style>
            .container{
                position: relative;
                height: auto;
                width: 100%;
            }
            form{
                width: 700px;
                height: auto;
                margin: auto;
            }
            input{
                width: 225px;
                font-size: 105%;
                padding: 12px;
                text-align: center;
                background-color: #252525;
                color: white;
                text-transform: uppercase;
                margin-left: 215px;
                cursor: pointer;
                font-weight: bold;
            }
            input:hover{
                width: 225px;
                font-size: 105%;
                padding: 12px;
                text-align: center;
                background-color: white;
                color: #252525;
                text-transform: uppercase;
                margin-left: 215px;
                cursor: pointer;
                font-weight: bold;
            }
            .entrar{
                margin-top: 50px;
                margin-bottom: 50px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <h1>207DWESMtoDepartamentosTema4</h1>
            </header>
            <article class="segundot">
                <h2>TEMA 4 - MtoDepartamentosTema4</h2>
            </article>
            <form action="../207DWESMtoDepartamentosTema4/codigoPHP/mtoDepartamentos.php">
                <input type="submit" value="MtoDepartamentos" name="mtoDepartamentos" class="entrar"/>
            </form>
            <form action="../proyectoTema4/indexProyectoTema4.php" class="salir">
                <input type="submit" value="SALIR" name="salir" class="salir"/>
            </form>
        
            <footer class="piepagina">
                <a href="../proyectoTema4/indexProyectoTema4.php"><img src="../207DWESMtoDepartamentosTema4/webroot/css/img/atras.png" class="imageatras" alt="IconoAtras" /></a>
                <a href="https://github.com/AlbertoFRSauces/207DWESMtoDepartamentosTema4" target="_blank"><img src="../207DWESMtoDepartamentosTema4/webroot/css/img/github.png" class="imagegithub" alt="IconoGitHub" /></a>
                <p><a>&copy;</a>Alberto Fernández Ramírez 29/09/2021 Todos los derechos reservados.</p>
                <p>Ultima actualización: 16/11/2021 21:00</p>
            </footer>
        </div>
    </body>
</html>

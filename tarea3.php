<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <title>My page title</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Sonsie+One" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="styles.css">

  </head>

  <body>
    <header>
      <h1>Contactos</h1>
    </header>

    <nav>
      <ul>
        <li><a href="#">Home</a></li>
      </ul>
    </nav>

    <main>

      <article>

        <div>
            <h2>Todos los contactos</h2>
            <?php
            crearTablaContactos();
            ?>
        </div>

        <div>
            <h2>Agregar contacto</h2>

            <div class="agregarDiv">
                <?php

                createContactForm();

                ?>
            </div>

        </div>

        <div>
        <h2>Buscar Contacto</h2>
        </div>

        <div>
        <h2>Remover Contacto</h2>
        </div>

       <?php
       
       ?>
       
        </article>

    </main>


    <footer>
      <p>©Copyright 2050 by nobody. All rights reversed.</p>
    </footer>

  </body>
</html>


<?php
init();

function init(){
    if( AgregarContactoSubmit() ){
        $nombreContacto =  $_POST['nombre'];
        $infoContacto = $_POST['nombre'] . ',' . $_POST['trabajo'] . ',' . $_POST["telefono"] . ',' .  $_POST['email'] . ',' . $_POST['direccion'];
        $tam = AgregarInfoContactoArchivo( $infoContacto );
        AgregarContactoIndex( $nombreContacto . ',' . $tam);
    }

}

function AgregarContactoSubmit(){
    return isset($_POST["nombre"]) && isset($_POST["trabajo"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["direccion"]);
    
}

function crearTablaContactos(){

//leer archivo
$dataIndexArray = getIndexArrayFromFile();
if($dataIndexArray != false){

echo "<table class='tablaCantactos'>";
echo "<thead>";
echo "<tr> <td> Nombre </td></tr>";
echo "</thead>";
foreach($dataIndexArray as $item){
    $dataArray = explode(",",$item);
    echo "        <tr>";
    echo "            <td>";
    echo "                <p>" . $dataArray[0] . " </p>";
    echo "            </td>";
    echo "        </tr>";
    }
echo "</table>";
    
}

}
function getIndexArrayFromFile(){
    if(!file_exists("index.txt")){
        return false;
        
    }
    else{
        $indexFile = fopen("index.txt","r");
        if(!$indexFile){
            return false;
        }
        else{
            global $indexArray;
            $indice = 0;
            while(!feof($indexFile)){
                fseek($indexFile,$indice*40);
                $data = fread($indexFile,40);
                $indexArray[$indice] = $data;
                $indice++; 
            }
            return $indexArray;
        }
    }
}

function createContactForm(){

echo "<table>";
echo "    <form id='agregarContacto' method='POST'>";
echo "        <tr>";
echo "            <td>";
echo "                <label> Nombre: </label>";
echo "                <input type='text' id='nombre' name='nombre'>";
echo "            </td>";
echo "        </tr>";

echo "        <tr>";
echo "            <td>";
echo "                <label> Trabajo: </label>";
echo "                <input type='text' id='trabajo' name='trabajo'>";
echo "            </td>";
echo "        </tr>";

echo "        <tr>";
echo "            <td>";
echo "                <label> Telefono: </label>";
echo "                <input type='text'  id='telefono' name='telefono'>";
echo "            </td>";
echo "        </tr>";

echo "        <tr>";
echo "            <td>";
echo "                <label> Email:  </label>";
echo "                <input type='email' id='email' name='email'> ";
echo "            </td>";
echo "        </tr>";

echo "        <tr>";
echo "            <td>";
echo "                <label> Direccion: </label>";
echo "                <input type='address' id='direccion' name='direccion'>";
echo "            </td>";
echo "        </tr>";

echo "        <tr>";
echo "            <td>";
echo "                <button type='submit'> Agregar </button>";
echo "            </td>";
echo "        </tr>";
echo "    </form>";
echo "</table>";

}

function AgregarInfoContactoArchivo($data){
    $posicion;
    $agregado = file_put_contents("contacts.txt",$data,FILE_APPEND | LOCK_EX);
    if ($agregado === false){
        return false;
    }
    else{
        $posicion = filesize("contacts.txt");
        return $posicion;
    }
}

function AgregarContactoIndex($info){
    $info = str_pad($info,40," ");
    $agregado = file_put_contents("index.txt",$info,FILE_APPEND | LOCK_EX);
    if ($agregado === false){
        echo "No se pudo agregar al index";
    }
}

?>
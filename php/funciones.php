<?php


//Funcion que verifica si existeel archivo de conexion de la base de datos
function existencia_de_la_conexion(){
    try {
        //Verificar si existe el archivo de conexion
        if(!file_exists('../php/conexion.php')){
            throw new Exception ('PHP: File  -conexion-  no existe',1);  //NO existe, captura excepcion

        }else{
            require_once('../php/conexion.php');            
            return true;
        }
    
    } catch (Exception $excepcion) {
        //Captura de excepcion y su respectivo codigo
        echo 'Capture: ' .  $excepcion->getMessage(), "<br>";
        echo 'Código: ' . $excepcion->getCode(), "<br>";
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////

function iniciar_sesion($usuario, $clave){
    existencia_de_la_conexion(); 
    require_once("conexion.php");

    $conexion = conectar();                     //Obtenemos la conexion

    //Consulta a la base de datos en la tabla login
    $consulta = mysqli_query($conexion, "SELECT `user`, `key` FROM `usuarios`")
    or die ("Error al iniciar sesión: ");

    $encontrado = false;
    //Tipos de cuentas

    
    while (($fila = mysqli_fetch_array($consulta))!=NULL){

    //Comprobamos la existencia del usuario y contraseña del formulario en los resulatdos de la bases de datos
        if($usuario == $fila['user'] && $clave == $fila['key']){
            //Existe en la base de datos y es conrrecto los datos
            $user = $fila['user'];
            $encontrado = true;
            mysqli_free_result($consulta); //Liberar espacio de consulta cuando ya no es necesario
            mysqli_close($conexion);     //---------------------- Cerrar conexion ------------------
            break;
        }
    }
    if($encontrado==false){
        mysqli_free_result($consulta); //Liberar espacio de consulta cuando ya no es necesario
        //mysqli_close($conexion);     //---------------------- Cerrar conexion ------------------
        //Si no se encontró registro alguno, regresamos al index de inicio de sesión
        ?>
        <script type="text/javascript">
            window.history.back();
        </script>
        <?php
    }
    return $user;
}

?>
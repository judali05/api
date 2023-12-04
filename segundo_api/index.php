<?php
    $host= "localhost";
    $usuario= "root"; 
    $password= "";
    $basededatos= "api08";

    $conexion= new mysqli($host, $usuario, $password, $basededatos );

    if($conexion -> connect_error){
        die("conexion establecida" . $conexion->connect_error);

    }

    header("content_Type: application/json");
    $metodo= $_SERVER['REQUEST_METHOD'];
    print_r($metodo);

    $path= isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';

    $buscarId= explode('/', $path);

    $id= ($path!=='/') ? end($buscarId):null;

    switch($metodo){
        //select usuario

        case'GET':
            // echo" Consulta de registro - GET ";
            consulta($conexion);

            break;

        //insert 
        case'POST':
            //echo" Insertar registro - POST ";
            insertar($conexion);
            break;

        //update
        case'PUT':
            //echo" Edicion de registros - PUT ";
            actualizar($conexion, $id);
            break;

        //delete
        case'DELETE':
            //echo" Borrado de registros - DELETE ";
            borrar($conexion, $id);
            break;

        default:
            echo" Registro no permitido ";
            break;

    }

function consulta($conexion, $id){
    $sql= ($id===null) ? "SELECT  * FROM usuarios" : 
    "SELECT * FROM usuarios WHERE id = $id";
    $resultado= $conexion->query($sql);
    
    if($resultado){
        $datos= array();
        while($fila=$resultado->fetch_assoc()){
            $datos[]=$fila;
        }
        echo json_encode($datos);

    }
}
////////////////////////////////////////////////////////////
function insertar($conexion){
    $dato= json_decode(file_get_contents('php://input'),true);
    $nombre= $dato['nombre'];
    //print_r($nombre);
    
    $sql= "INSERT INTO usuarios(nombre) VALUES ('$nombre')";
    $resultado= $conexion->query($sql);

    if($resultado){
        $datos['id']= $conexion->insert_id;
        echo json_encode($datos);

    }else{
        echo json_encode(array('error'=>'error al crear usuario'));
    }
}
//////////////////////////////////////////////////////////////
function borrar($conexion, $id){
    echo"El id a borrar es: ", $id;

    $sql= "DELETE FROM  usuarios WHERE id= $id ";
    $resultado= $conexion->query($sql);

    if($resultado){
        echo json_encode(array('mensaje'=>'Usuario borrado'));

    }else{
        echo json_encode(array('error'=>'error al borrar usuario'));
    }
}
///////////////////////////////////////////////////////////////
function actualizar($conexion, $id){

    $dato= json_decode(file_get_contents('php://input'),true);
    $nombre= $dato['nombre'];
    echo" El id a editar es: ". $id. "con el dato ". $nombre;

    $sql= "UPDATE usuarios SET nombre = '$nombre' WHERE id = $id";
    $resultado= $conexion->query($sql);

    if($resultado){
        echo json_encode(array('mensaje'=>'Usuario actualizado'));

    }else{
        echo json_encode(array('error'=>'error al actualizar usuario'));
    }
}
?>
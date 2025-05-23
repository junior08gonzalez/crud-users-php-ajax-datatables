<?php

   function subir_imagen(){
    if(isset($_FILES["imagen_usuario"])){
        $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
        $extension = pathinfo($_FILES["imagen_usuario"]['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($extension), $permitidos)){
            return null;
        }
        $nuevo_nombre = uniqid() . '.' . $extension;
        $ubicacion = './img/' . $nuevo_nombre;
        move_uploaded_file($_FILES["imagen_usuario"]['tmp_name'],$ubicacion);
        return $nuevo_nombre;
    }
    return null;
    }


   function obtener_nombre_imagen($id_usuario){
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT imagen FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetch(); // obtener solo una fila
        return $fila ? $fila["imagen"] : null;
    }

     function obtener_todos_registros()
     {
        include('conexion.php');
        $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
?>
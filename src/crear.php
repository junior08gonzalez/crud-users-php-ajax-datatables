<?php
    include("conexion.php");
    include("funciones.php");

    if($_POST["operacion"] == "Crear"){
        $imagen = '';
        if($_FILES["imagen_usuario"]["name"] != ''){
           $imagen = subir_imagen(); 
        }
        $stmt = $conexion->prepare("
        INSERT INTO usuarios(nombre,apellidos,email,telefono,imagen)
         values(:nombre, :apellidos, :email, :telefono, :imagen)");

         $resultado = $stmt->execute(
            array(
                ':nombre' => $_POST["nombre"],
                ':apellidos' => $_POST["apellido"],
                ':email' => $_POST["email"],
                 ':telefono' => $_POST["telefono"],
                ':imagen' => $imagen,
            )
            );

        if(!empty($resultado)){
            echo "Registro Creado";
        }   
    }

     if($_POST["operacion"] == "Editar"){
        $imagen = '';
        if($_FILES["imagen_usuario"]["name"] != ''){
           $imagen = subir_imagen(); 
        }
        else{
            
           $imagen = obtener_nombre_imagen($_POST["id_usuario"]); // Recupera la imagen actual
        }

        $stmt = $conexion->prepare("UPDATE usuarios SET nombre=:nombre, apellidos=:apellidos,
         imagen=:imagen, telefono=:telefono, email=:email WHERE id = :id");

        $resultado = $stmt->execute(
            array(
                ':nombre' => $_POST["nombre"],
                ':apellidos' => $_POST["apellido"],
                 ':telefono' => $_POST["telefono"],
                 ':email' => $_POST["email"],
                ':imagen' => $imagen,
                ':id'   => $_POST["id_usuario"]
            )
        );

        if(!empty($resultado)){
            echo "Registro Actualizado";
        }   
    }
?> 
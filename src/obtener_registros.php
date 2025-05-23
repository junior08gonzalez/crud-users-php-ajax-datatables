<?php

    include("conexion.php");
    include("funciones.php");

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $query = "";
    $salida = array();
    $query = "SELECT * FROM usuarios ";

    if(isset($_POST["search"]["value"])){
        $query .= 'WHERE nombre LIKE "%' . $_POST["search"]["value"] . '%" ';
        $query .= 'OR apellidos LIKE "%' . $_POST["search"]["value"] . '%" ';
    }
    $columnas = array("id", "nombre", "apellidos", "correo", "telefono", "imagen", "fecha_creacion");

    if (isset($_POST["order"])) {
        $columna_orden = $columnas[$_POST['order'][0]['column']];
        $direccion = $_POST['order'][0]['dir'];
        $query .= " ORDER BY $columna_orden $direccion ";
    } else {
        $query .= " ORDER BY id DESC ";
    }

    if($_POST["length"] != -1){
        $query .= 'LIMIT ' . $_POST["start"] . ','. $_POST["length"];
    }

    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $resultado = $stmt->fetchAll();
    $datos = array();
    $filtered_rows = $stmt->rowCount();
    foreach($resultado as $fila){
        $imagen = '';
        if($fila["imagen"] != ''){
            $imagen = '<img src="img/' . $fila["imagen"] . '" class="img-thumbnail"
            width="50" height="50" />';
        }else{
            $imagen = '';
        }

        $sub_array = array();
        $sub_array[] = $fila["id"];
        $sub_array[] = $fila["nombre"];
        $sub_array[] = $fila["apellidos"];
        $sub_array[] = $fila["telefono"];
        $sub_array[] = $fila["email"];
        $sub_array[] = $imagen;
        $sub_array[] = $fila["fecha_creacion"];
        $sub_array[] = '<button type="button" name="editar" id="'.$fila["id"].'" 
        class="btn btn-warning btn-xs editar">Editar</button>';
         $sub_array[] = '<button type="button" name="borrar" id="'.$fila["id"].'" 
        class="btn btn-danger btn-xs borrar">Borrar</button>';
        $datos[] = $sub_array;
    }

    $salida = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" =>obtener_todos_registros(),
        "recordsFiltered" =>$filtered_rows,
        "data" =>$datos
    );
    header('Content-Type: application/json');

    $salida = array(
        "draw" => intval($_POST["draw"]),
        "recordsTotal" => obtener_todos_registros(),
        "recordsFiltered" => $filtered_rows,
        "data" => $datos
    );

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_last_error_msg();
        exit;
    }

    echo json_encode($salida);
?>
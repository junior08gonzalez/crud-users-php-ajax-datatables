<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" 
    href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link rel="stylesheet"
     href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
  <body>
    <div class="container fondo">
        <h1 class="text-center">CRUD con PHP, PDO, Ajax y DataTables.js</h1>
        <div class="row">
            <div class="col-2 offset-10">
                <div class="text-center">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary w-100" 
                    data-bs-toggle="modal" data-bs-target="#modalUsuario" id="botonCrear">
                    <i class="bi bi-plus-circle-fill"></i> Crear
                    </button>
                </div>
            </div>
        </div>
        <br><br>

        <div class="table-responsive">
            <table id="datos_usuario" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Imagen</th>
                        <th>Fecha de Creacion</th>
                        <th>Editar</th>
                        <th>Borrar</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

   <!-- Modal -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Formulario</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <form method="POST" id="formulario" enctype="multipart/form-data">
            <div class="modal-contect">
                <div class="modal-body">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control">
                    <br>
                    
                    <label for="apellido">Apellidos</label>
                    <input type="text" name="apellido" id="apellido" class="form-control">
                    <br>

                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control">
                    <br>

                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="form-control">
                    <br>

                    <label for="imagen_usuario">Seleccione una Imagen</label>
                    <input type="file" name="imagen_usuario" id="imagen_usuario" class="form-control">
                    <span id="imagen_subida"></span>
                    <br>
                </div>
                <!--footer-->
                <div class="modal-footer">
                    <input type="hidden" name="id_usuario" id="id_usuario">
                    <input type="hidden" name="operacion" id="operacion">
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Crear">
                </div>
            </div>
        </form>
      </div>
  </div>
</div>

    <!-- jQuery Minified -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!--DATATABLES JS-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script> -->
    <!-- <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).ready(()=>{
            $("#botonCrear").click(()=>{
                $("#formulario")[0].reset();
                $(".modal-title").text("Crear Usuario");
                $("#action").val("Crear");
                $("#operacion").val("Crear");
                $("#imagen_subida").html("");
            });
            var dataTable = $('#datos_usuario').DataTable({
                "processing":true,
                "serverSide":true,
                "responsive":true,  
                "order":[],
                "ajax":{
                    url:"obtener_registros.php",
                    type:"POST"
                },
                "columnsDefs":[
                    {
                    "targets":[0, 3, 4],
                    "orderable":false
                    }
                ],
                "language":{
                 "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar ascendente",
                    "sortDescending": ": activar para ordenar descendente"
                }
                }
            });

            //logica Crear
            $(document).on('submit', '#formulario', function(event){
                        event.preventDefault();
                        var nombres = $("#nombre").val();
                        var apellido = $("#apellido").val();
                        var telefono = $("#telefono").val();
                        var email = $("#email").val();
                        var extension = $("#imagen_usuario").val().split('.').pop().toLowerCase();
                        
                        if(extension != ''){
                            if(jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) == 1){
                                alert("Formato de imagen invalido");
                                $("#imagen_usuario").val('');
                                return false;
                            }
                        }

                        if(nombres!= null && apellido != '' && email != null){
                            $.ajax({
                            url:"crear.php",
                            method:"POST",
                            data: new FormData(this),
                            contentType:false,
                            processData:false,
                            success:function(data)
                            {
                                alert(data);
                                $('#formulario')[0].reset();
                                $('#modalUsuario').modal('hide');
                                dataTable.ajax.reload();
                            } 
                            });
                        }
                        else{
                            alert("Algunos campos son obligatorios");
                        }
             });

             //Logica Editar
             $(document).on('click', '.editar', function(){
                var id_usuario = $(this).attr("id");
                $.ajax({
                    url: "obtener_registro.php",
                    method:"POST",
                    data:{id_usuario:id_usuario},
                    dataType:"json",
                    success:function(data)
                    {
                       $('#modalUsuario').modal('show');
                       $('#nombre').val(data.nombre);
                       $('#apellido').val(data.apellidos); 
                       $('#telefono').val(data.telefono);
                       $('#email').val(data.email);
                       $('.modal-title').text("Editar Usuario");
                       $('#id_usuario').val(id_usuario);
                       $('#imagen_subida').html(data.imagen_usuario);
                       $('#action').val("Editar");
                       $("#operacion").val("Editar");
                    },
                        error: function(jqXHR, textStatus, errorThrown){
                        console.log(textStatus, errorThrown);
                    }
                });
             });

             //Logica Borrar
             $(document).on('click', '.borrar', function(){
                var id_usuario = $(this).attr("id");
                if(confirm("Esta seguro de borrar este registro:"+id_usuario)){
                    $.ajax({
                        url: "borrar.php",
                        method:"POST",
                        data:{id_usuario:id_usuario},
                        success:function(data)
                        {
                            alert(data);
                            dataTable.ajax.reload();
                        }
                    });
                }
                else{
                    return false;
                }
             });
        });       
    </script>
</body>
</html>
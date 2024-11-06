<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Universidad</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        
        <div class="mt-4, mb-4">
            
            <a href="http://localhost/semilleroNex/MVC/controllers/CarrerasController.php" class="btn btn-secondary">Gestión de Carreras</a>
        </div>
    


        <h2>Lista de Usuarios</h2>

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="search-input"
                    placeholder="Buscar usuario por nombre o cédula">
            </div>
            <div class="col-md-4">
                <select class="form-select" id="role-filter">
                    <option value="">Filtrar por rol</option>
                    <option value="1">Administrador</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-secondary" id="clear-filters">Limpiar Filtros</button>
            </div>
        </div>

        <a href="./UsersController.php?create=true"> 
            <button class="btn btn-success">
                Crear usuario
            </button>
        </a>

        <?php if(isset($_GET['message'])):?>
        <div class="alert alert-success mt-4" role="alert">
            <?php echo($_GET['message']) ?>
        </div>
        <?php endif?>
        <!-- Tabla  -->
        <table class="table table-bordered my-3">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Cédula</th>
                    <th>Rol</th>
                    <th>Celular</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="user-table-body">
                <!-- Los usuarios se generarán dinámicamente aquí -->

                <?php foreach($results->registers as $user): ?>
                <tr>
                    <td><?php echo($user->nombre_completo) ?></td>
                    <td><?php echo($user->cedula) ?></td>
                    <td>
                    <?php foreach($roles as $role): ?>
                        <?php if($user->role_id === $role->id): ?>
                            <?php 
                                echo($role->nombre); 
                                break;
                                ?>
                        <?php endif ?>
                    <?php endforeach ?>
                    </td>
                    <td> <?php echo($user->celular) ?></td>
                    <td>
                        <a href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?_method%20=PUT&userId=<?php echo($user->id)?>" class="btn btn-warning btn-sm edit-user" data-id="1">Editar</a>
                        <a href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?_method%20=PUT&deleteId=<?php echo($user->id)?>" class="btn btn-danger btn-sm delete-user">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>



        <!-- Paginación -->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?page=<?php echo(($results->currentPage - 1 == 0) ? 1 : $results->currentPage -1)?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php $count = 0 ?>
                <li class="page-item"><a class="page-link" href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?page=<?php echo($results->currentPage)?>"><?php echo($results->currentPage)?></a></li>
                <?php for ($i=$results->currentPage; $i <= $results->totalPages; $i++): ?> 
                    <?php 
                        if ($i == $results->currentPage) {
                            continue;
                        }
                        if($count == 1){
                            break;
                        }
                    ?>
                    <li class="page-item"><a class="page-link" href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?page=<?php echo($i)?>"><?php echo($i)?></a></li>
                    <?php $count++ ?>
                <?php endfor ?>
                <li class="page-item">
                    <a class="page-link" href="http://localhost/semilleroNex/MVC/controllers/UsersController.php?page=<?php echo(($results->currentPage + 1 < $results->totalPages) ?  $results->currentPage + 1 : $results->totalPages)?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
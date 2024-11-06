<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Carreras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Lista de Carreras</h2>

        <a href="./CarrerasController.php?create=true">
            <button class="btn btn-success mb-3">Agregar Nueva Carrera</button>
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
                    <th>Nombre de la Carrera</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <!-- Las carreras se generan dinámicamente aquí  -->
            <tbody>
                <?php if ($carreras): ?>
                    <?php foreach ($carreras as $carrera): ?>
                        <tr>
                            <td><?php echo $carrera->nombre; ?></td>
                            <td>
                                <a href="./CarrerasController.php?edit=<?php echo $carrera->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="./CarrerasController.php?_method%20=PUT&delete=<?php echo $carrera->id; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                                <a href="./CarrerasController.php?carreraId=<?php echo $carrera->id; ?>" class="btn btn-info btn-sm">Ver Usuarios</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No hay carreras registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-4, mb-4">
            
            <a href="http://localhost/semilleroNex/MVC/controllers/UsersController.php" class="btn btn-secondary">Lista de Usuarios</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($carreraData) ? 'Editar' : 'Crear'; ?> Carrera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container mt-5">
        <h1 class="mb-4 text-center"><?php echo isset($carreraData) ? 'Editar' : 'Crear'; ?> Carrera</h1>
        <form action="../controllers/CarrerasController.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre de la Carrera</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo isset($carreraData) ? $carreraData->nombre : ''; ?>" required>
                <?php if (isset($carreraData)): ?>
                    <input type="hidden" name="id" value="<?php echo $carreraData->id; ?>">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary mb-3"><?php echo isset($carreraData) ? 'Actualizar' : 'Guardar'; ?></button>
        </form>
        
        <div class="mt-10, mb-3">
            <a href="http://localhost/Proyecto-Semillero_Nex/controllers/CarrerasController.php" class="btn btn-secondary">Gestión de Carreras</a>
        </div>

    </div>

    
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb8Ffz+LvEzFZiFzI1D/VM5iK1LUs1gq3x+Z5w4E79N1Z+ugA" crossorigin="anonymous"></script>
    
</body>
</html>

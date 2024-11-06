<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios por Carrera</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Usuarios en la Carrera</h2>

        <table class="table table-bordered my-3">
            <thead>
                <tr>
                    <th>Nombre Completo</th>
                    <th>Cédula</th>
                    <th>Celular</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($usuarios): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo $usuario->nombre_completo; ?></td>
                            <td><?php echo $usuario->cedula; ?></td>
                            <td><?php echo $usuario->celular; ?></td>
                            <td><?php echo isset($usuario->rol_id) ? $usuario->rol_id : 'No definido'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No hay usuarios registrados en esta carrera.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
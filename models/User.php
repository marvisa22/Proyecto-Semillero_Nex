<?php

namespace Models;

use Traits\Connection;
use PDOException;

class User {

    private $id;
    private $completeName;
    private $identityDocument;
    private $role;
    private $celNumber;
    private $password;

    use Connection;

    protected function __construct($name, $identityDocument, $role, $number, $password = null, $id = null) {
        $this->completeName = $name;
        $this->identityDocument = $identityDocument;
        $this->role = $role;
        $this->celNumber = $number;
        $this->password = $password;
        $this->id = $id;
    }

    protected function storeUser() {
        $this->openConnection();

        try {
            $query = "INSERT INTO usuarios (nombre_completo, cedula, role_id, celular, clave) VALUES (:name, :document, :role, :cel, :password)";
            $statement = $this->conn->prepare($query);
            $statement->execute(
                    [
                        ':name' => $this->completeName,
                        ':document' => $this->identityDocument,
                        ':role' => $this->role,
                        ':cel' => $this->celNumber,
                        ':password' => password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]),
                    ]
                );
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=Usuario registrado con éxito&success=1');
        } catch(PDOException $ex) {
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=' . $ex->getMessage() . '&success=0');
        } finally {
            $this->closeConnection();
        }
    }

    protected function updateUser() {
        $this->openConnection();

        try {
            $query = "UPDATE usuarios SET nombre_completo = :name, cedula = :document, role_id = :role, celular = :cel, clave = :password WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute(
                    [
                        ':name' => $this->completeName,
                        ':document' => $this->identityDocument,
                        ':role' => $this->role,
                        ':cel' => $this->celNumber,
                        ':password' => password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 12]),
                        ':id' => $this->id,
                    ]
                );
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=Usuario actualizado con éxito&success=1');
        } catch(PDOException $ex) {
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=' . $ex->getMessage() . '&success=0');
        } finally {
            $this->closeConnection();
        }
    }

    protected function delete($id){
        $this->openConnection();

        try {
            $query = "DELETE FROM usuarios WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute(
                    [
                        ':id' => $id,
                    ]
                );
                
                if ($statement->rowCount()) {
                    header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=Usuario eliminado con éxito&success=1');
                    return;
                }
                header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=Usuario no encontrado&success=1');
        } catch(PDOException $ex) {
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/usersController.php?message=' . $ex->getMessage() . '&success=0');
        } finally {
            $this->closeConnection();
        }
    }

    protected function getOne($id) {
        $this->openConnection();

        try {
            $query = "SELECT id, nombre_completo, cedula, role_id, celular FROM usuarios WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute(['id' => $id]);

            if ($statement->rowCount()) {
                return (object) [
                    'status' => 200,
                    'success' => true,
                    'user' => $statement->fetch(),
                ];
            }
            return (object) [
                'status' => 200,
                'success' => false,
            ];
        } catch(PDOException $ex) {
            return (object) [
                'status' => 400,
                'error' => $ex->getMessage(),
            ];
        } finally {
            $this->closeConnection();
        }
    }

    protected function getPaginated($page = 1, $filters = []){
        $resultsPerPage = 1;

        $query = "SELECT id, nombre_completo, cedula, role_id, celular FROM usuarios";
        $queryCount = "SELECT COUNT(id) AS total_users FROM usuarios";

        $initialRegister = ($page - 1) * $resultsPerPage;
        $filterValues = [];

        $filtersCount = count($filters);

        if ($filtersCount) {
            $query .= ' WHERE';

            foreach($filters as $key => $filter) {
                switch($filter['value']) {
                    case 'searcher':
                        $text = ' nombre_completo LIKE %:search% OR cedula LIKE %:search%';
                        $query .= $text;
                        $queryCount .= $text;
                        $filterValues[':searcher'] = $filter['value'];
                        break;

                    case 'role':
                        $text = ' role_id = :role';
                        $query .= $text;
                        $queryCount .= $text;
                        $filterValues[':role'] = $filter['value'];
                        break;
                }

                if ($key < $filtersCount - 1) {
                    $query .= ' AND';
                    $queryCount .= ' AND';
                }
            }
        }

        $query .= " ORDER BY id ASC LIMIT $initialRegister, $resultsPerPage";

        try {
            $this->openConnection();

            $statement = $this->conn->prepare($query);
            $statement->execute($filterValues);

            $paginatedUsers = $statement->fetchAll();
            $statement->closeCursor();

            $statement = $this->conn->prepare($queryCount);
            $statement->execute($filterValues);

            $totalUsers = $statement->fetch()->total_users;

            return (object) [
                'status' => 200,
                'registers' => $paginatedUsers,
                'totalPages' => ceil($totalUsers / $resultsPerPage),
                'resultsPerpage' => $resultsPerPage,
                'currentPage' => $page,
            ];
        } catch (PDOException $ex){
            return (object) [
                'status' => 400,
                'error' => $ex->getMessage(),
            ];
        } finally {
            $this->closeConnection();
        }
    }

}
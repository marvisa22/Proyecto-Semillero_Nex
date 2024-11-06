<?php

namespace Models;

use Traits\Connection;
use PDOException;

class Carrera {
    private $id;
    private $nombre;

    use Connection;

    public function __construct($nombre = null, $id = null) {
        $this->nombre = $nombre;
        $this->id = $id;
    }

    public function getAll() {
        $this->openConnection();
        try {
            $query = "SELECT * FROM carrera";
            $statement = $this->conn->query($query);
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            $this->closeConnection();
        }
    }

    public function getById($id) {
        $this->openConnection();
        try {
            $query = "SELECT * FROM carrera WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute([':id' => $id]);
            return $statement->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            $this->closeConnection();
        }
    }

    public function create() {
        $this->openConnection();
        try {
            $query = "INSERT INTO carrera (nombre) VALUES (:nombre)";
            $statement = $this->conn->prepare($query);
            $statement->execute([':nombre' => $this->nombre]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            $this->closeConnection();
        }
    }

    public function update() {
        $this->openConnection();
        try {
            $query = "UPDATE carrera SET nombre = :nombre WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute([':nombre' => $this->nombre, ':id' => $this->id]);
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            $this->closeConnection();
        }
    }

    public function delete($id) {
        $this->openConnection();
        try {
            $query = "DELETE FROM carrera WHERE id = :id";
            $statement = $this->conn->prepare($query);
            $statement->execute(
                [':id' => $id]
            );

            if ($statement->rowCount()) {
                header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/carrerasController.php?message=Carrera eliminado con éxito&success=1');
                return;
                
            }
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/carrerasController.php?message=Carrera no encontrado&success=1');
        } catch (PDOException $e) {
            header('Location: http://localhost/Proyecto-Semillero_Nex/controllers/carrerasController.php?message='. $e->getMessage());
        } finally {
            $this->closeConnection();
        }
    }

    public function getUsersByCareer($carreraId, $page = 1, $perPage = 10) {
        $this->openConnection();
        try {
            $offset = ($page - 1) * $perPage;
            $query = "
                SELECT u.* 
                FROM usuarios u 
                JOIN estudiantes e ON u.id = e.usuario_id
                WHERE e.carrera_id = :carreraId 
                LIMIT :offset, :perPage";
            $statement = $this->conn->prepare($query);
            $statement->bindValue(':carreraId', $carreraId, \PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $statement->bindValue(':perPage', $perPage, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
        } finally {
            $this->closeConnection();
        }
    }
    
}

<?php

require_once('../autoload.php');
use Models\Carrera;

class CarrerasController {
    public function index() {
        $carrera = new Carrera();
        $carreras = $carrera->getAll();
        require_once('../views/CarreraManager.php');
    }

    public function create() {
        require_once('../views/CarreraForm.php');
    }

    public function store($request) {
        $carrera = new Carrera($request['nombre']);
        $carrera->create();
        header('Location: ./CarrerasController.php');
    }

    public function edit($id) {
        $carrera = new Carrera();
        $carreraData = $carrera->getById($id);
        require_once('../views/CarreraForm.php');
    }

    public function update($request) {
        $carrera = new Carrera($request['nombre'], $request['id']);
        $carrera->update();
        header('Location: ./CarrerasController.php');
    }

    public function delete($id) {
        $carrera = new Carrera();
        $carrera->delete($id);
        header('Location: ./CarrerasController.php');
    }

    public function viewUsersByCareer($carreraId, $page = 1) {
        $carrera = new Carrera();
        $usuarios = $carrera->getUsersByCareer($carreraId, $page);
        require_once('../views/UsuariosPorCarrera.php');
    }
}

// Manejo de rutas
$controller = new CarrerasController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['create'])) {
        $controller->create();
    } elseif (isset($_GET['edit'])) {
        $controller->edit($_GET['edit']);
    } elseif (isset($_GET['delete'])) {
        $controller->delete($_GET['delete']);
    } elseif (isset($_GET['carreraId'])) {
        $controller->viewUsersByCareer($_GET['carreraId']);
    } else {
        $controller->index();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $controller->update($_POST);
    } else {
        $controller->store($_POST);
    }
}

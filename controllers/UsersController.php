<?php

require_once('../autoload.php');

use Services\RoleService;
use Models\User;

class UserController extends User
{

    public function __construct() {
         
    }

    public function index()
    {

        $roleService = new RoleService();

        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $roles = $roleService->getRoles();
        $results = $this->getPaginated($page);

        require_once('../index.php');
    }

    public function create()
    {
        $roleService = new RoleService();
        $roles = $roleService->getRoles();

        $title = 'Crear usuario';

        require_once('../views/UserManager.php');
    }

    public function getUser($id)
    {

        return $this->getOne($id);
    }

    public function update($request)
    {

        $name = $request['fullName'];
        $document = $request['documentNumber'];
        $role = $request['role'];
        $cellphone = $request['phone'];
        $password = $request['password'];
        $id = $request['userId'];

        parent::__construct($name, $document, $role, $cellphone, $password, $id);
        $this->updateUser();
    }

    public function deleteUser($request){
        $this->delete($request['deleteId']);
    }

    public function store($request)
    {
        $name = $request['fullName'];
        $document = $request['documentNumber'];
        $role = $request['role'];
        $cellphone = $request['phone'];
        $password = $request['password'];

        parent::__construct($name, $document, $role, $cellphone, $password);
        $this->storeUser();
    }
}

$controllerInstance = new UserController();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['userId'])) {

        $result = $controllerInstance->getUser($_GET['userId']);

        if ($result->status === 200) {

            $roleService = new RoleService();
            $roles = $roleService->getRoles();

            $userData = $result->user;
            $title = 'Editar usuario';

            require_once('../views/userManager.php');
            
        }
    } else if (isset($_GET['create'])) {

        $controllerInstance->create();

    } else if(isset($_GET['deleteId'])){

        $controllerInstance->deleteUser($_GET);
    
    } else {

        $controllerInstance->index();
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['userId'])) {

        $controllerInstance->update($_POST);

        return;
    }

    $controllerInstance->store($_POST);
} 

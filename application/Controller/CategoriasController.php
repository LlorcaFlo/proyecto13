<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Categoria;
use Mini\Core\View;
use Mini\Core\Session;

class CategoriasController extends Controller
{
    public $titulo = 'Categoria';

    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Categorias';
    }

    public function index()
    {
        // Carga vistas
        $this->view->addData(['titulo' => 'Categorias']);
        echo $this->view->render('categorias/index', ['titulo' => 'Categorias']);
    }

    public function todos()
    {
        $categoria = new Categoria();

        $categorias = $categoria->getAllASC();

        echo $this->view->render('categorias/listar', ['categorias' => $categorias, 'nombre' => $this->titulo]);
    }

    public function rellenaSelect()
    {
        $categoria = new Categoria();

        $categorias = $categoria->getAllASC();

        echo $this->view->render('categorias/todasselect', ['categorias' => $categorias, 'nombre' => $this->titulo]);
    }

    public function visita($id)
    {

        $categoria = new Categoria();

        $categorias = $categoria->getId($id);

        echo $this->view->render('categorias/ver', ['categorias' => $categorias, 'nombre' => $this->titulo]);

    }


}
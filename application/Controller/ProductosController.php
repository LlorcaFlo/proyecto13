<?php

namespace Mini\Controller;

use Mini\Core\Controller;
use Mini\Model\Producto;
use Mini\Core\View;
use Mini\Core\Session;
use Mini\Model\Validate;
use Mini\Model\Categoria;
use mysql_xdevapi\BaseResult;

class ProductosController extends Controller
{
    public $titulo;

    public function __construct()
    {
        parent::__construct();
        $this->titulo = 'Productos';
    }

    public function index()
    {
        // Carga vistas
        $this->view->addData(['titulo' => 'Productos']);
        echo $this->view->render('productos/index', ['titulo' => 'Productos']);
    }

    public function ver()
    {
        $producto = new Productos();

        $productos = $producto->getAllASC();

        echo $this->view->render('productos/ver', ['productos' => $productos, 'nombre' => $this->titulo]);
    }

//<---------------------- MÉTODO LISTAR TODOS LOS PRODUCTOS --------------------->
    public function todos()
    {
        $this->view->addData(['titulo' => 'Productos']);

        $producto = new Producto();
        $productos = $producto->getAllInnerJoin();
        echo $this->view->render('productos/listar', ['productos' => $productos, 'nombre' => $this->titulo]);
    }

//<---------------------- MÉTODO LISTAR POR CATEGORIAS --------------------->
    public function getCat($variable)
    {
        $categoria = new Categoria();
        $categorias = $categoria->getName($variable);

        foreach ($categorias as $key) ;
        $cat = $key->id;

        $producto = new Producto();
        $productos = $producto->getAllCategoria($cat);
        $random = $producto->getRandomCat($cat);
        $marcas = $producto->getMarcas($cat);

        echo $this->view->render('productos/listarpublico', ['productos' => $productos, 'titulo' => $variable, 'random' => $random, 'marcas' => $marcas]);
    }

    //<---------------------- MÉTODO LISTAR POR NOMBRE --------------------->
    public function buscador()
    {
        $pro = new Producto();
        $categoria = new Categoria();

        if ($_POST['select'] == 'Nombre') {
            $productos = $pro->getAllNombre($_POST['buscador']);

            echo $this->view->render('productos/listarbuscador', ['productos' => $productos, 'titulo' => $_POST['buscador'], 'busca' => $_POST['select']]);

        } elseif ($_POST['select'] == 'Marca') {
            $productos = $pro->getAllMarca($_POST['buscador']);
            echo $this->view->render('productos/listarbuscador', ['productos' => $productos, 'titulo' => $_POST['buscador'], 'busca' => $_POST['select']]);

        } elseif ($_POST['select'] == 'Categoria') {

            $productos = $pro->getAllCategoria2($_POST['buscador']);
            echo $this->view->render('productos/listarbuscador', ['productos' => $productos, 'titulo' => $_POST['buscador']]);


        }
        var_dump($productos);

    }

    //<---------------------- MÉTODO LISTAR ALEATORIO POR CATEGORIAS --------------------->
//
//    public function getCatRandom($variable)
//    {
//        $categoria = new Categoria();
//        $categorias = $categoria->getName($variable);
//
//        foreach ($categorias as $key) ;
//        $cat = $key->id;
//
//        $producto = new Producto();
//
//
//        echo $this->view->render('productos/listarpublico', ['random' => $random, 'titulo' => $variable]);
//    }

//<---------------------- MÉTODO INSERTAR PRODUCTOS --------------------->
    public function inserta()
    {
        $this->view->addData(['titulo' => 'Productos']);

        $datos = [];
        $val = new Validate();
        $prod = new Producto();
        $cat = new Categoria();

        try {
            $categoria = $cat->getAllASC();
        } catch (PDOException $e) {
            echo('Conexion erronea:' . $e->getMessage() . ' // ' . $e->getLine());
        }

        if (isset($_POST['addproductos'])) {

            //<--------NOMBRE DEL PRODUCTO
            if (!$val->vacio($_POST['nombre'])) {
                $val->errors['nombre'] = 'No hemos recibido el nombre.';
            } elseif (!$val->va_nameProd($_POST['nombre'])) {
                $val->errors['nombre'] = 'El nombre introducido no es válido.';
                $datos['nombre'] = $_POST['nombre'];
            } else {
                $datos['nombre'] = $_POST['nombre'];
            }
            //<--------MODELO DEL PRODUCTO
            if (!$val->vacio($_POST['modelo'])) {
                $val->errors['modelo'] = 'No hemos recibido el modelo del producto.';
            } elseif (!$val->va_nameProd($_POST['modelo'])) {
                $val->errors['modelo'] = 'El modelo introducida no es válido.';
                $datos['modelo'] = $_POST['modelo'];
            } else {
                $datos['modelo'] = $_POST['modelo'];
            }
            //<--------MARCA DEL PRODUCTO
            if (!$val->vacio($_POST['marca'])) {
                $val->errors['marca'] = 'No hemos recibido la marca del producto.';
            } elseif (!$val->va_nameProd($_POST['marca'])) {
                $val->errors['marca'] = 'La marca introducida no es válida.';
                $datos['marca'] = $_POST['marca'];
            } else {
                $datos['marca'] = $_POST['marca'];
            }

            //<--------CATEGORIA DEL PRODUCTO
            $cate = $cat->getName($_POST['categoria']);
            foreach ($cate as $cat) {
                $datos['categoria'] = $cat->id;
            }

            //<--------DESCRIPCIÓN DEL PRODUCTO
            if (!$val->vacio($_POST['descripcion'])) {
                $val->errors['descripcion'] = 'No hemos recibido una descripción.';
            } else {
                $datos['descripcion'] = $_POST['descripcion'];
            }
            //<--------PRECIO DEL PRODUCTO
            if (!$val->vacio($_POST['precio'])) {
                $val->errors['precio'] = 'No hemos recibido precio del producto.';
            } else {
                $datos['precio'] = $_POST['precio'];
            }
            //<-------INSERTAR IMAGEN---->
            if ($_FILES['imagen']['size'] >= 200000) {
                $val->errors['marca'] = 'La imagen es demasiado grande.<br>';
            }
            if ($_FILES['imagen']['name']) {
                //Criptar el nombre de la imagen...me falta

                if (($_FILES['imagen']['type'] == "image/gif") || ($_FILES['imagen']['type'] == "image/jpeg") || ($_FILES['imagen']['type'] == "image/jpg") || ($_FILES['imagen']['type'] == "image/png")) {
                    // Ruta donde se guardarán las imágenes que subamos
                    $directorio = $_SERVER['DOCUMENT_ROOT'] . '/img/productos/';

                    // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name']);
                } else {
                    $val->errors ['marca'] = 'No se puede subir una imagen con ese formato.';
                }
            }
            try {
                $comprueba = $prod->getNameModeloProd($datos['nombre'], $datos['modelo'], $datos['categoria']);
                if (!$comprueba) {
                    $val->errors['nombre'] = 'El producto ya existe en esta categoria con ese nombre y ese modelo.';
                }
            } catch (PDOException $e) {
                echo('Conexion erronea:' . $e->getMessage() . ' // Linea-> ' . $e->getLine());
            }

            if ($val->errors) {
                echo $this->view->render('productos/insert_form',
                    ['errors' => $val->errors, 'datos' => $datos, 'categorias' => $categoria]);

            } else {

                if (!$_FILES['imagen']['name']) {
                    $datos_insertar = [
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'marca' => $datos['marca'],
                        'modelo' => $datos['modelo'],
                        'precio' => $datos['precio'],
                        'categoria' => $datos['categoria'],
                        'id_usuario' => Session::get('Id')
                    ];
                } else {
                    $datos_insertar = [
                        'nombre' => $datos['nombre'],
                        'descripcion' => $datos['descripcion'],
                        'marca' => $datos['marca'],
                        'modelo' => $datos['modelo'],
                        'precio' => $datos['precio'],
                        'categoria' => $datos['categoria'],
                        'id_usuario' => Session::get('Id'),
                        'imagenes' => $_FILES['imagen']['name']];
                }
                $prod = new Producto();
                try {
                    $ok = $prod->insert($datos_insertar);
                } catch (PDOException $e) {
                    echo 'Conexion erronea:' . $e->getMessage() . ' // Linea-> ' . $e->getLine();
                }
                if (!$ok) {
                    $val->errors['nombre'] = 'No ha sido posible el registro del producto.';
                    echo $this->view->render('productos/insert_form',
                        ['errors' => $val->errors, 'datos' => $datos, 'categorias' => $categoria]);
                } else {
                    // header('location: /productos/listar');
                    echo $this->view->render('productos/insert_form', ['mensaje' => 'Producto Registrado', 'categorias' => $categoria]);
                }
            }
        } else {
            echo $this->view->render('productos/insert_form',
                ['errors' => $val->errors, 'datos' => $datos, 'categorias' => $categoria]);
        }
    }

//<---------------------- MÉTODO EDITAR PRODUCTOS LOS PRODUCTOS --------------------->

    public function editar($data)
    {
        $this->view->addData(['titulo' => 'Edita Productos']);

        $datos = [];
        $val = new Validate();
        $cat = new Categoria();
        $pro = new Producto();

        //Requerimos todos los campos necesarios del producto
        //para enviarlos al formulario en cada campo
        try {
            $producto = $pro->getId($data);
        } catch (PDOException $e) {
            echo('Conexion erronea:' . $e->getMessage() . ' // ' . $e->getLine());
        }

        foreach ($producto as $prod) {
            $datos['Id'] = $prod->id;
            $datos['nombre'] = $prod->nombre;
            $datos['descripcion'] = $prod->descripcion;
            $datos['marca'] = $prod->marca;
            $datos['modelo'] = $prod->modelo;
            $datos['precio'] = $prod->precio;
            $datos['id_categoria'] = $prod->categoria;
            $datos['imagen'] = $prod->imagenes;
        }

        try {
            $NombreCat = $cat->getId($datos['id_categoria']);
        } catch (PDOException $e) {
            echo('Conexion erronea:' . $e->getMessage() . ' // ' . $e->getLine());
        }

        //Recogemos el nombre de categoria
        foreach ($NombreCat as $Nom) {
            $NombreCat = $Nom->nombre;
        }
        $datos['categoria'] = $NombreCat;


        try {
            $categoria = $cat->getAllASC();
        } catch (PDOException $e) {
            echo('Conexion erronea:' . $e->getMessage() . ' // ' . $e->getLine());
        }

        //AL PULSAR BOTÓN EDITAR
        if (isset($_POST['edita_prod'])) {

            //<--------NOMBRE DEL PRODUCTO
            if (!$val->vacio($_POST['nombre'])) {
                $val->errors['nombre'] = 'No hemos recibido el nombre.';
            } elseif (!$val->va_nameProd($_POST['nombre'])) {
                $val->errors['nombre'] = 'El nombre introducido no es válido.';
                $datos['nombre'] = $_POST['nombre'];
            } else {
                $datos['nombre'] = $_POST['nombre'];
            }

            //<--------MODELO DEL PRODUCTO
            if (!$val->vacio($_POST['modelo'])) {
                $val->errors['modelo'] = 'No hemos recibido el modelo del producto.';
            } elseif (!$val->va_nameProd($_POST['marca'])) {
                $val->errors['modelo'] = 'El modelo introducido no es válido.';
                $datos['modelo'] = $_POST['modelo'];
            } else {
                $datos['modelo'] = $_POST['modelo'];
            }

            //<--------MARCA DEL PRODUCTO
            if (!$val->vacio($_POST['marca'])) {
                $val->errors['marca'] = 'No hemos recibido la marca del producto.';
            } elseif (!$val->va_nameProd($_POST['marca'])) {
                $val->errors['marca'] = 'La marca introducida no es válida.';
                $datos['marca'] = $_POST['marca'];
            } else {
                $datos['marca'] = $_POST['marca'];
            }

            //<--------CATEGORIA DEL PRODUCTO
            //RECOGEMOS EL ID DE LA CATEGORIA
            $cate = $cat->getName($_POST['categoria']);
            foreach ($cate as $cat) {
                $datos['categoria'] = $cat->id;
            }

            //<--------DESCRIPCIÓN DEL PRODUCTO
            if (!$val->vacio($_POST['descripcion'])) {
                $val->errors['descripcion'] = 'No hemos recibido una descripción.';
            } else {
                $datos['descripcion'] = $_POST['descripcion'];
            }

            //<--------PRECIO DEL PRODUCTO
            if (!$val->vacio($_POST['precio'])) {
                $val->errors['precio'] = 'No hemos recibido precio del producto.';
            } else {
                $datos['precio'] = $_POST['precio'];
            }

            //<-------INSERTAR IMAGEN---->
            if ($_FILES['imagen']['size'] >= 200000) {
                $val->errors['marca'] = 'La imagen es demasiado grande.<br>';
            }
            if ($_FILES['imagen']['name']) {
                //Criptar el nombre de la imagen...me falta

                if (($_FILES['imagen']['type'] == "image/gif") || ($_FILES['imagen']['type'] == "image/jpeg") || ($_FILES['imagen']['type'] == "image/jpg") || ($_FILES['imagen']['type'] == "image/png")) {
                    // Ruta donde se guardarán las imágenes que subamos
                    $directorio = $_SERVER['DOCUMENT_ROOT'] . '/img/productos/';
                    // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio . $_FILES['imagen']['name']);
                } else {
                    $val->errors ['marca'] = 'No se puede subir una imagen con ese formato.';
                }

            }
            try {
                $comprueba = $pro->getNameModeloProd($datos['nombre'], $datos['modelo'], $datos['categoria']);
                if (!$comprueba) {
                    if (!$pro->nombreId($datos['Id'], $datos['nombre'])) {
                        $val->errors['nombre'] = 'El producto ya existe en esta categoria con ese nombre y ese modelo.';
                    }

                }
            } catch (PDOException $e) {
                echo('Conexion erronea:' . $e->getMessage() . ' // Linea-> ' . $e->getLine());
            }

            $datos['imagen'] = $_FILES['imagen']['name'];

            if ($val->errors) {
                $datos['categoria'] = $NombreCat;
                echo $this->view->render('productos/edita_form',
                    ['errors' => $val->errors, 'datos' => $datos, 'categorias' => $categoria]);
            } else {

                if (!$_FILES['imagen']['name']) {

                    $datos_producto = [
                        'nombre' => $datos['nombre'],
                        'marca' => $datos['marca'],
                        'modelo' => $datos['modelo'],
                        'descripcion' => $datos['descripcion'],
                        'precio' => $datos['precio'],
                        'categoria' => $datos['categoria'],
                    ];

                } else {
                    $datos_producto = [
                        'nombre' => $datos['nombre'],
                        'marca' => $datos['marca'],
                        'modelo' => $datos['modelo'],
                        'descripcion' => $datos['descripcion'],
                        'precio' => $datos['precio'],
                        'categoria' => $datos['categoria'],
                        'imagenes' => $datos['imagen']
                    ];

                }
                $pro->update($datos_producto, ['id' => $datos['Id']]);
                $variable = 'Producto editado';
                $datos['categoria'] = $NombreCat;

                echo $this->view->render('productos/edita_form',
                    ['errors' => $val->errors, 'datos' => $datos, 'variable' => $variable, 'categorias' => $categoria]);
            }

        } else {
            echo $this->view->render('productos/edita_form',
                ['errors' => $val->errors, 'datos' => $datos, 'categorias' => $categoria]);


        }
    }


//<---------------------- MÉTODO BORRAR POR ID PRODUCTOS --------------------->

    public function delete($idProd)
    {
        if (isset($idProd) && Session::get('Rol') == 'Jefe') {
            $prod = new Producto();
            $prod->deleteProd($idProd);
        }
        header('location: ' . URL . 'productos');
    }

//<---------------------- MÉTODO BORRAR TODOS LOS PRODUCTOS --------------------->
    public function borratodo($data)
    {
        if ($data == 'Jefe') {
            $prod = new Producto();
            $prod->deleteAll();
        }
        header('location: ' . URL . 'productos');
    }


}




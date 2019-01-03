<?php

namespace Mini\Model;

Use Mini\Core\Database;


class Producto extends Conexion
{
    public $table = 'productos';

    public function deleteProd($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $conn->query("DELETE FROM $this->table WHERE id = $data");
    }

    public function deleteAll()
    {
        $conn = Database::getInstance()->getDatabase();
        $conn->query("DELETE FROM $this->table");
    }

    public function getNameModeloProd($data, $data2, $data3)
    {
        $conn = Database::getInstance()->getDatabase();

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE nombre = :nombre AND modelo = :modelo AND categoria = :categoria';

        $query = $conn->prepare($sql);
        $query->execute(
            array(":nombre" => $data,
                ":modelo" => $data2,
                ":categoria" => $data3));
        if ($query->rowCount()) {
            return false;
        } else {
            return true;
        }
    }

    public function nombreId($campo, $campo2)
    {
        $a = "SELECT * FROM productos WHERE id = :id AND nombre = :nombre";
        $prepare = $this->db->prepare($a);
        $prepare->execute(
            array(":id" => $campo,
                ":nombre" => $campo2));
        if ($prepare->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function getMarcas($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = "SELECT distinct marca FROM  $this->table  WHERE marca = $data";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllCategoria($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = "SELECT * FROM $this->table WHERE categoria = $data";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
    public function getAllCategoria2($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = "SELECT p.nombre AS nombre, p.precio AS precio, p.descripcion AS descripcion, p.modelo AS modelo, 
                p.marca AS marca, p.imagenes AS imagenes, c.nombre AS categoria 
                FROM productos p INNER JOIN categorias c WHERE c.nombre LIKE '%$data%' AND p.categoria = c.id  ORDER BY c.nombre ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


    public function getRandomCat($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = "SELECT * FROM $this->table  WHERE categoria = $data ORDER BY RAND() LIMIT 0, 1";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAll()
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = 'SELECT * FROM productos';
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllNombre($data)
    {
        $conn = Database::getInstance()->getDatabase();

        $sql = "SELECT p.nombre AS nombre, p.precio AS precio, p.descripcion AS descripcion, p.modelo AS modelo, p.marca AS marca, p.imagenes AS imagenes, c.nombre AS categoria 
                FROM productos p INNER JOIN categorias c WHERE p.nombre LIKE '%$data%' AND p.categoria = c.id ORDER BY p.nombre ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getAllMarca($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = "SELECT p.nombre AS nombre, p.precio AS precio, p.descripcion AS descripcion, p.modelo AS modelo, p.marca AS marca, p.imagenes AS imagenes, c.nombre AS categoria 
                FROM productos p INNER JOIN categorias c WHERE p.marca LIKE '%$data%' AND p.categoria = c.id ORDER BY p.marca ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }


    //MÉTODO PARA LISTAR LOS PRODUCTOS PUBLICOS PERO HACIENDO USO DE INNERJOIN PARA TRAER NOMBRE DE CATEGORÍA.
    public function getAllInnerJoin()
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = 'SELECT p.id AS id, p.nombre AS nombre, p.descripcion AS descripcion, p.modelo AS modelo, p.marca AS marca,p.imagenes AS imagenes, c.nombre AS categoria 
                FROM productos p INNER JOIN categorias c WHERE p.categoria = c.id ORDER BY c.nombre ASC;';
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

}
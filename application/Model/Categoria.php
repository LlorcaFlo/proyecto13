<?php

namespace Mini\Model;

Use Mini\Core\Database;


class Categoria extends Conexion
{

    public $table = 'categorias';


    public function getAll()
    {
        $conn = Database::getInstance()->getDatabase();
        $sql = 'select * from ' . $this->table;
        $query = $conn->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getName($data)
    {
        $conn = Database::getInstance()->getDatabase();
        $stmt = $conn->prepare("SELECT * FROM  $this->table WHERE nombre = :nombre");
        $stmt->execute(
            array(":nombre" => $data));
        return $stmt->fetchAll();
    }

    public function getAllASC()
    {
        $conn = Database::getInstance()->getDatabase();

        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY nombre ASC ';

        $query = $conn->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }

}
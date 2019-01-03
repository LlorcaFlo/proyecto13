<?php
/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-04
 * Time: 20:22
 */

namespace Mini\Model;


use Mini\Core\Database;
use Mini\Model\Conexion;


class Usuario extends Conexion
{
    public $table = 'usuarios';

    public function md5Clave($campo2)
    {
        return md5($campo2);
    }

    public function nickId($campo, $campo2)
    {
        $a = "SELECT * FROM usuarios WHERE id = :id AND nickname = :nickname";
        $prepare = $this->db->prepare($a);
        $prepare->execute(
            array(":id" => $campo,
                ":nickname" => $campo2));
        if ($prepare->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function emailId($campo, $campo2)
    {
        $a = "SELECT * FROM usuarios WHERE id = :id AND email = :email";
        $prepare = $this->db->prepare($a);
        $prepare->execute(
            array(":id" => $campo,
                ":email" => $campo2));
        if ($prepare->rowCount()) {
            return true;
        } else {
            return false;
        }
    }

    public function nickPass($campo, $campo2)
    {
        $a = "SELECT * FROM usuarios WHERE nickname = :nickname AND clave = :clave";
        $prepare = $this->db->prepare($a);
        $prepare->execute(
            array(":nickname" => $campo,
                ":clave" => $campo2));
        if ($prepare->rowCount()) {
            $a = $prepare->fetch();
            return $a;
        } else {
            return false;
        }
    }

    public function emailPass($campo, $campo2)
    {
        $a = "SELECT * FROM usuarios WHERE email = :email AND clave = :clave";
        $prepare = $this->db->prepare($a);
        $prepare->execute(
            array(":email" => $campo,
                ":clave" => $campo2));
        if ($prepare->rowCount()) {
            $a = $prepare->fetch();
            return $a;
        } else {
            return false;
        }
    }


    public function allOnly10($limit = 10)
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' LIMIT ' . $limit);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function allEmpleados()
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' WHERE rol = "Empleado"');
        $stmt->execute();
        return $stmt->fetchAll();
    }


}



















/*
    public function listarEmpleados()
    {
        $a = $this->db->query("SELECT * FROM  usuarios WHERE rol != 'Jefe'")->fetchall(PDO::FETCH_OBJ);

        return $a;
    }
*/


/*
    public function getAll()
    {
        $con = Database::getInstance()->getDatabase();

        $sql = 'select * from usuarios';

        $query = $con->prepare($sql);

        $query->execute();

        return $query->fetchAll();
    }
*/


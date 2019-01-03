<?php
/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-23
 * Time: 20:03
 */

namespace Mini\Model;

use Mini\Core\Database;

class Conexion extends Database
{
    public $db;

    public function __construct()
    {
        $this->db = parent::getInstance()->getDatabase();

    }

    //Función para listar 10 coincidencias de la base de datos...
    public function allOnly10($limit = 10)
    {
        $stmt = $this->db->prepare('SELECT * FROM ' . $this->table . ' LIMIT ' . $limit);
        $stmt->execute();
        // $this->setQuery($prepare);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMarca($data)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE marca = $data");
        $stmt->execute();
        return $stmt->fetchAll();
    }


    //Función para para listar la coincidencia por id de la base de datos...
    public function getId($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = $id");
        $stmt->execute();
        //   $this->setQuery ( $stmt );
        return $stmt->fetchAll();
    }

    public function insert($params)
    {
        if (!empty($params)) {

            $fields = '(' . implode(',', array_keys($params)) . ')';
            $values = "(:" . implode(",:", array_keys($params)) . ")";

            $prepare = $this->db->prepare('INSERT INTO ' . $this->table . ' ' . $fields . ' VALUES ' . $values);

            $prepare->execute($this->normalizePrepareArray($params));
            //$this->setQuery($prepare);
            return $this->db->lastInsertId();
        } else {
            throw new Exception('Los parámetros están vacíos');
        }
    }

    public function update($params, $where)
    {
        if (!empty($params)) {
            $fields = '';
            foreach ($params as $key => $value) {
                $fields .= $key . ' = :' . $key . ',';
            }
            $fields = rtrim($fields, ',');
            $key = key($where);
            var_dump($key);
            $value = $where[$key];
            var_dump($where);
            $ssql = 'UPDATE ' . $this->table . ' SET ' . $fields . ' WHERE ' . $key . '=' . $value;
            $prepare = $this->db->prepare($ssql);
            $prepare->execute($this->normalizePrepareArray($params));
            //$this->setQuery($prepare);
        } else {
            throw new Exception('Los parámetros están vacíos');
        }
    }

    private function normalizePrepareArray($params)
    {
        foreach ($params as $key => $value) {
            $params[':' . $key] = $value;
            unset($params[$key]);
        }
        return $params;
    }


}
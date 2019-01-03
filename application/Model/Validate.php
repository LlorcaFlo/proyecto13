<?php
/**
 * Created by PhpStorm.
 * User: josellorca
 * Date: 2018-12-23
 * Time: 19:39
 */

namespace Mini\Model;

use Mini\Model\Conexion;

class Validate extends Conexion
{
    public $errors = [];

    public function show_errors($errors)
    {
        echo '<ul class="listaerrores">';
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo '</ul>';
    }

    public function show_data($data)
    {
        if (isset($_POST[$data])) {
            echo ' value="' . $_POST[$data] . '"';
        }
    }

    public function show_data_errors($data, $errors)
    {
        if (isset($errors[$data])) {
            echo '<span class="errorf">' . $errors[$data] . '</span>';
        }
    }

    public function vacio($data)
    {
        $data = $this->sanitize($data);

        if (!$data && empty($data)) {
            return false;
        } else {
            return true;
        }
    }

    public function va_nameProd($data)
    {
        $data = $this->sanitize($data);

        if (strlen($data) < 3) {
            return false;
        } else {
            return true;
        }
    }

    public function va_nick($data)
    {
        if (strlen($data) < 6) {
            return false;
        } else {
            return true;
        }
    }

    public function va_name($data)
    {
        $data = $this->sanitize($data);
        if (strlen($data) < 3) {
            return false;
        } elseif (preg_match('/[^A-Za-z áéíóúàèìòù\-\'´âêîôûäëïöüÁÉÍÓÚÀÈÌÒÙÄËÏÖÜ]/', $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function va_lastname($data)
    {
        $data = $this->sanitize($data);
        if (preg_match('/[^A-Za-z áéíóúàèìòù\-\'´âêîôûäëïöüÁÉÍÓÚÀÈÌÒÙÄËÏÖÜ]/', $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function va_email($data)
    {
        $data = $this->sanitize($data);

        if (strlen($data) < 6) {
            return false;
        } elseif (!preg_match('/^[a-zA-Z\d-_*\.]+@[a-zA-Z\d-_*\.]+\.[a-zA-Z\d]{2,}$/', $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function va_password($data)
    {
        $data = $this->sanitize($data);

        if (strlen($data) < 6) {
            return false;
        } elseif (!preg_match('/[a-z]/', $data)) {
            return false;
        } elseif (!preg_match('/[A-Z]/', $data)) {
            return false;
        } elseif (!preg_match('/[0-9]/', $data)) {
            return false;
        } else {
            return true;
        }
    }

    public function va_select($data)
    {
        if (!$data) {
            return false;
        } else {
            return true;
        }
    }

    public function passEquals($data1, $data2)
    {
        $data1 = $this->sanitize($data1);
        $data2 = $this->sanitize($data2);
        if ($data1 !== $data2) {
            return false;
        } else {
            return true;
        }
    }

    public function uniqueNick($data)
    {
        $a = "SELECT * FROM usuarios WHERE nickname = :nickname";
        $prepare = $this->db->prepare($a);
        $prepare->execute(array(":nickname" => $data));
        if ($prepare->rowCount()) {
            return false;
        } else {
            return true;
        }
    }

    public function uniqueEmail($data)
    {
        $a = "SELECT * FROM usuarios WHERE email = :email";
        $prepare = $this->db->prepare($a);
        $prepare->execute(array(":email" => $data));
        if ($prepare->rowCount()) {
            return false;
        } else {
            return true;
        }
    }

    public function sanitize($data)
    {
        $data = trim($data);
        $data = strip_tags($data);
        $data = preg_replace("/\"/", '', $data);
        return $data;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: daw17-15
 * Date: 22/11/18
 * Time: 17:02
 */
//Será la clase padre de todos los controladores
namespace Mini\Core;

use League\Plates\Engine;

class TemplatesFactory
{
    private static $templates;

    public static function templates()
    {
        //Donde buscará cualquier vista, APP = application
        if(!TemplatesFactory::$templates){
            //Le decimos que todas las vistas están en la carpeta view
            TemplatesFactory::$templates = new Engine(APP . 'view');
            //addData método proporcionado por plates
            TemplatesFactory::$templates->addData(['titulo' => 'FAQ']);
        }

        return TemplatesFactory::$templates;
    }
}
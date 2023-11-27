<?php

namespace Controllers;

use MVC\Router;
use Model\Usuario;
use Model\Proyecto;




class DashboardController {
    public static function index (Router $router){

        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);


        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos

        ]);

    }

    public static function crear_proyecto(Router $router)
    {
        session_start();
        isAuth();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            //validacion
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                //Generar una URL unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;

                //Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];


                //guardar el proyecto
                $proyecto->guardar();

                //Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);;
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas

        ]);
    }

    public static function proyecto(Router $router){
        session_start();
        isAuth();
        
        //Revisar que la persona que visita el proyecto es quien lo creo 
        $token = $_GET['id'];
        if(!$token) header('Location: /dashboard');

        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }


        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto


        ]);

    }

    public static function perfil (Router $router){
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->varidar_perfil();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    //Mensaje de error
                    Usuario::setAlerta('error', 'Email No valido, ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();

                }else{
                //Guardar Usuario
                $usuario->guardar();

                //asignar el nombre Nuevo
                $_SESSION['nombre'] = $usuario->nombre;

                Usuario::setAlerta('exito', 'Guardado correctamente');
                $alertas = $usuario->getAlertas();  
                }

            }

        }


        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario'=> $usuario,
            'alertas' =>$alertas

        ]);

    }

    public static function cambiar_password(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            //sincronizar con los daros del usuario
            $usuario->sincronizar($_POST);

            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado){
                    $usuario->password = $usuario->password_nuevo;

                    //EliminarPropiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);

                    //hashear password
                    $usuario->hashPassword();

                    //Guardar el Nuevo Password
                    $resultado = $usuario->guardar();

                    if($resultado){
                        Usuario::setAlerta('exito', 'Password Actualizado correctamente');
                        $alertas = $usuario->getAlertas(); 

                    }
                }else{
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }

            }


        }

        $router->render('dashboard/cambiar-password', [
            'titulo' =>'Cambiar-password',
            'alertas' =>$alertas


        ]);

    }
}






?>
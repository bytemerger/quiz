<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 1/20/19
 * Time: 10:43 PM
 */

namespace App\controllers;

use App\models\register;

// controller for the login(for students) and registration of exam for facilitators
session_start();
class entry
{
    /**
     * entry constructor.
     * @param $service
     * service is for rendering view from this controller
     */
    public function __construct($service)
    {
        //switch for actions
        switch ($_POST['action'])
        {
            case 'login': $this->login($service);
            break;
            case 'register': $this->register($service);
        }

    }

    /**
     * @param $service
     * login user
     */
    public function login($service)
    {
        $data=$_POST;
        $register= new register();
        $course=$register->loginStudent();
        if($course !== false)
        {
            $_SESSION['student_id']=$data['password'];
           $service->render('app/views/start.phtml',array('course'=>$course));
        }
        else{
            $service->render('app/views/error.phtml',array('error'=>'There is no available exam'));
        }
    }

    //register an exam
    public function register($service)
    {
       $file=$_FILES['file'];
       $data=$_POST;
       $register= new register();

       $register->register($data,$file);

       $service->render('app/views/examiner-start.phtml',array('course'=>$data['course']));
    }
}
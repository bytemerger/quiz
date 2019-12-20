<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 9/27/19
 * Time: 6:35 PM
 */

namespace App\controllers;
use App\models\quiz;
use App\models\helpers;
session_start();
class write
{

    public function __construct()
    {
        $input=json_decode(file_get_contents('php://input'),true);
        switch ($input['action'])
        {
            case 'start': $this->randomQuestion($this->id);
            break;
            case 'getQuestion': $this->getQuestion($_SESSION['student_id'],$input["question"]);
            break;
            case 'answered' : $this->getAnsweredQuestion($_SESSION['student_id']);

        }
    }
    public function proceed($id)
    {
        $id= str_replace(substr($id, 4, 1), '', $id);
        if(!helpers::checkTable($id)){
            $this->randomQuestion($id);
            $result=$this->getQuestion($id,'1');
            return $result;
        }
        elseif(helpers::checkTable($id)){
            $result=$this->getQuestion($id,'1');
            return $result;
        }
    }
    public function randomQuestion($id)
    {
        //shuffle and create new table questions
        // for the user with score and time
        quiz::setPersonalisedQuestions($id);


    }

    public function getQuestion($id,$question)
    {
        //at request get the current question from personalised
        // question database
        return quiz::getQuestion($id,$question);
    }
    public function getAnsweredQuestion($id)
    {
        $id= str_replace(substr($id, 4, 1), '', $id);
        //$result['rows'] = quiz::totalNofRows($id);
        $result = quiz::answeredQuestion($id);

        echo json_encode($result);
    }
    public function timeCount()
    {
        //save time count to database

    }
    public function sendAnswer()
    {
        //check if answer is coorect
        //add to score and make question as answered
    }
    public function submit()
    {
        //logout and stop exam
    }
}
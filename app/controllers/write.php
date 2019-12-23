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
    /*
     * The construct gets the action to be taken from the request sent */
    public function __construct()
    {
        $input=json_decode(file_get_contents('php://input'),true);
        switch ($input['action'])
        {
            case 'start': $this->randomQuestion($this->id);
            break;
            case 'getQuestion': $this->getQuestion($_SESSION['student_id'],$input["question"],'xml');
            break;
            case 'answered' : $this->getAnsweredQuestion($_SESSION['student_id']);
            break;
            case 'answerQ': $this->sendAnswer($_SESSION['student_id'],$input);

        }
    }
    /*
     * this is used for the get request (learning purposes)*/
    public function proceed($id)
    {
        $id= str_replace(substr($id, 4, 1), '', $id);
        if(!helpers::checkTable($id)){
            $this->randomQuestion($id);
            return $_SESSION['student_id'];
        }
        elseif(helpers::checkTable($id)){
            //get time and other info...
            return $_SESSION['student_id'];
        }
    }
    //creates and randomizes the records of a particular table to make it unique
    public function randomQuestion($id)
    {
        //shuffle and create new table questions
        // for the user with score and time
        quiz::setPersonalisedQuestions($id);


    }
    /*function to get question the $requesType argument is for learning
    to allow for two different request to access the same function(xmlhttprequest and normal get request
    */
    public function getQuestion($id,$question,$requesType='normal')
    {
        //at request get the current question from personalised
        // question database
        if ($requesType == 'xml'){
            $id= str_replace(substr($id, 4, 1), '', $id);
            $result=quiz::getQuestion($id,$question);
            echo json_encode($result);
        }
        else
            return quiz::getQuestion($id,$question);
    }
    /*
     * get the questions numbers used to check if a question has been answered*/
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
    public function sendAnswer($student,$input)
    {   $student= str_replace(substr($student, 4, 1), '', $student);

        quiz::answerQuestion($student,$input['question'],$input['answer']);
    }
    public function submit()
    {
        //logout and stop exam
    }
}
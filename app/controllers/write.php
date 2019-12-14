<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 9/27/19
 * Time: 6:35 PM
 */

namespace App\controllers;
use App\models\quiz;

session_start();
class write
{
    public function __construct()
    {
        $id = $_SESSION["student_id"];
        switch ($_POST["action"])
        {
            case 'start': $this->randomQuestion($id);
            break;
            case 'getQuestion': $this->getQuestion($_POST["id"],$_POST["question"]);

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
        quiz::getQuestion($id,$question);
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
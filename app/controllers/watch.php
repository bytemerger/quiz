<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 12/23/19
 * Time: 12:20 PM
 */

namespace App\controllers;
use App\models\record;
use App\models\helpers;

class watch
{
    public function get($course)
    {
        if(!helpers::checkTable($course)){
            $this->startExam($course);
        }
        elseif(helpers::checkTable($course)){
            return $this->getScores($course);
        }

    }

    public function startExam($course)
    {
        record::startExam($course);
    }

    public function getScores($course)
    {
       return record::getResult($course);
    }

    public function stopExam()
    {

    }
}
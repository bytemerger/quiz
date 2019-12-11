<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 1/23/19
 * Time: 3:20 AM
 */

namespace App\models;

use App\db\dbconnect;
use App\models\helpers;


class register
{

    /**
     * @param $data
     * register exam
     * @param $file
     */
    public function register($data,$file)
    {
        /**
         * check if table exist // check if exam is already on
         * if not create table
         */
        if(!helpers::checkTable('exam'))
        {
            $conn= new dbconnect();
            $sql="CREATE TABLE exam (
                course varchar(255),
                email varchar(255),
                time varchar(255)
            )";
                $conn->db->exec($sql);

            /**
             * insert the values into the created table
             */
            $sql = "INSERT INTO exam (course, email, time) VALUES ( :course, :email, :time )";
            $st = $conn->db->prepare($sql);
            $st->bindValue(":course", $data['course']);
            $st->bindValue(":email", $data['email']);
            $st->bindValue(":time", $data['time']);

            $st->execute();

            $this->createExam($file);
        }
        else
            {
                /**
                 * there is an exam going on or existing
                 */
                echo "exam is ongoing";
            }
        $conn=null;
    }
    public function createExam($file)
    {
        helpers::importCsv($file,'questions');
    }

    public function loginStudent()
    {
        /**
         * check if exam is available
         */
        $conn= new dbconnect();
        if(!helpers::checkTable('exam'))
        {
            $course= false;
            return $course;

        }
        else
            {
                //there can only be one exam
                $sql= "SELECT course from exam LIMIT 1";
                $course=$conn->db->query($sql)->fetch();
                return $course['course'];
            }

    }
}
<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 9/29/19
 * Time: 11:47 PM
 */

namespace App\models;

use App\db\dbconnect;

class quiz
{
    protected static $conn;

    public static function setPersonalisedQuestions($id,$course)
    {   self::$conn = new dbconnect();
        //creates a table like the main questions table and randomizes the questions....
       $sql= "CREATE TABLE `:id` LIKE questions;
              INSERT INTO `:id` (question, answer1, answer2, answer3, answer4, ans) SELECT question, answer1, answer2, answer3, answer4, ans FROM questions ORDER BY RAND();
              ALTER TABLE `:id`
              ADD COLUMN s_ans VARCHAR(255) AFTER ans";
       $stmt= self::$conn->db->prepare($sql);
       $stmt->bindValue(":id",$id,\PDO::PARAM_INT);
       $stmt->execute();
       self::createScore($course,$id);

    }


    public static function getQuestion($id,$question)
    {   self::$conn = new dbconnect();
        $sql="SELECT question, answer1, answer2, answer3, answer4, ans, s_ans from `:id` where id = :question ";
        $stmt= self::$conn->db->prepare($sql);
        $stmt->bindValue(":id",$id,\PDO::PARAM_INT);
        $stmt->bindValue(":question",$question);
        $stmt->execute();
        $result=$stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public static function answerQuestion($user, $question, $ans)
    {
        self::$conn = new dbconnect();
        $sql="UPDATE `:user` SET s_ans =:ans WHERE id = :id";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(":id", $question);
        $st->bindValue(":ans",$ans);
        $st->bindValue(":user",$user,\PDO::PARAM_INT);
        $st->execute();


    }

    public static function totalNofRows($table)
    {
        $sql="SELECT COUNT(*) from `:table`";
        self::$conn = new dbconnect();
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(':table',$table,\PDO::PARAM_INT);
        $st->execute();
        //$st->rowCount();
        $row = $st->fetchColumn();
        return $row;
    }

    public static function answeredQuestion($student)
    {
        $sql="SELECT id, s_ans from `:student`";
        self::$conn = new dbconnect();
        $stm= self::$conn->db->prepare($sql);
        $stm->bindValue(':student',$student,\PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getScore($student)
    {
        $sql="SELECT ans, s_ans from `:student`";
        self::$conn = new dbconnect();
        $stm= self::$conn->db->prepare($sql);
        $stm->bindValue(':student',$student,\PDO::PARAM_INT);
        $stm->execute();
        $result = $stm->fetchAll(\PDO::FETCH_ASSOC);

        return $result;
    }

    public static function createScore($course,$user)
    {
        $user= substr_replace($user,'/',4,0);

        self::$conn = new dbconnect();
        $sql="INSERT INTO `:course` (stu_id,score,time) VALUES (:id, 0,0)";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(":course",$course,\PDO::PARAM_INT);
        $st->bindValue(":id",$user);
        $st->execute();
    }

    public static function updateScore($user,$course,$score)
    {
        //this is to correct the 201221414(for tables) to 2012/21414
        $user= substr_replace($user,'/',4,0);
        self::$conn = new dbconnect();
        $sql="UPDATE `:course` SET score =:score WHERE stu_id = :id";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(":course",$course,\PDO::PARAM_INT);
        $st->bindValue(":id",$user);
        $st->bindValue(":score",$score);
        $st->execute();

    }

    public static function getSet()
    {
        $sql="SELECT time from exam";
        self::$conn = new dbconnect();
        $stm= self::$conn->db->prepare($sql);
        $stm->execute();
        $result = $stm->fetch();

        return $result;
    }
    public static function getStuTime($course,$id)
    {
        $sql="SELECT time from `:course` WHERE stu_id = :id";
        self::$conn = new dbconnect();
        $stm= self::$conn->db->prepare($sql);
        $stm->bindValue(":course",$course,\PDO::PARAM_INT);
        $stm->bindValue(":id",$id);
        $stm->execute();
        $result = $stm->fetch();

        return $result;
    }

    public static function saveTime($course,$student,$time)
    {
        self::$conn = new dbconnect();
        $sql="UPDATE `:course` SET time =:time WHERE stu_id = :id";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(":course",$course,\PDO::PARAM_INT);
        $st->bindValue(":id",$student);
        $st->bindValue(":time",$time);
        $st->execute();
    }

}
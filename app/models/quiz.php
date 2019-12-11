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
    public function __construct()
    {
       self::$conn = new dbconnect();
    }

    public static function setPersonalisedQuestions($id)
    {
        //creates a table like the main questions table and randomizes the questions....
       $sql= "CREATE TABLE :id LIKE questions; INSERT INTO :id (question, answer1, answer2, answer3, answer4, ans) SELECT id, question, answer1, answer2, answer3, answer4, ans FROM questions ORDER BY RAND();
              ALTER TABLE :id
              ADD COLUMN s_ans VARCHAR(255) AFTER ans";
       $stmt= self::$conn->db->prepare($sql);
       $stmt->execute([":id"=> $id]);

    }


    public static function getQuestion($id,$question)
    {
        $sql="SELECT question, answer1, answer2, answer3, answer4, ans, s_ans from :id where id = :question ";
        $stmt= self::$conn->db->prepare($sql);
        $stmt->bindValue(":id",$id);
        $stmt->bindValue(":question",$question);
        $stmt->execute();
        $result=$stmt->fetch(\PDO::FETCH_ASSOC);

        return $result;
    }

    public static function answerQuestion($user, $question, $ans)
    {
        $sql="UPDATE :user SET s_ans=:ans WHERE id = :id";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(":id", $question);
        $st->bindValue(":ans",$ans);
        $st->bindValue(":user",$user);
        $st->execute();


    }


}
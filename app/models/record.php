<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/13/19
 * Time: 11:19 PM
 */

namespace App\models;

use App\db\dbconnect;

class record
{
    public static $conn;
    public static function startExam($course)
    {
        self::$conn =new dbconnect();
        $sql = "CREATE TABLE `:course` (
                stu_id varchar(255),
                score varchar(255),
                time varchar(255)
            )";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(':course',$course,\PDO::PARAM_INT);
        $st->execute();

    }

    public static function getResult($course)
    {
        self::$conn = new dbconnect();
        $sql = "SELECT stu_id, score, time FROM `:course`";
        $st = self::$conn->db->prepare($sql);
        $st->bindValue(':course',$course,\PDO::PARAM_INT);
        $st->execute();
        $result = $st->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
}
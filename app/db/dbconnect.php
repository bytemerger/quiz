<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/30/18
 * Time: 8:57 AM
 */

namespace App\db;


class dbconnect
{
    //hold the db connection
    public  $db;

    public function __construct()
    {
        $this->db= new \PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

    }
}

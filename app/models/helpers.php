<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 1/23/19
 * Time: 1:10 PM
 */

namespace App\models;

use App\db\dbconnect;

class helpers
{

    public static function checkTable($table)
    {
        global $a;
        $conn= new dbconnect();
        $conn->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        try {
            $result = $conn->db->query("SELECT 1 FROM `$table` LIMIT 1");
        } catch (\Exception $e) {
            // We got an exception == table not found
            $a= $e->getMessage();

        }
        if(!$a)
            return TRUE;
        else return false;
    }

    public static function importCsv($file,$table)
    {
        $conn= new dbconnect();
        if(helpers::checkTable('questions')) {
            $sql="DROP TABLE questions";
            $conn->db->exec($sql);
        }
        $sql="CREATE TABLE  questions (
                id int NOT NULL AUTO_INCREMENT,
                question  TEXT,
                answer1 varchar(255),
                answer2 varchar(255),
                answer3 varchar(255),
                answer4 varchar(255),
                ans varchar(255),
                PRIMARY KEY (id)
                  )";

        $conn->db->exec($sql);

        $filename=$file['tmp_name'];
        if($file["size"] > 0)
        {
            $csv = fopen($filename, "r");
            $check= true;
            //$tableColumns="";
            while (($getData = fgetcsv($csv, 10000, ",")) !== FALSE)
            {
                 /*//this is to escape the header and use it as the db table columns
                if($check)
                {
                    $check=false;
                    $tableColumns=$getData;
                    continue;
                }
                //get column names
                $columns=implode(",",$tableColumns);

                */
                //get table values
                //$values = '"' . implode('", "', $getData) . '"';
                $values = $getData;
                /*the prepare statement
                $prep=':' . implode(', :', $tableColumns) ;
                */
                $place_holders = implode(',', array_fill(0, 6, '?'));

                echo $place_holders;

                //create a new question table

                try {
                    $sql = "INSERT into $table (question, answer1, answer2, answer3, answer4, ans) values (".$place_holders.")";
                    $st=$conn->db->prepare($sql);
                    $st->execute($values);
                }
                catch (\Exception $e) {
                    $status='unable to create user';
                }

            }
            if(!$status)
            {
                echo "<script type=\"text/javascript\">
                            alert(\"CSV File has been successfully Imported.\");
							window.location = \"/watch\"
						  </script>";
            }
            else {
                echo "<script type=\"text/javascript\">
						alert(\"Invalid File:Please Upload CSV File.\");
						window.location = \"ans.com\"
					</script>";
            }

            fclose($filename);
        }
    }
}
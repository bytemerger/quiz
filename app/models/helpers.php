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
    /**
     * Check if a table exists in the current database.
     *
     * @param string $table Table to search for.
     * @return bool TRUE if table exists, FALSE if no table found.
     */
    public static function checkTable($table)
    {

        // Try a select statement against the table
        // Run it in try/catch in case PDO is in ERRMODE_EXCEPTION.
        $conn= new dbconnect();
        try {
            $result = $conn->db->query("SELECT 1 FROM $table LIMIT 1");
        } catch (\Exception $e) {
            // We got an exception == table not found
            return FALSE;
        }

        // Result is either boolean FALSE (no table found) or PDOStatement Object (table found)
        return $result !== FALSE;
    }


    public static function importCsv($file,$table)
    {
        $filename=$file['tmp_name'];
        if($file["size"] > 0)
        {
            $csv = fopen($filename, "r");
            $check= true;
            //$tableColumns="";
            while (($getData = fgetcsv($csv, 10000, ",")) !== FALSE)
            {
                // this is to escape the header and use it as the db table columns
                if($check)
                {
                    $check=false;
                    $tableColumns=$getData;
                    continue;
                }
                //get column names
                $columns=implode(",",$tableColumns);

                //get table values
                //$values = '"' . implode('", "', $getData) . '"';
                $values = $getData;
                /*the prepare statement
                $prep=':' . implode(', :', $tableColumns) ;
                */
                $place_holders = implode(',', array_fill(0, count($tableColumns), '?'));

                echo $place_holders,$columns;
                $conn= new dbconnect();
                try {
                    $sql = "INSERT into $table (".$columns.") values (".$place_holders.")";
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
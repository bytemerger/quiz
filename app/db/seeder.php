<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 9/30/19
 * Time: 12:28 AM
 */

namespace App\db;
use App\db\dbconnect;
use Faker\Factory;
class seeder
{
    public $faker;

    public function generate()
    {
        $this->faker = Factory::create();

        foreach (range(1,48) as $x) {
            $question = $this->faker->sentences($nb = 1, $asText = false);
            $question = implode('', $question);
            $answer1 = $this->faker->word;
            $answer2 = $this->faker->word;
            $answer3 = $this->faker->word;
            $answer4 = $this->faker->word;

            //collect the answer randomly
            $array = array($answer1, $answer2, $answer3, $answer4);
            //To make answer an option from the for created variables
            $answer = $array[rand(0, count($array) - 1)];
            $conn = new dbconnect();
            $sql = "INSERT INTO questions (question, answer1, answer2, answer3, answer4, ans) VALUES ( :question, :answer1, :answer2, :answer3, :answer4, :answer )";
            $st = $conn->db->prepare($sql);
            $st->bindValue(":question", $question);
            $st->bindValue(":answer1", $answer1);
            $st->bindValue(":answer2", $answer2);
            $st->bindValue(":answer3", $answer3);
            $st->bindValue(":answer4", $answer4);
            $st->bindValue(":answer", $answer);

            $st->execute();
        }
    }


}
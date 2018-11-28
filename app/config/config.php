<?php
/**
 * Created by PhpStorm.
 * User: franc
 * Date: 11/28/18
 * Time: 5:41 PM
 */

namespace App\config;


class config
{
    public function __construct()
    {
        //set default date and time
        date_default_timezone_set( "Africa/Lagos" );  // http://www.php.net/manual/en/timezones.php
        //define database connection variables
        define( "DB_DSN", "mysql:host=localhost;dbname=quiz" );
        define( "DB_USERNAME", "franc" );
        define( "DB_PASSWORD", "come1234" );
        //set a default language
        define('LANGUAGE_CODE', 'en');
        define('IMAGE_PATH', '/app/public/img');
    }

}
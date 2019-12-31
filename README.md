# quiz
###### Question and answer app with lecturer monitoring

# Getting Started
1. PHP 5.3.x is required
2. Install Klein using Composer (recommended) or manually
3. Setup URL rewriting so that all requests are handled by index.php
4. Setup db config

# Composer
1. Get Composer
2. Require Klein with php composer.phar require klein/klein
3. Add the following to your application's main PHP file: require 'vendor/autoload.php';
4. Install fzaninotto/faker to generate fake data use seeder class in db directory(if need be)

# Usage
* The course code has to be numeric
* For login of student the username and password is same and should be matNumber(case study UNN-2012/21414)

# Warnings
1. The project is a model/protoype therefore it should be improved before deployment for official use

# Possible improvements
1. Security- logins for both examiner and student
2. The result are printed immediately the stop is button is clicked, this could be improved to send an email to the lecturer.

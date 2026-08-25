<?php

require 'autoload.php';

use App\Students\Student;

$student = new Student('Nguyen Tan Sang', 20, 'SV001');
$student->showInfo();

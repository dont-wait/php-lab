<?php

namespace App\Students;

class Person
{
    protected $name;

    protected $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function showInfo()
    {
        echo "Ten: {$this->name}<br>";
        echo "Tuoi: {$this->age}<br>";
    }
}

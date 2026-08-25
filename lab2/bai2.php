<?php

class Student
{
    private $name;

    private $age;

    public function __construct($name, $age)
    {
        $this->name = $name;
        $this->age = $age;
    }

    public function display()
    {
        echo "Name: {$this->name}, Age: {$this->age}<br>";
    }

    public function __destruct()
    {
        echo 'Đối tượng Student đã bị hủy.<br>';
    }
}
$student1 = new Student('Nguyễn Tấn Sang', 20);
$student1->display();

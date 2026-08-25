<?php

class Book
{
    protected $title;

    protected $author;

    protected $price;

    public function __construct($title, $author, $price)
    {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }

    public function showInfo()
    {
        echo "Ten sach: {$this->title}<br>";
        echo "Tac gia: {$this->author}<br>";
        echo "Gia: {$this->price}<br>";
    }
}

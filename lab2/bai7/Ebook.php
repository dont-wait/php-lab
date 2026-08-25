<?php

require_once 'Book.php';
require_once 'Downloadable.php';

class Ebook extends Book implements Downloadable
{
    private $fileSize;

    public function __construct($title, $author, $price, $fileSize)
    {
        parent::__construct($title, $author, $price);
        $this->fileSize = $fileSize;
    }

    public function showInfo()
    {
        parent::showInfo();
        echo "Dung luong file: {$this->fileSize} MB<br>";
    }

    public function download()
    {
        echo "Dang tai ebook: {$this->title}<br>";
    }
}

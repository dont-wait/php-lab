<?php

require 'Ebook.php';

$ebook = new Ebook('Lap trinh PHP', 'Nguyen Tan Sang', 120000, 29);

$ebook->showInfo();
echo '<hr>';
$ebook->download();

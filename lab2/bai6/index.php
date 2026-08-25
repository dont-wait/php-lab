<?php

require 'BankAccount.php';

$taiKhoan = new BankAccount('0367065xxx', 'Nguyen Tan Sang', 1000000);

$taiKhoan->hienThiSoDu();
echo '<hr>';

$taiKhoan->napTien(500000);
$taiKhoan->rutTien(300000);
$taiKhoan->rutTien(2000000);

echo '<hr>';
$taiKhoan->hienThiSoDu();

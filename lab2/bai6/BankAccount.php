<?php

class BankAccount
{
    private $soTaiKhoan;

    private $tenChuTaiKhoan;

    private $soDu;

    public function __construct($soTaiKhoan, $tenChuTaiKhoan, $soDu = 0)
    {
        $this->soTaiKhoan = $soTaiKhoan;
        $this->tenChuTaiKhoan = $tenChuTaiKhoan;
        $this->soDu = $soDu;
    }

    public function napTien($soTien)
    {
        if ($soTien > 0) {
            $this->soDu += $soTien;
            echo "Nap tien thanh cong: {$soTien}<br>";
        } else {
            echo 'So tien nap khong hop le.<br>';
        }
    }

    public function rutTien($soTien)
    {
        if ($soTien <= 0) {
            echo 'So tien rut khong hop le.<br>';

            return;
        }

        if ($soTien > $this->soDu) {
            echo 'Khong du so du de rut.<br>';

            return;
        }

        $this->soDu -= $soTien;
        echo "Rut tien thanh cong: {$soTien}<br>";
    }

    public function hienThiSoDu()
    {
        echo "So tai khoan: {$this->soTaiKhoan}<br>";
        echo "Chu tai khoan: {$this->tenChuTaiKhoan}<br>";
        echo "So du hien tai: {$this->soDu}<br>";
    }
}

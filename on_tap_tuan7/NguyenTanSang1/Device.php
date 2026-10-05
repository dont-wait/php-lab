<?php
// Câu 1.2 — Lab 2: private, constructor, getter và phương thức đối tượng.
// Ref: lab2/bai2.php; lab2/bai6/BankAccount.php; lab2/bai7/Book.php.
class Device
{
    private string $deviceName;
    private float $price;
    private int $stock;

    public function __construct(string $deviceName, float $price, int $stock)
    {
        if ($price < 0 || $stock < 0) throw new InvalidArgumentException('Giá và tồn kho phải không âm.');
        $this->deviceName = $deviceName;
        $this->price = $price;
        $this->stock = $stock;
    }
    public function getDeviceName(): string { return $this->deviceName; }
    public function getPrice(): float { return $this->price; }
    public function getStock(): int { return $this->stock; }
    public function getInventoryValue(): float { return $this->price * $this->stock; }
    public function showInfo(): void
    {
        echo 'Tên: '.htmlspecialchars($this->getDeviceName(), ENT_QUOTES, 'UTF-8').'<br>';
        echo 'Đơn giá: '.number_format($this->getPrice(), 0, ',', '.').' đồng<br>';
        echo 'Tồn kho: '.$this->getStock().'<br>';
        echo 'Giá trị tồn: '.number_format($this->getInventoryValue(), 0, ',', '.').' đồng<br>';
    }
}

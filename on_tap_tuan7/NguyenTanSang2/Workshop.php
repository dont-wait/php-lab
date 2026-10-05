<?php
// Câu 1.2 — Lab 2: private, constructor, getter, phương thức tính toán.
// Ref: lab2/bai2.php; lab2/bai6/BankAccount.php; lab2/bai7/Book.php.
class Workshop
{
    private string $title;
    private float $fee;
    private int $capacity;

    public function __construct(string $title, float $fee, int $capacity)
    {
        if ($fee < 0 || $capacity < 0) throw new InvalidArgumentException('Học phí và sức chứa phải không âm.');
        $this->title = $title;
        $this->fee = $fee;
        $this->capacity = $capacity;
    }
    public function getTitle(): string { return $this->title; }
    public function getFee(): float { return $this->fee; }
    public function getCapacity(): int { return $this->capacity; }
    public function getDiscountedFee($percent): float
    {
        if (!is_numeric($percent) || !is_finite((float) $percent) || $percent < 0 || $percent > 100) {
            throw new InvalidArgumentException('Phần trăm giảm phải từ 0 đến 100.');
        }
        return $this->fee * (1 - $percent / 100);
    }
    public function showInfo(): void
    {
        echo 'Tên: '.htmlspecialchars($this->getTitle(), ENT_QUOTES, 'UTF-8').'<br>';
        echo 'Học phí: '.number_format($this->getFee(), 0, ',', '.').' đồng<br>';
        echo 'Sức chứa: '.$this->getCapacity().'<br>';
    }
}

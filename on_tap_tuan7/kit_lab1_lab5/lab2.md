# Lab 2 — OOP trong PHP

Ứng dụng trong đề: **câu 1.2** — Device hoặc Workshop.

## Bài gốc nên xem

| Bài | File | Kiến thức |
| --- | --- | --- |
| 1 | [Car](../../lab2/bai1.php) | Class, thuộc tính public, tạo đối tượng và gọi phương thức |
| 2 | [Student](../../lab2/bai2.php) | Private, constructor, destructor |
| 3 | [MathHelper](../../lab2/bai3.php) | Static và kế thừa |
| 4 | [Animal](../../lab2/bai4.php) | Abstract class, phương thức abstract, interface |
| 5 | [autoload](../../lab2/bai5/autoload.php), [User](../../lab2/bai5/app/Models/User.php) | Namespace, spl_autoload_register |
| 6 | [BankAccount](../../lab2/bai6/BankAccount.php) | Đóng gói dữ liệu, kiểm tra nạp/rút |
| 7 | [Book](../../lab2/bai7/Book.php), [Ebook](../../lab2/bai7/Ebook.php), [Downloadable](../../lab2/bai7/Downloadable.php) | Kế thừa, parent, ghi đè, interface |
| 8 | [Person](../../lab2/bai8/App/Students/Person.php), [Student](../../lab2/bai8/App/Students/Student.php), [autoload](../../lab2/bai8/autoload.php) | Namespace kết hợp kế thừa và autoload |

## Mẫu class để đổi sang Device/Workshop

Ref bài 2 + bài 6 + bài 7. Lưu thành `Product.php`, ví dụ tạo đối tượng đặt trong `demo.php`.

```php
<?php
class Product
{
    private string $name; // Chỉ class này truy cập trực tiếp.
    private float $price;
    private int $quantity;

    public function __construct(string $name, float $price, int $quantity)
    {
        if ($price < 0 || $quantity < 0) {
            throw new InvalidArgumentException('Giá/số lượng phải không âm.');
        }
        $this->name = $name; // $this là đối tượng hiện tại.
        $this->price = $price;
        $this->quantity = $quantity;
    }
    public function getName(): string { return $this->name; }
    public function getPrice(): float { return $this->price; }
    public function getQuantity(): int { return $this->quantity; }
    public function getValue(): float { return $this->price * $this->quantity; }
    public function showInfo(): void
    {
        echo htmlspecialchars($this->name, ENT_QUOTES, 'UTF-8').'<br>';
        echo 'Giá: '.$this->price.'; số lượng: '.$this->quantity.'<br>';
        echo 'Tổng: '.$this->getValue();
    }
}
```

```php
<?php
require __DIR__.'/Product.php';
$product = new Product('Webcam', 2150000, 12);
$product->showInfo(); // Tổng: 25800000.
```

Getter trả giá trị để nơi gọi tính toán/hiển thị tiếp. `showInfo(): void` xuất HTML, không trả số. Muốn đổi thành Device thì giữ đúng tên class, thuộc tính và phương thức mà đề yêu cầu. Workshop cần `getDiscountedFee($percent) = fee * (1 - $percent / 100)` với percent trong 0–100.

## Phân biệt nhanh

| Cú pháp | Nghĩa |
| --- | --- |
| `public` | Bên ngoài class được truy cập |
| `private` | Chỉ class khai báo được truy cập |
| `protected` | Class khai báo và class con được truy cập |
| `$object->method()` | Gọi phương thức của đối tượng |
| `ClassName::method()` | Gọi phương thức static |
| `extends` | Kế thừa một class |
| `implements` | Thực hiện hợp đồng interface |
| `parent::__construct(...)` | Khởi tạo phần dữ liệu của class cha |
| `use App\Students\Student` | Dùng tên class có namespace; không tự nạp file |

Ví dụ độc lập để ôn abstract/interface, ref bài 4:

```php
<?php
interface Downloadable { public function download(): string; }
abstract class Document { abstract public function describe(): string; }
class Ebook extends Document implements Downloadable
{
    public function describe(): string { return 'Sách điện tử'; }
    public function download(): string { return 'Đang tải'; }
}
$book = new Ebook();
echo $book->describe().' — '.$book->download();
```

Autoload ref bài 8: `spl_autoload_register` nhận tên class, đổi `\` thành `/`, rồi require file tương ứng. Namespace và đường dẫn phải khớp cả chữ hoa/thường khi chạy Linux. Ví dụ `App\Students\Student` → `App/Students/Student.php`.

## Lỗi dễ gặp và tự luyện

- Không đọc `$device->price` nếu thuộc tính private; gọi getter.
- Gọi phương thức instance bằng `->`, không dùng `::` tùy tiện.
- Class con gọi constructor cha khi cần giữ dữ liệu của cha.
- Bài 5 hiện có `ser->sayHello()` thay vì `$user->sayHello()`; xem nguyên tắc namespace ở class/autoload, không chép nhầm dòng gọi này.

Tự luyện: tạo Device giá 100, stock 3 → inventory value 300. Workshop fee 1000 giảm 25% → 750; giảm 100% → 0. Giải thích vì sao setter không cần nếu đề chỉ yêu cầu khởi tạo rồi đọc dữ liệu.

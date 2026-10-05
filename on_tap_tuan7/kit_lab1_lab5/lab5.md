# Lab 5 — JOIN, thống kê và subquery

Ứng dụng trong đề: **3.1, 3.2** và phép đếm đăng ký của **2.1 đề 02**. Lab 5 trong repo này là ứng dụng SQL/PDO ở `lab5/buoi5`, dùng schema `lab3_shop`; không phải ứng dụng Laravel trong Lab 6.

## Bài gốc nên xem

| Bài | File | Dạng câu hỏi |
| --- | --- | --- |
| 1 | [bai1.php](../../lab5/buoi5/bai1.php) | Số sản phẩm mỗi loại: LEFT JOIN, COUNT, GROUP BY |
| 2 | [bai2.php](../../lab5/buoi5/bai2.php) | Doanh thu mỗi ngày: SUM(quantity × price) |
| 3 | [bai3.php](../../lab5/buoi5/bai3.php) | Loại có nhiều sản phẩm: HAVING |
| 4 | [bai4.php](../../lab5/buoi5/bai4.php) | Chi tiêu khách hàng, lọc tổng tiền |
| 5 | [bai5.php](../../lab5/buoi5/bai5.php) | Sản phẩm giá cao nhất từng loại: correlated subquery MAX |
| 6 | [bai6.php](../../lab5/buoi5/bai6.php) | Chưa từng được đặt: LEFT JOIN và IS NULL |
| 7 | [bai7.php](../../lab5/buoi5/bai7.php) | Khách hàng mua nhiều nhất: SUM, ORDER BY, LIMIT |
| 8 | [bai8.php](../../lab5/buoi5/bai8.php) | Doanh thu và tổng số lượng theo loại |
| 9 | [bai9.php](../../lab5/buoi5/bai9.php) | Top 3 sản phẩm: tổng theo đối tượng rồi sắp xếp |
| 10 | [bai10.php](../../lab5/buoi5/bai10.php) | Hai khách hàng chi tiêu nhiều nhất |
| 11 | [bai11.php](../../lab5/buoi5/bai11.php) | Mẫu tổng hợp/sắp xếp doanh thu; cần chú ý GROUP BY thực tế |
| 12 | [bai12.php](../../lab5/buoi5/bai12.php) | Đếm số dòng đặt hàng mỗi sản phẩm |

Bài 11 gốc nhóm theo cả category, tên và giá sản phẩm, nên kết quả thực tế là theo **sản phẩm trong loại**, dù tiêu đề ghi theo loại. Muốn tổng theo loại thì GROUP BY loại, không thêm tên sản phẩm vào nhóm.

## Chọn đúng câu lệnh

| Cần làm | Dùng | Ý nghĩa |
| --- | --- | --- |
| Ghép các bảng có quan hệ | JOIN ... ON | Chỉ giữ dòng có khớp |
| Giữ cả đối tượng chưa có chi tiết | LEFT JOIN | Chi tiết không khớp trở thành NULL |
| Lọc từng dòng trước tổng hợp | WHERE | Ví dụ status = confirmed |
| Nhóm các dòng cùng loại | GROUP BY | Mỗi nhóm tạo một kết quả |
| Lọc kết quả tổng hợp | HAVING | Ví dụ SUM(quantity) ≥ 2 |
| Đếm số bản ghi | COUNT(id) | Không đếm id NULL |
| Cộng số lượng/giá trị | SUM(quantity), SUM(quantity * price) | Không phải số dòng |
| Lấy lớn nhất | MAX(...) | Chỉ lớn nhất trong tập đang xét |
| Thay tổng NULL bằng 0 | COALESCE(..., 0) | Hữu ích với LEFT JOIN |

Thứ tự viết: `SELECT → FROM/JOIN → WHERE → GROUP BY → HAVING → ORDER BY → LIMIT`. Khi hiểu dữ liệu, nghĩ theo luồng `FROM/JOIN → WHERE → GROUP BY → HAVING → SELECT → ORDER BY/LIMIT`.

## Mẫu 1: thống kê thiết bị theo loại — câu 3.1 đề 01

Ref bài 8 + bài 3. Chạy trên `week7_device`.

```sql
SELECT d.category,
       SUM(bd.quantity) AS total_borrowed,
       SUM(bd.quantity * d.price) AS total_value
FROM devices d
JOIN borrow_details bd ON bd.device_id = d.device_id
GROUP BY d.category
HAVING SUM(bd.quantity) >= 2
ORDER BY total_borrowed DESC;
```

Một dòng chi tiết có quantity = 2 nghĩa là mượn hai thiết bị. Vì vậy SUM(quantity) đúng; COUNT(*) chỉ đếm một dòng. Kết quả mẫu: Phụ kiện 5 / 12.850.000; Laptop 3 / 54.200.000; Màn hình 2 / 7.800.000.

## Mẫu 2: lượt confirmed và doanh thu — câu 3.1 đề 02

Ref bài 3 + bài 8. Chạy trên `week7_workshop`.

```sql
SELECT w.topic,
       COUNT(r.reg_id) AS total_confirmed,
       SUM(w.fee) AS total_revenue
FROM workshops w
JOIN registrations r ON r.workshop_id = w.workshop_id
WHERE r.status = 'confirmed'
GROUP BY w.topic
HAVING COUNT(r.reg_id) >= 2
ORDER BY total_confirmed DESC;
```

WHERE loại cancelled trước khi đếm/cộng. Một workshop có hai confirmed thì fee cộng hai lần. Không dùng SUM(DISTINCT fee). Kết quả mẫu: Database 3 / 1.700.000; Front-end 2 / 800.000; Web 2 / 800.000.

## Mẫu 3: số chỗ còn lại — câu 2.1 đề 02

Ref bài 12. Query nằm trong PDO prepare; placeholder `:id` nhận workshop_id từ execute.

```sql
SELECT w.workshop_id, w.title, w.capacity,
       COUNT(r.reg_id) AS confirmed,
       w.capacity - COUNT(r.reg_id) AS remaining
FROM workshops w
LEFT JOIN registrations r ON r.workshop_id = w.workshop_id
                         AND r.status = 'confirmed'
WHERE w.workshop_id = :id
GROUP BY w.workshop_id, w.title, w.capacity;
```

Đặt status trong **ON** để workshop không có confirmed vẫn xuất hiện. Đặt status trong WHERE sẽ loại dòng NULL do LEFT JOIN tạo ra. Dùng COUNT(r.reg_id), không COUNT(*), để workshop chưa có đăng ký được đếm là 0. Với ID 4: confirmed = 0, remaining = 18; ID 5: confirmed = 2, remaining = 20.

## Mẫu 4: cao nhất từng nhóm và giữ đồng hạng

Ref bài 5. Trong Lab 5, giá đã là thuộc tính của mỗi sản phẩm nên có thể so trực tiếp với MAX(price). Trong đề, phải **tính tổng lượt của từng đối tượng trước**, rồi tìm MAX của các tổng trong cùng nhóm.

```sql
-- Bước 1: tính tổng từng thiết bị, kể cả chưa được mượn.
SELECT d.device_id, d.category, d.device_name,
       COALESCE(SUM(bd.quantity), 0) AS total_borrowed
FROM devices d
LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
GROUP BY d.device_id, d.category, d.device_name;
```

Bảng con `totals` và `in_group` bên dưới là **tên tạm trong truy vấn**, không phải bảng cần tạo/import. Hai lần viết phần tổng hợp giúp truy vấn chạy bằng subquery mà không cần CTE/window function.

```sql
SELECT totals.category, totals.device_name, totals.total_borrowed
FROM (
    SELECT d.device_id, d.category, d.device_name,
           COALESCE(SUM(bd.quantity), 0) AS total_borrowed
    FROM devices d
    LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
    GROUP BY d.device_id, d.category, d.device_name
) AS totals
WHERE totals.total_borrowed = (
    SELECT MAX(in_group.total_borrowed)
    FROM (
        SELECT d.device_id, d.category, d.device_name,
               COALESCE(SUM(bd.quantity), 0) AS total_borrowed
        FROM devices d
        LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
        GROUP BY d.device_id, d.category, d.device_name
    ) AS in_group
    WHERE in_group.category = totals.category
)
ORDER BY totals.category, totals.device_name;
```

- `in_group.category = totals.category` giới hạn MAX vào đúng loại của dòng đang xét.
- So sánh bằng `=` giữ mọi đối tượng đồng hạng.
- `ORDER BY tổng DESC LIMIT 1` trên toàn bảng chỉ ra một đối tượng, không đáp ứng “mỗi loại”.
- Đề 02 thay bảng/khóa bằng workshops/registrations, nhóm topic và COUNT(reg_id), với status confirmed trong ON. Xem [SQL đề 02](../NguyenTanSang2/queries.sql) để đối chiếu đầy đủ.

## Hiển thị truy vấn bằng PHP

Ref các bài Lab 5; `$conn` phải là PDO đã kết nối đúng schema. `$sql` là câu SQL bạn chọn ở trên.

```php
$stmt = $conn->prepare($sql);
$stmt->execute(); // Query không nhận đầu vào thì không cần params.
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $row) {
    echo htmlspecialchars((string) $row['category'], ENT_QUOTES, 'UTF-8').'<br>';
}
```

Nếu query dùng `:id`, execute phải truyền `['id' => $workshopId]`. Key xuất HTML phải khớp cột/alias SELECT; ví dụ query workshop có `topic`, không có `category`.

## Tự luyện

1. Giải thích vì sao Trình chiếu không xuất hiện trong thống kê đề 01: tổng 1 < 2.
2. Đề 02 topic Web có hai workshop cùng 1 confirmed: kết quả cao nhất phải có cả hai.
3. Thêm một loại hoàn toàn chưa có lượt: LEFT JOIN + COALESCE phải cho tổng 0.
4. Nhớ GROUP BY các cột không aggregate trong SELECT để chạy với ONLY_FULL_GROUP_BY; không chữa lỗi bằng tắt chế độ này.

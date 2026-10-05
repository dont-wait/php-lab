# Đăng ký workshop

CSDL `week7_workshop`. Xem [cách chạy chung](../README.md#chạy-bài); mở `index.html` qua localhost để chọn câu.

## Câu hỏi, bài giải và lab liên quan

| Câu | File bài giải | Tham chiếu lab | Kiến thức và cách áp dụng |
| --- | --- | --- | --- |
| 1.1 | [register_form.php](register_form.php) | [Lab 1 bài 10](../../lab1/bai10/info_process.php), [bài 17](../../lab1/bai17/uppercase.php) | POST, trim, kiểm tra tên và email phía PHP; xuất bằng escape. Câu này chỉ hiển thị lại, không lưu sinh viên vào DB. |
| 1.2 | [Workshop.php](Workshop.php), [workshop_demo.php](workshop_demo.php) | [Lab 2 bài 2](../../lab2/bai2.php), [bài 6](../../lab2/bai6/BankAccount.php), [bài 7](../../lab2/bai7/Book.php) | private, constructor, getter, showInfo; `getDiscountedFee(percent) = fee × (1 − percent/100)`. |
| 1.3 | [fee_calculator.html](fee_calculator.html), [JS](fee_calculator.js) | [Lab 3 DOM](../../lab3/bai2/index.js), [validation](../../lab3/bai3/index.js) | Event, Number, Number.isFinite, kiểm tra rỗng/số không âm/0–100; hiển thị kết quả bằng textContent không tải lại. |
| 1.4 | [list_workshops.php](list_workshops.php) | [Lab 4 danh sách](../../lab4/bai1/list_students.php), [PDO](../../lab4/bai1/connect.php) | GET topic, Prepared Statement, xuất đủ workshop_id/title/topic/fee/capacity an toàn. |
| 2.1 | [availability_form.php](availability_form.php), [JS](availability.js), [availability.php](availability.php) | [Lab 3 Fetch](../../lab3/bai7/index.js), [JSON](../../lab3/bai7/search.php), [Lab 4 PDO](../../lab4/bai1/list_students.php), [Lab 5 COUNT/LEFT JOIN](../../lab5/buoi5/bai12.php) | Chọn workshop từ DB; Fetch gửi ID; PDO đếm confirmed, tính remaining; JSON trả đúng 5 trường; remaining ≤ 0 báo “Đã đủ chỗ”. |
| 3.1 | [statistics.php](statistics.php), [queries.sql](queries.sql) | [Lab 5 GROUP BY/HAVING](../../lab5/buoi5/bai3.php), [doanh thu theo nhóm](../../lab5/buoi5/bai8.php) | WHERE status confirmed trước khi GROUP BY topic; COUNT lượt, SUM(fee); HAVING ≥ 2; giảm dần theo số lượt. |
| 3.2 | [top_per_topic.php](top_per_topic.php), [queries.sql](queries.sql) | [Lab 5 MAX từng nhóm](../../lab5/buoi5/bai5.php), [tổng từng đối tượng](../../lab5/buoi5/bai9.php), [COUNT](../../lab5/buoi5/bai12.php) | Tổng confirmed từng workshop; MAX trong cùng topic; giữ mọi đồng hạng. |
| 3.3 | [register_student.php](register_student.php) | [Lab 3 SELECT trước INSERT](../../lab3/bai12/register.php), [Lab 4 PDO INSERT](../../lab4/bai1/add_student.php) | Prepared SELECT với hai ID; có bản ghi thì thông báo, chưa có mới Prepared INSERT. Ví dụ Lab 3 dùng mysqli; câu này dùng PDO theo đề. |

## Kết quả mẫu để tự kiểm tra

- 1.1: tên rỗng/email sai bị từ chối; dữ liệu chứa ký tự HTML được xuất an toàn.
- 1.2–1.3: học phí 350.000, giảm 10% → **315.000**; giảm 0% → 350.000; giảm 100% → 0. Không chấp nhận số âm, phần trăm > 100, chuỗi rỗng hoặc giá trị không phải số.
- 1.4: `?topic=Web` → 2 dòng; không nhập topic → 6 dòng.
- 2.1: `availability.php?workshop_id=5` → `{"workshop_id":5,"title":"MySQL PDO","capacity":22,"confirmed":2,"remaining":20}`. ID 4 có 1 cancelled nhưng confirmed = 0, remaining = 18. ID âm/chuỗi → HTTP 400; ID không tồn tại → HTTP 404. Nếu confirmed bằng/vượt capacity, giữ remaining = capacity − confirmed và hiển thị “Đã đủ chỗ”.

Câu 3.1:

| topic | total_confirmed | total_revenue |
| --- | ---: | ---: |
| Database | 3 | 1.700.000 |
| Front-end | 2 | 800.000 |
| Web | 2 | 800.000 |

Phải SUM(fee) **theo từng lượt đăng ký confirmed**. Một workshop có hai lượt thì phí của workshop đó được cộng hai lần; không dùng SUM(DISTINCT fee).

Câu 3.2:

| topic | title | total_confirmed |
| --- | --- | ---: |
| Database | MySQL PDO | 2 |
| Front-end | JavaScript DOM | 2 |
| Web | OOP with PHP | 1 |
| Web | PHP Web Basics | 1 |

Web có đồng hạng nên phải xuất hai dòng. Điều kiện confirmed nằm trong `ON` của LEFT JOIN để workshop chưa có confirmed vẫn có tổng 0. `COUNT(r.reg_id)` không đếm dòng rỗng của LEFT JOIN; `COUNT(*)` sẽ đếm sai thành 1. Khi một topic chưa có confirmed, mọi workshop thuộc topic đó đồng hạng 0.

Câu 3.3: thử student_id = 1, workshop_id = 1 → thông báo đã đăng ký, số dòng không tăng. Thử 2/4 → cũng bị chặn vì đã có bản ghi cancelled. Thử 1/2 → thêm một dòng confirmed; gửi lại 1/2 → không thêm. Các lần thêm mới làm thay đổi kết quả thống kê, vì vậy đối chiếu bảng mẫu trước khi thử INSERT.

Đoạn SELECT trước INSERT đáp ứng bài kiểm tra theo luồng tuần tự. Trong ứng dụng có nhiều yêu cầu đồng thời, hai yêu cầu có thể cùng vượt qua SELECT; khi triển khai thực tế cần thêm UNIQUE(student_id, workshop_id) và xử lý lỗi trùng. Bài ôn giữ nguyên schema đề cung cấp.

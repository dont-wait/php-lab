# Lab 3 — JavaScript, DOM, Fetch và JSON

Ứng dụng trong đề: **câu 1.3** và phần giao tiếp của **câu 2.1**; nguyên tắc kiểm tra trùng trong **3.3 đề 02**.

## Bài gốc nên xem

| Bài | File | Kiến thức |
| --- | --- | --- |
| 1 | [index.html](../../lab3/bai1/index.html) | Biến, điều kiện, DOM cơ bản |
| 2 | [index.js](../../lab3/bai2/index.js) | Đổi nền, hiển thị input, thêm li vào ul |
| 3 | [index.js](../../lab3/bai3/index.js) | Email validation, đồng hồ setInterval |
| 4 | [JS](../../lab3/bai4/index.js), [PHP](../../lab3/bai4/time.php) | Fetch lấy giờ từ PHP |
| 5 | [JS](../../lab3/bai5/index.js), [PHP](../../lab3/bai5/hello.php) | POST FormData và nhận text |
| 6 | [index.html](../../lab3/bai6/index.html), [products.json](../../lab3/bai6/products.json) | Đọc JSON và hiển thị bảng |
| 7 | [JS](../../lab3/bai7/index.js), [PHP](../../lab3/bai7/search.php) | Tìm bằng Fetch GET, PHP lọc mảng trả JSON |
| 8 | [JS](../../lab3/bai8/index.js), [PHP](../../lab3/bai8/chat.php) | Gửi tin nhắn và lưu file |
| 9 | [JS](../../lab3/bai9/index.js), [PHP](../../lab3/bai9/weather.php) | Dữ liệu thời tiết mẫu cục bộ theo thành phố |
| 10 | [JS](../../lab3/bai10/index.js), [PHP](../../lab3/bai10/todo.php) | Todo create/toggle/delete, lưu JSON |
| 11 | [JS](../../lab3/bai11/index.js), [API](../../lab3/bai11/api.php) | PHP gọi API tỷ giá bên ngoài; cần Internet |
| 12 | [JS](../../lab3/bai12/index.js), [PHP](../../lab3/bai12/register.php) | POST JSON, kiểm tra tài khoản trùng, password_hash, mysqli |

## Mẫu 1: DOM/Event thêm phần tử

Ref bài 2. Lưu thành `dom.html`; form submit xử lý cả nút bấm và phím Enter.

```html
<!doctype html>
<meta charset="utf-8">
<form id="form">
    <input id="name" placeholder="Tên thiết bị">
    <button>Thêm</button>
</form>
<p id="message"></p>
<ul id="list"></ul>
<script>
document.getElementById('form').addEventListener('submit', (event) => {
    event.preventDefault(); // Ngăn form tải lại trang.
    const input = document.getElementById('name');
    const name = input.value.trim();
    const message = document.getElementById('message');
    if (name === '') { message.textContent = 'Tên không được rỗng.'; return; }
    const li = document.createElement('li');
    li.textContent = name; // Dữ liệu người dùng là chữ, không phải HTML.
    document.getElementById('list').appendChild(li);
    input.value = '';
    message.textContent = '';
});
</script>
```

Ôn tính học phí: lấy `Number(input.value)`, kiểm tra chuỗi rỗng riêng, dùng `Number.isFinite`, fee ≥ 0 và percent trong 0–100. `Number('')` là 0 nên không được bỏ kiểm tra chuỗi rỗng.

## Mẫu 2: Fetch GET → PHP JSON → DOM

Ghép bài 7 với cách xuất DOM an toàn. Hai file dưới đặt **cùng thư mục**, mở `search.html` qua PHP server.

`search.html`:

```html
<!doctype html>
<meta charset="utf-8">
<form id="search-form"><input id="keyword"><button>Tìm</button></form>
<p id="message"></p>
<ul id="results"></ul>
<script>
document.getElementById('search-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const message = document.getElementById('message');
    const list = document.getElementById('results');
    list.replaceChildren();
    const params = new URLSearchParams({keyword: document.getElementById('keyword').value.trim()});
    try {
        const response = await fetch('search.php?' + params);
        const data = await response.json();
        if (!response.ok) throw new Error(data.error || 'Yêu cầu thất bại.');
        message.textContent = data.length ? 'Có ' + data.length + ' kết quả.' : 'Không có dữ liệu.';
        for (const item of data) {
            const li = document.createElement('li');
            li.textContent = item.name;
            list.appendChild(li);
        }
    } catch (error) {
        message.textContent = 'Lỗi: ' + error.message;
    }
});
</script>
```

`search.php`:

```php
<?php
header('Content-Type: application/json; charset=utf-8');
$keyword = is_string($_GET['keyword'] ?? null) ? trim($_GET['keyword']) : '';
$items = [['name' => 'Laptop'], ['name' => 'Webcam']];
$result = array_filter($items, fn ($item) => stripos($item['name'], $keyword) !== false);
// array_filter giữ key cũ; array_values giúp JSON vẫn là mảng [] thay vì object {}.
echo json_encode(array_values($result), JSON_UNESCAPED_UNICODE);
```

Khi chuyển sang câu 2.1, thay phần lọc mảng bằng **PDO của Lab 4**, giữ nguyên luồng Fetch/JSON. Đề 02 còn cần COUNT/LEFT JOIN của Lab 5 để tính số chỗ.

## POST FormData và POST JSON khác nhau

Ref bài 5 và bài 12. Các đoạn JS chạy trong hàm async; chọn một cách theo endpoint đang dùng.

```js
async function sendForm() {
    const form = new FormData();
    form.append('name', 'Sang');
    const response = await fetch('hello.php', {method: 'POST', body: form});
    return await response.text(); // PHP hello.php trả text.
}
// PHP nhận bằng $_POST['name'].
```

```js
async function sendJson() {
    const response = await fetch('register.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({username: 'sang', email: 'sang@example.com', password: '123456'})
    });
    return await response.json();
}
// PHP: $data = json_decode(file_get_contents('php://input'), true);
```

Không tự đặt Content-Type khi gửi FormData; trình duyệt thêm multipart boundary. Gửi JSON thì PHP không đọc dữ liệu từ $_POST như form thông thường.

## Lỗi dễ gặp và tự luyện

- `id` trong HTML phải khớp `getElementById`; nạp script sau HTML hoặc dùng defer.
- `fetch` không tự throw khi HTTP 400/500: cần kiểm tra `response.ok`.
- PHP không được echo thông báo kết nối trước JSON.
- Mở qua `file://` không chạy được PHP; dùng localhost.
- Bài 1 gốc có `innnerText` sai chính tả và gán innerHTML vào vùng chứa input; nên dùng bài 2 để ôn DOM và giữ input không bị thay thế.

Tự luyện: thêm hai tên rồi thử chuỗi rỗng; từ khóa `Web` phải ra Webcam; `xyz` không có dữ liệu. Thay endpoint bằng tên không tồn tại để xem thông báo lỗi. Với tên `<b>Webcam</b>`, DOM phải hiển thị nguyên văn, không in đậm.

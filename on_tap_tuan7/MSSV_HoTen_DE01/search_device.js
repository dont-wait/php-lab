// Câu 2.1 — Ref: lab3/bai7/index.js; thêm kiểm tra HTTP/lỗi và DOM an toàn.
let requestVersion = 0;
document.getElementById('search-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const version = ++requestVersion; // Chỉ hiển thị kết quả của lần tìm mới nhất.
    const message = document.getElementById('message');
    const results = document.getElementById('results');
    results.replaceChildren();
    message.textContent = 'Đang tìm...';
    const params = new URLSearchParams({
        keyword: document.getElementById('keyword').value.trim(),
        max_price: document.getElementById('max-price').value.trim()
    });
    try {
        const response = await fetch('search_device.php?' + params);
        const data = await response.json();
        if (!response.ok) throw new Error(data.error || 'Yêu cầu thất bại.');
        if (version !== requestVersion) return;
        message.textContent = data.length ? 'Tìm thấy ' + data.length + ' thiết bị.' : 'Không có dữ liệu.';
        for (const device of data) {
            const tr = document.createElement('tr');
            for (const key of ['device_id', 'device_name', 'category', 'price', 'stock']) {
                const td = document.createElement('td');
                td.textContent = device[key]; // Không đưa dữ liệu DB vào innerHTML.
                tr.appendChild(td);
            }
            results.appendChild(tr);
        }
    } catch (error) {
        if (version === requestVersion) message.textContent = 'Lỗi: ' + error.message;
    }
});

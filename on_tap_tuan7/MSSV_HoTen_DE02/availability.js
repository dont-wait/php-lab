// Câu 2.1 — Ref: lab3/bai7/index.js (Fetch -> JSON -> DOM).
let requestVersion = 0;
document.getElementById('availability-form').addEventListener('submit', async (event) => {
    event.preventDefault();
    const version = ++requestVersion;
    const result = document.getElementById('result');
    result.textContent = 'Đang kiểm tra...';
    try {
        const params = new URLSearchParams({workshop_id: document.getElementById('workshop-id').value});
        const response = await fetch('availability.php?' + params);
        const data = await response.json();
        if (!response.ok) throw new Error(data.error || 'Yêu cầu thất bại.');
        if (version !== requestVersion) return;
        result.textContent = data.title + ' — Sức chứa: ' + data.capacity +
            ', đã xác nhận: ' + data.confirmed + ', còn lại: ' + data.remaining +
            (data.remaining <= 0 ? ' — Đã đủ chỗ' : ' — Còn chỗ');
    } catch (error) {
        if (version === requestVersion) result.textContent = 'Lỗi: ' + error.message;
    }
});

// Câu 1.3 — Ref: lab3/bai2/index.js (DOM); lab3/bai3/index.js (validation).
document.getElementById('fee-form').addEventListener('submit', (event) => {
    event.preventDefault();
    const feeText = document.getElementById('fee').value.trim();
    const percentText = document.getElementById('percent').value.trim();
    const fee = Number(feeText);
    const percent = Number(percentText);
    const result = document.getElementById('result');
    // Number('') là 0 nên phải kiểm tra chuỗi rỗng trước.
    if (feeText === '' || percentText === '' || !Number.isFinite(fee) ||
        !Number.isFinite(percent) || fee < 0 || percent < 0 || percent > 100) {
        result.textContent = 'Học phí phải không âm, phần trăm phải từ 0 đến 100.';
        return;
    }
    result.textContent = 'Sau giảm: ' + (fee * (1 - percent / 100)).toLocaleString('vi-VN') + ' đồng.';
});

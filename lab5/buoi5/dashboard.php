<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Buổi 5 - Nguyễn Tấn Sang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
            text-align: center;
            padding: 40px;
        }
        h1 {
            color: #333;
        }
        .menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .card {
            background-color: #007bff;
            color: white;
            width: 260px;
            padding: 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
        }
        .card:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .desc {
            font-size: 15px;
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <h1>💻 Dashboard Buổi 5 - Lab 3 Shop</h1>
    <p>Người thực hiện: <strong>Nguyễn Tấn Sang</strong></p>
    <div class="menu">
        <a href="bai1.php" class="card">
            <div class="title">Bài 1</div>
            <div class="desc">Thống kê số lượng sản phẩm trong từng loại hàng</div>
        </a>
        <a href="bai2.php" class="card">
            <div class="title">Bài 2</div>
            <div class="desc">Tính tổng doanh thu từng ngày</div>
        </a>
        <a href="bai3.php" class="card">
            <div class="title">Bài 3</div>
            <div class="desc">Tìm loại hàng có trên 5 sản phẩm</div>
        </a>
        <a href="bai4.php" class="card">
            <div class="title">Bài 4</div>
            <div class="desc">Danh sách khách hàng và tổng tiền đã mua</div>
        </a>
        <a href="bai5.php" class="card">
            <div class="title">Bài 5</div>
            <div class="desc">Tìm sản phẩm có giá cao nhất trong từng loại hàng</div>
        </a>
        <a href="bai6.php" class="card">
            <div class="title">Bài 6</div>
            <div class="desc">Liệt kê sản phẩm chưa từng được đặt hàng</div>
        </a>
        <a href="bai7.php" class="card">
            <div class="title">Bài 7</div>
            <div class="desc">Khách hàng mua nhiều sản phẩm nhất</div>
        </a>
        <a href="bai8.php" class="card">
            <div class="title">Bài 8</div>
            <div class="desc">Thống kê tổng số lượng và doanh thu của từng loại sản phẩm. </div>
        </a>
        <a href="bai9.php" class="card">
            <div class="title">Bài 9</div>
            <div class="desc">Tìm 3 sản phẩm bán chạy nhất (theo số lượng bán ra). </div>
        </a>
        <a href="bai10.php" class="card">
            <div class="title">Bài 10</div>
            <div class="desc">Liệt kê 5 khách hàng chi tiêu nhiều nhất. </div>
        </a>
        <a href="bai11.php" class="card">
            <div class="title">Bài 11</div>
            <div class="desc">Tìm loại hàng có doanh thu cao nhất. </div>
        </a>
        <a href="bai12.php" class="card">
            <div class="title">Bài 12</div>
            <div class="desc">Liệt kê tất cả sản phẩm và số lần được đặt hàng (nếu chưa đặt thì là 0) </div>
        </a>
    </div>
</body>
</html>

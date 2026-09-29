<?php 
    require 'connect.php';
    echo "<h1>Bài 2 - Doanh thu theo ngày</h1>";
    echo "<p>Người thực hiện: <strong>Nguyễn Tấn Sang</strong></p>";
    $sql = "SELECT o.order_date, sum(od.quantity * od.price) AS total_revenue  
            FROM orders o
            JOIN order_detail od ON o.order_id = od.order_id
            GROUP BY o.order_date";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Ngày đặt hàng </th><th> Doanh thu </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_revenue']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
?>
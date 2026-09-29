<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 9 - Top 3 sản phẩm bán chạy');
    $sql = "select p.product_id, p.name, sum(od.quantity) as total_sold
            from products p
            join order_detail od on p.product_id = od.product_id
            group by p.product_id, p.name
            order by total_sold DESC
            limit 3";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Mã sản phẩm </th><th> Tên sản phẩm </th><th> Tổng số lượng đã bán </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_sold']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
?>
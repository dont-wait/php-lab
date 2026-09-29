<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 11 - Loại hàng có doanh thu cao nhất');
    $sql = " select c.category_name, p.name, p.price, sum(od.quantity * od.price) as total_revenue
            from categories c
            join products p on c.category_id = p.category_id
            join order_detail od on p.product_id = od.product_id
            join orders o on od.order_id = o.order_id
            group by c.category_name, p.name, p.price
            order by total_revenue DESC
            limit 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Loại hàng </th><th> Tên sản phẩm </th><th> Giá sản phẩm </th><th> Tổng doanh thu cao nhất </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_revenue']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
?>
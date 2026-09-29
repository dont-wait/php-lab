<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 8 - Doanh thu theo loại sản phẩm');
    $sql = "select c.category_name,
                sum(od.quantity) as total_quantity,
                sum(od.quantity * od.price) as total_revenue
            from categories c
            join products p on c.category_id = p.category_id
            join order_detail od on p.product_id = od.product_id
            join orders o on od.order_id = o.order_id
            group by  c.category_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Loại hàng </th><th> Tổng số lượng sản phẩm đã bán </th><th> Tổng doanh thu </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_quantity']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_revenue']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
?>
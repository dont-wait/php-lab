<?php 
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 12 - Số lần sản phẩm được đặt hàng');
    $sql = "select p.product_id, p.name, count(od.order_id) as total_orders
            from products p
            left join order_detail od on p.product_id = od.product_id
            group by p.product_id, p.name
            having total_orders > 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Mã sản phẩm </th><th> Tên sản phẩm </th><th> Tổng số đơn hàng </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_orders']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";

?>
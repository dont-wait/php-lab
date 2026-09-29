<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 10 - Khách hàng chi tiêu nhiều nhất');
    $sql = "select c.customer_id, c.name, sum(od.quantity * od.price) as total_spent
            from customers c
            join orders o on c.customer_id = o.customer_id
            join order_detail od on o.order_id = od.order_id
            group by c.customer_id, c.name
            order by total_spent DESC
            limit 2";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Mã khách hàng </th><th> Tên khách hàng </th><th> Tổng tiền đã chi tiêu </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_spent']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
?>
<?php 
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 6 - Sản phẩm chưa được đặt hàng');
    $sql = "SELECT p.product_id, p.name
            from products p
            left join order_detail od on p.product_id = od.product_id
            where od.order_id is null";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Mã sản phẩm </th><th> Tên sản phẩm </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['product_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
?>
<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 1 - Thống kê sản phẩm theo loại hàng');
    $sql = "SELECT c.category_name, COUNT(p.product_id) AS total_products
            FROM categories c
            LEFT JOIN products p ON c.category_id = p.category_id
            GROUP BY c.category_name";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Loại hàng </th><th> số lượng sản phẩm </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total_products']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "</main>";
            
?>
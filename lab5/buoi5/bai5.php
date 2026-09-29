<?php
    require 'connect.php';
    require 'layout.php';
    renderPageHeader('Bài 5 - Sản phẩm có giá cao nhất');
    $sql = "SELECT c.category_name, p.name, p.price
            from products p
            join categories c on p.category_id = c.category_id
            where p.price = (
                select max(p2.price)
                from products p2
                where p2.category_id = p.category_id
            )";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    echo "<table border = '1', cellpadding = '10', cellspacing = '0'>";
    echo "<tr><th> Loại hàng </th><th> Tên sản phẩm </th><th> Giá sản phẩm </th></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['price']) . "</td>";
        echo "</tr>";
    }   
    echo "</table>";
    echo "</main>";
?>
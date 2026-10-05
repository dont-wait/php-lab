-- Câu 3.1: Lab 5 bài 3, 8 — JOIN, GROUP BY, SUM/COUNT, HAVING.
SELECT d.category, SUM(bd.quantity) AS total_borrowed,
       SUM(bd.quantity * d.price) AS total_value
FROM devices d
JOIN borrow_details bd ON bd.device_id = d.device_id
GROUP BY d.category
HAVING SUM(bd.quantity) >= 2
ORDER BY total_borrowed DESC, d.category;

-- Câu 3.2: Lab 5 bài 5, 9, 12 — tổng theo từng đối tượng, MAX trong từng nhóm.
SELECT totals.category, totals.device_name, totals.total_borrowed
FROM (
    SELECT d.device_id, d.category, d.device_name,
           COALESCE(SUM(bd.quantity), 0) AS total_borrowed
    FROM devices d
    LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
    GROUP BY d.device_id, d.category, d.device_name
) AS totals
WHERE totals.total_borrowed = (
    SELECT MAX(in_group.total_borrowed)
    FROM (
        SELECT d.device_id, d.category, d.device_name,
           COALESCE(SUM(bd.quantity), 0) AS total_borrowed
    FROM devices d
    LEFT JOIN borrow_details bd ON bd.device_id = d.device_id
    GROUP BY d.device_id, d.category, d.device_name
    ) AS in_group
    WHERE in_group.category = totals.category
)
ORDER BY totals.category, totals.device_name;

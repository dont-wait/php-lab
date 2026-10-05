-- Câu 3.1: Lab 5 bài 3, 8 — JOIN, GROUP BY, SUM/COUNT, HAVING.
SELECT w.topic, COUNT(r.reg_id) AS total_confirmed,
       SUM(w.fee) AS total_revenue
FROM workshops w
JOIN registrations r ON r.workshop_id = w.workshop_id
WHERE r.status = 'confirmed'
GROUP BY w.topic
HAVING COUNT(r.reg_id) >= 2
ORDER BY total_confirmed DESC, w.topic;

-- Câu 3.2: Lab 5 bài 5, 9, 12 — tổng theo từng đối tượng, MAX trong từng nhóm.
SELECT totals.topic, totals.title, totals.total_confirmed
FROM (
    SELECT w.workshop_id, w.topic, w.title,
           COUNT(r.reg_id) AS total_confirmed
    FROM workshops w
    LEFT JOIN registrations r ON r.workshop_id = w.workshop_id
                             AND r.status = 'confirmed'
    GROUP BY w.workshop_id, w.topic, w.title
) AS totals
WHERE totals.total_confirmed = (
    SELECT MAX(in_group.total_confirmed)
    FROM (
        SELECT w.workshop_id, w.topic, w.title,
           COUNT(r.reg_id) AS total_confirmed
    FROM workshops w
    LEFT JOIN registrations r ON r.workshop_id = w.workshop_id
                             AND r.status = 'confirmed'
    GROUP BY w.workshop_id, w.topic, w.title
    ) AS in_group
    WHERE in_group.topic = totals.topic
)
ORDER BY totals.topic, totals.title;

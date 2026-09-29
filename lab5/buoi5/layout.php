<?php
function renderPageHeader(string $title): void
{
    echo "<style>
        body { margin: 0; padding: 40px 20px; background: #eef3f8; color: #1f2937; font-family: Arial, sans-serif; }
        .page { max-width: 980px; margin: 0 auto; }
        h1 { margin: 0 0 8px; color: #123b5d; }
        .author { margin: 0 0 24px; color: #52616b; }
        table { width: 100%; border-collapse: collapse; overflow: hidden; background: #ffffff; box-shadow: 0 8px 24px rgba(18, 59, 93, 0.12); }
        th { padding: 14px 16px; background: #123b5d; color: #ffffff; text-align: left; }
        td { padding: 13px 16px; border-bottom: 1px solid #dbe4ec; }
        tr:nth-child(even) td { background: #f7fafc; }
        tr:hover td { background: #e2f0f7; }
    </style>
    <main class='page'>
        <h1>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</h1>
        <p class='author'>Người thực hiện: <strong>Nguyễn Tấn Sang</strong></p>";
}
?>

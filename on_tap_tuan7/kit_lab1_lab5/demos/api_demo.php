<?php
require dirname(__DIR__).'/bootstrap.php';
require __DIR__.'/layout.php';
page('Fetch GET/POST và JSON');
?>
<meta name="csrf-token" content="<?= LabKit\escape(LabKit\csrfToken()) ?>">
<form id="search"><label>Tên chứa <input id="keyword"></label><button>Tìm thiết bị (GET)</button></form>
<ul id="devices"></ul>
<form id="send"><label>Tên <input id="name" required></label><button>Gửi JSON (POST)</button></form>
<p id="message" role="status"></p>
<script src="api_demo.js"></script>
<?php endPage(); ?>

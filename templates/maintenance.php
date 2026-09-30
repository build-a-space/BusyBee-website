<?php $s = load_settings(); ?><!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex">
<title><?= e($s['maintenance_title']) ?> | <?= e($s['business_name']) ?></title>
<link rel="icon" href="<?= e($s['favicon']) ?>">
<style>
body{margin:0;min-height:100vh;display:grid;place-items:center;background:#141414;color:#fff;font:16px/1.6 system-ui,-apple-system,Segoe UI,Roboto,sans-serif;text-align:center;padding:24px}
.box{max-width:560px}img{max-width:320px;width:100%;height:auto}h1{color:<?= e($s['color_primary']) ?>;font-size:2rem;margin:.5em 0}
a.btn{display:inline-block;background:<?= e($s['color_primary']) ?>;color:#141414;font-weight:700;padding:14px 26px;border-radius:999px;text-decoration:none;margin-top:12px}
p{color:#ddd}
</style></head>
<body><div class="box">
<img src="<?= e($s['logo']) ?>" alt="<?= e($s['business_name']) ?>" width="320" height="175">
<h1><?= e($s['maintenance_title']) ?></h1>
<p><?= nl2br(e($s['maintenance_text'])) ?></p>
<a class="btn" href="<?= e(tel_href($s['phone'])) ?>">Call <?= e($s['phone']) ?></a>
<p><a style="color:#fff" href="mailto:<?= e($s['email']) ?>"><?= e($s['email']) ?></a></p>
</div></body></html>

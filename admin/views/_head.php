<?php $s = load_settings(); ?><!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?= e($adminTitle ?? 'Dashboard') ?> · <?= e($s['short_name']) ?> Admin</title>
<link rel="icon" href="<?= e($s['favicon']) ?>">
<style>
:root{--y:#FFD600;--ink:#141414;--line:#e5e2d6;--bg:#f6f5f0;--muted:#666;--red:#b00020;--green:#11602a}
*{box-sizing:border-box}body{margin:0;font:15px/1.55 system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;background:var(--bg);color:#1d1d1d}
a{color:#7a5a00}h1,h2,h3{line-height:1.2;margin:0 0 .6em}h1{font-size:1.6rem}h2{font-size:1.2rem}
.shell{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
.side{background:var(--ink);color:#ddd;padding:20px 14px;position:sticky;top:0;height:100vh;overflow:auto}
.side img{width:150px;margin:0 auto 16px;display:block}
.side a{display:flex;align-items:center;gap:8px;color:#ddd;text-decoration:none;padding:9px 12px;border-radius:8px;font-weight:600;margin-bottom:2px}
.side a:hover{background:#262626}.side a.on{background:var(--y);color:var(--ink)}
.side .badge{margin-left:auto;background:var(--red);color:#fff;border-radius:999px;font-size:.72rem;padding:1px 7px}
.side hr{border:0;border-top:1px solid #333;margin:12px 0}
.main{padding:28px 32px;max-width:1150px}
.card{background:#fff;border:1px solid var(--line);border-radius:14px;padding:22px;margin-bottom:20px}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:14px}
.grid2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
label{display:block;font-weight:600;font-size:.86rem;margin-bottom:12px}
input[type=text],input[type=email],input[type=password],input[type=url],input[type=tel],input[type=date],input[type=number],textarea,select{display:block;width:100%;margin-top:4px;padding:9px 11px;border:1.5px solid #d8d4c4;border-radius:9px;font:inherit;background:#fff}
textarea{min-height:90px;font-family:inherit}textarea.code{font-family:ui-monospace,Menlo,monospace;font-size:.85rem}
input:focus,textarea:focus{outline:none;border-color:#e0a800;box-shadow:0 0 0 3px rgba(255,214,0,.35)}
.check{display:flex;align-items:center;gap:8px;font-weight:600}
.btn{display:inline-flex;align-items:center;gap:6px;background:var(--y);color:var(--ink);border:2px solid var(--ink);padding:9px 18px;border-radius:999px;font-weight:700;cursor:pointer;text-decoration:none;font-size:.92rem}
.btn.dark{background:var(--ink);color:#fff}.btn.red{background:var(--red);color:#fff;border-color:var(--red)}.btn.sm{padding:5px 12px;font-size:.82rem}
.btn.green{background:var(--green);color:#fff;border-color:var(--green)}
.flash{padding:12px 16px;border-radius:10px;margin-bottom:18px;font-weight:600}
.flash.success{background:#e8f7ec;color:var(--green);border:1px solid #9fd8ae}.flash.error{background:#fdecec;color:var(--red);border:1px solid #f1a9a9}
.muted{color:var(--muted);font-size:.88rem}
.status{display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
.pill{display:inline-block;padding:4px 12px;border-radius:999px;font-weight:700;font-size:.85rem}
.pill.on{background:#e8f7ec;color:var(--green)}.pill.off{background:#fdecec;color:var(--red)}
.stats{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:20px}
.stat{background:#fff;border:1px solid var(--line);border-radius:14px;padding:18px}.stat b{display:block;font-size:1.8rem}
table{width:100%;border-collapse:collapse;font-size:.9rem}th,td{text-align:left;padding:9px 8px;border-bottom:1px solid var(--line);vertical-align:top}
th{font-size:.78rem;text-transform:uppercase;color:var(--muted)}
.thumbs{display:grid;grid-template-columns:repeat(auto-fill,minmax(150px,1fr));gap:12px}
.thumb{border:1px solid var(--line);border-radius:10px;padding:8px;background:#fff;font-size:.75rem;word-break:break-all}
.thumb img{width:100%;height:110px;object-fit:contain;background:#f0efe8;border-radius:6px;margin-bottom:6px}
.preview{max-width:240px;max-height:130px;background:#333;border-radius:8px;padding:8px;display:block;margin:6px 0}
.msg.unread{background:#fffbe6}
details.edit summary{cursor:pointer;font-weight:600}
.topbar{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:10px}
.login{min-height:100vh;display:grid;place-items:center;background:var(--ink);padding:20px}
.login .card{width:100%;max-width:400px}.login img{width:220px;margin:0 auto 12px;display:block}
.menu-btn{display:none}
@media(max-width:860px){.shell{grid-template-columns:1fr}.side{position:static;height:auto;display:none}.side.open{display:block}.menu-btn{display:inline-flex}.main{padding:18px}.grid2{grid-template-columns:1fr}}
</style></head>

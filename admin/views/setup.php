<?php $adminTitle = 'Create admin account'; require __DIR__ . '/_head.php'; ?>
<body class="login"><div class="card">
<img src="<?= e($s['logo']) ?>" alt="" style="background:#141414;border-radius:10px;padding:8px">
<h1>Create your admin login</h1>
<p class="muted">First-time setup. Choose the username and password you'll use to manage the website. This screen disappears once an account exists.</p>
<?php if ($error): ?><div class="flash error"><?= e($error) ?></div><?php endif; ?>
<form method="post" autocomplete="off"><?= csrf_field() ?>
<label>Username<input type="text" name="username" required minlength="3" autocomplete="username"></label>
<label>Password (10+ characters)<input type="password" name="password" required minlength="10" autocomplete="new-password"></label>
<label>Confirm password<input type="password" name="password2" required minlength="10" autocomplete="new-password"></label>
<button class="btn" type="submit">Create account &amp; sign in</button>
</form></div></body></html>

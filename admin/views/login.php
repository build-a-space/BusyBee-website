<?php $adminTitle = 'Sign in'; require __DIR__ . '/_head.php'; ?>
<body class="login"><div class="card">
<img src="<?= e($s['logo']) ?>" alt="" style="background:#141414;border-radius:10px;padding:8px">
<h1>Admin sign in</h1>
<?php if ($error): ?><div class="flash error"><?= e($error) ?></div><?php endif; ?>
<form method="post"><?= csrf_field() ?>
<label>Username<input type="text" name="username" required autocomplete="username" autofocus></label>
<label>Password<input type="password" name="password" required autocomplete="current-password"></label>
<button class="btn" type="submit">Sign in</button>
</form>
<p class="muted" style="margin-top:14px"><a href="/">← Back to website</a></p>
</div></body></html>

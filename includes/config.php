<?php
/**
 * Busy Bee Window & Gutter Cleaning — core configuration.
 */
declare(strict_types=1);

define('ROOT_DIR', dirname(__DIR__));
define('INC_DIR', ROOT_DIR . '/includes');
define('TPL_DIR', ROOT_DIR . '/templates');
define('DATA_DIR', ROOT_DIR . '/data');
define('UPLOAD_DIR', ROOT_DIR . '/uploads');
define('UPLOAD_URL', '/uploads');

// Secret admin path. Change here if you ever want to move the panel.
define('ADMIN_PATH', '/dashboard-4-admin-panel');

// Brute-force protection for the admin login.
define('LOGIN_MAX_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_SECONDS', 900);

date_default_timezone_set('America/New_York');

if (!is_dir(DATA_DIR)) {
    @mkdir(DATA_DIR, 0755, true);
}
if (!is_dir(UPLOAD_DIR)) {
    @mkdir(UPLOAD_DIR, 0755, true);
}

require INC_DIR . '/functions.php';
require INC_DIR . '/settings.php';
require INC_DIR . '/content.php';
require INC_DIR . '/schema.php';

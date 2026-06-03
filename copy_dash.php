<?php
$source = __DIR__ . '/resources/views/pengarah_institusi_dashboard.blade.php';
$target = __DIR__ . '/resources/views/admin_institusi_dashboard.blade.php';

$content = file_get_contents($source);

// Standard text replacements
$content = str_replace([
    "route('pengarah.institusi.",
    "routeIs('pengarah.institusi.",
    "'pengarah.institusi.",
    "?? 'Pengarah Institusi'",
    "Pengarah Institusi</small>",
    "Pengarah Institusi</li>"
], [
    "route('admin.institusi.",
    "routeIs('admin.institusi.",
    "'admin.institusi.",
    "?? 'Admin Institusi'",
    "Admin Institusi</small>",
    "Admin Institusi</li>"
], $content);

file_put_contents($target, $content);
echo "Dashboard copied and routes updated.";

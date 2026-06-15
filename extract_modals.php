<?php
$content = file_get_contents(__DIR__ . '/resources/views/admin_dashboard.blade.php');
preg_match_all('/<div class="modal [^>]*id="([^"]+)"/i', $content, $matches);
foreach($matches[1] as $modal) {
    echo $modal . "\n";
}

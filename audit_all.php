<?php
$files = [
    'admin_dashboard' => 'resources/views/admin_dashboard.blade.php',
    'pengarah_institusi' => 'resources/views/pengarah_institusi_dashboard.blade.php',
    'admin_institusi' => 'resources/views/admin_institusi_dashboard.blade.php',
    'pengarah_negeri' => 'resources/views/pengarah_negeri_dashboard.blade.php',
];

foreach ($files as $label => $file) {
    $path = __DIR__ . '/' . $file;
    if (!file_exists($path)) {
        echo "[$label] FILE NOT FOUND: $path\n";
        continue;
    }
    $content = file_get_contents($path);
    // Find all modals
    preg_match_all('/id="([^"]*Modal[^"]*)"/', $content, $m);
    $modals = array_unique($m[1]);
    echo "\n=== $label ===\n";
    echo "Modals found: " . implode(', ', $modals) . "\n";
    
    // Find all buttons with data-action
    preg_match_all('/data-action="([^"]+)"/', $content, $actions);
    $uniqueActions = array_unique($actions[1]);
    echo "Actions: " . implode(', ', $uniqueActions) . "\n";
    
    // Find all forms with id
    preg_match_all('/<form[^>]+id="([^"]+)"/', $content, $forms);
    echo "Forms: " . implode(', ', array_unique($forms[1])) . "\n";
    
    // Find all save/submit buttons
    preg_match_all('/id="(save[^"]+Btn|btn[A-Za-z]+)"/', $content, $btnIds);
    $uniqueBtns = array_unique($btnIds[1]);
    echo "Save Buttons: " . implode(', ', $uniqueBtns) . "\n";
    
    // Lines
    $lines = count(explode("\n", $content));
    echo "Lines: $lines\n";
}

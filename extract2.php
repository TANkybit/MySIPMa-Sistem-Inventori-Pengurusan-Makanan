<?php
$file = 'C:\Users\user\Downloads\mysipmac_mysipma2 (4) (1).sql';
$content = file_get_contents($file);

preg_match('/ALTER TABLE \`borang_inden_drafts\`[^;]+;/', $content, $matches_alter1);
if (!empty($matches_alter1)) {
    echo $matches_alter1[0] . "\n\n";
}

preg_match('/MODIFY \`id\`[^;]+borang_inden_drafts[^;]+;/', $content, $matches_alter2);
if (!empty($matches_alter2)) {
    echo $matches_alter2[0] . "\n\n";
}

// Just match all alter tables and see which contain borang_inden_drafts
preg_match_all('/ALTER TABLE \`borang_inden_drafts\`[^;]+;/', $content, $matches_all);
if (!empty($matches_all[0])) {
    foreach ($matches_all[0] as $alter) {
        echo $alter . "\n\n";
    }
}

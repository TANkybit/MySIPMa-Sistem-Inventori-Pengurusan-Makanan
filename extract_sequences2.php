<?php
$file = 'C:\Users\user\Downloads\mysipmac_mysipma2 (4) (1).sql';
$content = file_get_contents($file);

preg_match('/CREATE TABLE \`order_sequences\`[^;]+;/', $content, $matches_create);
if (!empty($matches_create)) {
    echo $matches_create[0] . "\n\n";
}

preg_match_all('/ALTER TABLE \`order_sequences\`[^;]+;/', $content, $matches_alter);
if (!empty($matches_alter[0])) {
    foreach ($matches_alter[0] as $alter) {
        echo $alter . "\n\n";
    }
}

// Find any alter matching order_sequences for AUTO_INCREMENT
preg_match('/MODIFY \`id\`[^;]+?order_sequences[^;]+?;/i', $content, $matches_modify);
if (!empty($matches_modify)) {
    echo "ALTER TABLE `order_sequences`\n " . $matches_modify[0] . "\n\n";
}

preg_match_all('/INSERT INTO \`order_sequences\`[^;]+;/', $content, $matches_insert);
if (!empty($matches_insert[0])) {
    foreach ($matches_insert[0] as $insert) {
        echo $insert . "\n";
    }
} else {
    echo "-- No inserts found\n";
}

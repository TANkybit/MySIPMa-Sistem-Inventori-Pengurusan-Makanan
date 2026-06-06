<?php
$file = 'C:\Users\user\Downloads\mysipmac_mysipma2 (4) (1).sql';
$content = file_get_contents($file);

preg_match('/CREATE TABLE `borang_inden_drafts`[^;]+;/', $content, $matches_create);
if (!empty($matches_create)) {
    echo $matches_create[0] . "\n\n";
}

preg_match_all('/INSERT INTO `borang_inden_drafts`[^;]+;/', $content, $matches_insert);
if (!empty($matches_insert[0])) {
    foreach ($matches_insert[0] as $insert) {
        echo $insert . "\n";
    }
}

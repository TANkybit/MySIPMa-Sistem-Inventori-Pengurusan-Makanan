<?php
$file = 'C:\Users\user\Downloads\mysipmac_mysipma2 (4) (1).sql';
$content = file_get_contents($file);
preg_match('/CREATE TABLE \`order_sequences\`[^;]+;/', $content, $matches);
if (!empty($matches)) {
    echo $matches[0];
}

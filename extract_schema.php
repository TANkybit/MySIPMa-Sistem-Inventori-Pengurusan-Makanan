<?php
$file = 'c:\Users\user\Downloads\mysipmac_mysipma2 (8).sql';
$contents = file_get_contents($file);
preg_match_all('/CREATE TABLE (?:.*?) (.*?) \((.*?)\) ENGINE=InnoDB/sm', $contents, $matches);
$tables = [];
foreach ($matches[1] as $index => $tableName) {
    $columnsStr = $matches[2][$index];
    preg_match_all('/(.*?) (.*?),/m', $columnsStr, $colMatches);
    $columns = [];
    foreach ($colMatches[1] as $cIndex => $colName) {
        $columns[] = $colName;
    }
    $tableName = trim(str_replace('', '', $tableName));
    $tables[$tableName] = $columns;
}
file_put_contents('c:\laragon\www\MySIPMa\schema.json', json_encode($tables, JSON_PRETTY_PRINT));

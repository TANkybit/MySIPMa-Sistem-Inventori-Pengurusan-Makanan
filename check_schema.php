<?php
$db = new PDO('mysql:host=localhost;port=3307;dbname=mysipmac_mysipma2', 'root', '');
$tables = ['users', 'institutions', 'positions', 'suppliers', 'categories', 'items', 'uoms'];
$schema = "";
foreach($tables as $t) {
    try {
        $schema .= "\n--- $t ---\n";
        $q = $db->query("DESCRIBE $t");
        if ($q) {
            while($r = $q->fetch(PDO::FETCH_ASSOC)) {
                $schema .= $r['Field'] . ' (' . $r['Type'] . ")\n";
            }
        } else {
             $schema .= "Table empty or error\n";
        }
    } catch (Exception $e) { }
}
file_put_contents(__DIR__ . '/schema_dump.txt', $schema);
echo "Done";

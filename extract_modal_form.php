<?php
$content = file_get_contents(__DIR__ . '/resources/views/admin_dashboard.blade.php');
$startTag = 'id="addInstitutionModal"';
$startPos = strpos($content, $startTag);
if ($startPos !== false) {
    // Find next <div class="modal" or end of file
    $endPos = strpos($content, '<div class="modal ', $startPos + strlen($startTag));
    if ($endPos === false) $endPos = strpos($content, '<!-- Add Admin', $startPos);
    if ($endPos === false) $endPos = strlen($content);
    
    $modalContent = substr($content, $startPos, $endPos - $startPos);
    preg_match_all('/<input[^>]+name="([^"]+)"[^>]*>/i', $modalContent, $inputs);
    preg_match_all('/<select[^>]+name="([^"]+)"[^>]*>/i', $modalContent, $selects);
    preg_match_all('/<textarea[^>]+name="([^"]+)"[^>]*>/i', $modalContent, $textareas);
    
    echo "addInstitutionModal fields:\n";
    print_r($inputs[1]);
    print_r($selects[1]);
    print_r($textareas[1]);
}

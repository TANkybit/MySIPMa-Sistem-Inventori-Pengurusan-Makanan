$c = Get-Content 'C:\laragon\www\MySIPMA_2\resources\views\borang_inden.blade.php' -Raw
$lines = $c -split "`n"
$startLine = 0; $endLine = 0
for ($i = 0; $i -lt $lines.Count; $i++) {
    if ($lines[$i].Trim() -eq '<script>' -and $i -gt 700) { $startLine = $i + 1; break }
}
for ($i = $lines.Count - 1; $i -ge 0; $i--) {
    if ($lines[$i].Trim() -eq '</script>' -and $i -gt $startLine) { $endLine = $i; break }
}
$brace = 0; $paren = 0
for ($i = $startLine; $i -lt $endLine; $i++) {
    $line = $lines[$i]
    $brace += ([regex]::Matches($line, '\{')).Count - ([regex]::Matches($line, '\}')).Count
    $paren += ([regex]::Matches($line, '\(')).Count - ([regex]::Matches($line, '\)')).Count
}
Write-Host "Braces: $brace | Parens: $paren | Lines: $startLine to $endLine"

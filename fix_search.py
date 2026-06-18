file_path = r'c:\laragon\www\MySIPMa\resources\views\admin_dashboard.blade.php'

with open(file_path, 'r', encoding='utf-8') as f:
    lines = f.readlines()

print(f"Total lines: {len(lines)}")

# Find the old duplicate block
# Start: the orphaned "const searchInput = document.getElementById('globalSearchInput');" 
#        that appears around line 3005 (after the new block ends at line 3003)
# End: the old "});" that closes the old jQuery/search block, around line 3145

start_idx = -1
end_idx = -1

# Search in range 3003-3020
for i in range(3002, 3020):
    if i < len(lines):
        stripped = lines[i].strip()
        if "const searchInput = document.getElementById" in stripped or "const searchResults = document.getElementById" in stripped:
            if start_idx == -1:
                start_idx = i
                break

# Search for the closing }); that follows the old block - after the isElementInViewport function
for i in range(3130, 3160):
    if i < len(lines):
        stripped = lines[i].strip()
        if stripped == '});':
            end_idx = i
            break

print(f"Old block start (1-indexed): {start_idx + 1}")
print(f"Old block end (1-indexed): {end_idx + 1}")

if start_idx > 0 and end_idx > start_idx:
    print(f"Start line content: {lines[start_idx][:100]}")
    print(f"End line content: {lines[end_idx][:100]}")
    
    # Remove lines from start_idx to end_idx (inclusive)
    new_lines = lines[:start_idx] + lines[end_idx + 1:]
    
    with open(file_path, 'w', encoding='utf-8') as f:
        f.writelines(new_lines)
    
    print(f"SUCCESS: Removed lines {start_idx+1} to {end_idx+1} ({end_idx - start_idx + 1} lines deleted)")
    print(f"New total lines: {len(new_lines)}")
else:
    print("ERROR: Could not find boundaries")
    # Print nearby lines for debugging
    print("\nContent around line 3005:")
    for i in range(3002, 3015):
        if i < len(lines):
            print(f"  {i+1}: {lines[i][:80]}")
    print("\nContent around line 3140-3150:")
    for i in range(3138, 3152):
        if i < len(lines):
            print(f"  {i+1}: {lines[i][:80]}")

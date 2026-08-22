## **Terminal Commands**

Membuat folder baru melalui terminal
```bash
New-Item -Path "path\dirName\" -Name "dirName" -ItemType Directory
```
Membuat file baru melalui terminal
```bash
New-Item -Path "path\dirName\" -Name "filename.php" -ItemType File
```
Menghapus folder atau file melalui terminal
```bash
Remove-Item -Recurse -Force "dirName"
Remove-Item "fileName.ext"
```

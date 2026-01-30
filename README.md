# EDAN (Encode Decode Automatic Nih) 🚀

[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.4-8892bf.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

**EDAN** adalah *Command-Line Interface* (CLI) tool berbasis PHP yang dirancang untuk proses encoding, decoding, dan hashing secara instan. Tool ini dikembangkan khusus untuk membantu workflow *cybersecurity analysis*, *bug bounty*, dan *web development* dalam menangani berbagai format data dalam satu perintah tunggal.

---

## ✨ Fitur Unggulan
- **Konsistensi Output:** Urutan algoritma tetap sama pada mode *encode* maupun *decode* untuk memudahkan verifikasi data.
- **Silent Mode:** Optimalisasi penanganan error sehingga bebas dari *PHP warnings* atau *deprecated notices*.
- **Auto-Alignment:** Output terminal tertata rapi dengan indentasi titik dua yang sejajar secara vertikal.
- **Zero Dependencies:** Berjalan menggunakan PHP native tanpa memerlukan library pihak ketiga.

---

## 🛠️ Algoritma yang Didukung

| Kategori | Algoritma |
| :--- | :--- |
| **Encoding** | Base64, Base64URL, URL Encode, Hexadecimal, Base32, UUEncode, JSON |
| **Data Format** | Binary, Decimal (ASCII), Morse Code |
| **Cipher** | ROT13, Caesar Cipher (Shift yang dapat disesuaikan) |
| **Hashing** | SHA256, MD5 (Identifikasi One-way) |
| **Utility** | Reversed String |

---

## 🚀 Instalasi

Pastikan PHP (minimal versi 7.4) sudah terinstal di sistem Anda.

#### 📱 Android (Termux)
```bash
pkg update && pkg upgrade
pkg install php
git clone https://github.com/alhikamgov/edan.git
cd edan
chmod +x edan.php
```

#### 🪟 Windows
1. Pastikan Path PHP sudah terdaftar di Environment Variables.
2. Buka PowerShell atau CMD di folder tempat edan.php berada.
3. Jalankan manual:
```bash
php edan.php encode "input string."
```
---
## 📖 Panduan Penggunaan

### 1. Encode

   Mengonversi teks biasa menjadi berbagai format:
   ```bash
   edan.php encode "ganteng"
   ```
   Output:
   ```
   ENCODE by. EDAN (Encode Decode Automation Nih)

   Base64          : Z2FudGVuZw==
   Base64URL       : Z2FudGVuZw
   URL Encode      : ganteng
   Hexadecimal     : 67616e74656e67
   Decimal         : 103 97 110 116 101 110 103
   Binary          : 01100111 01100001 01101110 01110100 01100101 01101110 01100111
   Base32          : M5QW45DFNZTQ
   ROT13           : tnagrat
   Morse Code      : --. .- -. - . -. --.
   Caesar          : jdqwhqj
   UUEncode        : '9V%N=&5N9P``
   `
   JSON            : "ganteng"
   SHA256          : 1e6bf38be7457f3ab8730d73eaf9899ff6140838deddf320c9fc05ccbc778334
   MD5             : 8b6bc5d8046c8466359d3ac43ce362ab
   Reversed        : gnetnag
   ```
   
### 2. Decode
   ```bash
   edan.php decode "Z2FudGVuZw=="
   ```
   Output:
   ```
   DECODE by. EDAN (Encode Decode Automation Nih)

   Base64          : ganteng
   Base64URL       : ganteng
   URL Encode      : Z2FudGVuZw==
   Base32          : ╬ïAÜ┤═
   ROT13           : M2ShqTIhMj==
   Caesar          : W2CraDSrWt==
   SHA256          : [One-way Hash]
   MD5             : [One-way Hash]
   Reversed        : ==wZuVGduF2Z
   ```

### 3. Custom Shift (Caesar Cipher)

   Anda dapat menentukan jumlah pergeseran karakter (default adalah 3):
   ```bash
   edan.php encode "rahasia" 13
   ```
   Output:
   ```
   ENCODE by. EDAN (Encode Decode Automation Nih)

   Base64          : cmFoYXNpYQ==
   Base64URL       : cmFoYXNpYQ
   URL Encode      : rahasia
   Hexadecimal     : 72616861736961
   Decimal         : 114 97 104 97 115 105 97
   Binary          : 01110010 01100001 01101000 01100001 01110011 01101001 01100001
   Base32          : OJQWQYLTNFQQ
   ROT13           : enunfvn
   Morse Code      : .-. .- .... .- ... .. .-
   Caesar          : enunfvn
   UUEncode        : '<F%H87-I80`
   `
   JSON            : "rahasia"
   SHA256          : 541e984103d4099bb8383050c56d511e733d85e6ab889a1c363ced651762eee0
   MD5             : ac43724f16e9241d990427ab7c8f4228
   Reversed        : aisahar
   ```

## 🤝 Kontribusi
Kontribusi terbuka untuk siapa saja. Jika Anda menemukan bug atau ingin menambahkan algoritma baru, silakan ajukan Pull Request atau buka Issue.

Dibuat dengan ❤️ untuk komunitas open source.

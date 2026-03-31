<?php

require_once '../Pages/session_checker.php';
// echo "Session main: " . (isset($_SESSION['main']) ? $_SESSION['main'] : 'NOT SET');
// echo(isset($_SESSION['main']))
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <!-- <script src="https://cdn.sheetjs.com/xlsx-0.20.2/package/dist/xlsx.full.min.js"></script> -->
  <script src="/Xlsx Package/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
  <link href="/GS/src/output.css" rel="stylesheet">
  <link rel="icon" type="Images/png" href="../Images/gsm-logo-icon.png">
  <title>Admin Panel</title>
</head>
<body class="bg-gray-50">

  <div class="bg-[#29842e] h-11 flex items-center px-8 text-white text-xl">Admin Panel</div>

  <div class="pl-3 py-4">
    <img src= "../Images/gsmc-logo.png" alt="logo" class="h-28">
  </div>

  <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Upload Excel File</h2>
    <input type="file" id="excelUpload" accept=".xlsx, .xls" class="mb-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
    <button id="pushBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm font-medium">Upload</button>
    <div id="message" class="mt-4 text-sm hidden"></div>
  </div>

<script>
  document.getElementById('pushBtn').addEventListener('click', function() {
    const fileInput = document.getElementById('excelUpload');
    if (!fileInput.files.length) {
      alert('Please select an Excel file.');
      return;
    }

    const file = fileInput.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
      try {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });
        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        const rows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

        console.log('Headers:', rows[0]);

        const pricingData = [];
        for (let i = 1; i < rows.length; i++) {
          const row = rows[i];
          if (row.length < 5) continue;

          const item = {
            mainCategory: row[0]?.toString().trim() || '',   
            department: row[1]?.toString().trim() || '',     
            itemCode: row[2]?.toString().trim() || '',       
            description: row[3]?.toString().trim() || '',  
            price: parseFloat(row[4]) || 0               
          };

          console.log(`Row ${i}:`, { raw: row, parsed: item });

          if (item.itemCode && item.description) {
            pricingData.push(item);
          }
        }

        if (pricingData.length === 0) {
          alert('No valid data found. Check your Excel file.');
          return;
        }

        fetch('upload_pricing.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ filename: file.name, data: pricingData })
        })
        .then(async response => {
          const text = await response.text();
          try {
            return JSON.parse(text);
          } catch (e) {
            throw new Error('Server returned: ' + text.substring(0, 200));
          }
        })
        .then(result => {
          const msg = document.getElementById('message');
          msg.classList.remove('hidden', 'bg-red-100', 'text-red-800', 'bg-green-100', 'text-green-800');
          if (result.success) {
            msg.className = 'mt-4 p-3 bg-green-100 text-green-800 rounded';
            msg.textContent = 'File uploaded successfully!';
            fileInput.value = '';
          } else {
            msg.className = 'mt-4 p-3 bg-red-100 text-red-800 rounded';
            msg.textContent = 'Error: ' + result.error;
          }
        })
        .catch(err => {
          alert('Upload failed: ' + err.message);
        });

      } catch (err) {
        console.error(err);
        alert('Invalid Excel file.');
      }
    };

    reader.readAsArrayBuffer(file);
  });
</script>

</body>
</html>

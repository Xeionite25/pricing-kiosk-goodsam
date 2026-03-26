let pushedFiles = [];

const fileInput = document.getElementById('excelUpload');
const pushBtn = document.getElementById('pushBtn');
const fileList = document.getElementById('fileList');
const jsonPreview = document.getElementById('jsonPreview');
const jsonContent = document.getElementById('jsonContent');
const sidebar = document.getElementById('sidebar');
const sidebarCollapsed = document.getElementById('sidebarCollapsed');
const toggleBtn = document.getElementById('toggleSidebar');

toggleBtn.onclick = () => {
  sidebar.classList.toggle('hidden');
  sidebarCollapsed.classList.toggle('hidden');
};

function showJson(data) {
  jsonContent.textContent = JSON.stringify(data, null, 2);
  jsonPreview.classList.remove('hidden');
}

function renderFileList() {
  fileList.innerHTML = '';
  pushedFiles.forEach((f, i) => {
    const li = document.createElement('li');
    li.className = 'p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100';
    li.textContent = f.filename;
    li.ondblclick = () => showJson(f.data);
    fileList.appendChild(li);
  });
}

function parseExcel(file) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.onload = e => {
      try {
        const workbook = XLSX.read(new Uint8Array(e.target.result), { type: 'array' });
        const firstSheet = workbook.Sheets[workbook.SheetNames[0]];
        const rows = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });
        resolve(rows);
      } catch (err) {
        reject(err);
      }
    };
    reader.onerror = reject;
    reader.readAsArrayBuffer(file);
  });
}

pushBtn.addEventListener('click', async function() {
  const file = fileInput.files[0];
  if (!file) {
    alert('Please select an Excel file.');
    return;
  }

  try {
    const rows = await parseExcel(file);
    if (rows.length < 2) {
      alert('File has no data rows.');
      return;
    }

    const headers = rows[0].map(h => h?.toString().trim().toLowerCase() || '');
    console.log('Headers found:', headers);

    const required = ['category', 'department', 'item code', 'item description', 'price'];
    const indexes = {};

    required.forEach(col => {
      const idx = headers.findIndex(h => h.includes(col)); // partial match
      if (idx === -1) {
        throw new Error(`Column "${col}" not found. Headers: ${headers.join(', ')}`);
      }
      indexes[col] = idx;
      console.log(`Column "${col}" found at index ${idx}`);
    });

    const pricingData = [];
    for (let i = 1; i < rows.length; i++) {
      const row = rows[i];
      // Ensure row has enough cells
      if (row.length <= Math.max(...Object.values(indexes))) {
        console.warn(`Row ${i} skipped: not enough columns`, row);
        continue;
      }

      const item = {
        mainCategory: row[indexes['category']]?.toString().trim() || '',
        department: row[indexes['department']]?.toString().trim() || '',
        itemCode: row[indexes['item code']]?.toString().trim() || '',
        description: row[indexes['item description']]?.toString().trim() || '',
        price: parseFloat(row[indexes['price']]) || 0   // convert to number, default 0
      };

      console.log(`Row ${i}:`, { raw: row, parsed: item });

      if (item.itemCode && item.description) {
        pricingData.push(item);
      } else {
        console.warn(`Row ${i} skipped: missing itemCode or description`, item);
      }
    }

    if (pricingData.length === 0) {
      alert('No valid items found. Check your Excel data.');
      return;
    }

    pushedFiles.push({ filename: file.name, data: pricingData });
    renderFileList();
    showJson(pricingData);

    const response = await fetch('upload_pricing.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ filename: file.name, data: pricingData })
    });

    const result = await response.json();
    if (result.success) {
      alert('Upload successful.');
    } else {
      alert('Error: ' + result.error);
    }

    fileInput.value = '';
  } catch (err) {
    console.error(err);
    alert('Failed: ' + err.message);
  }
});

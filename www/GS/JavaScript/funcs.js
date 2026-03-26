(function() {
  let allItems = [];

  const tabCategories = {
    services: "Services",
    supplies: "Medical Supplies",
    medicines: "Medicines"
  };

  // DOM elements
  const searchInput = document.getElementById('searchInput');
  const searchBtn = document.getElementById('searchBtn');
  const categorySelect = document.getElementById('categorySelect'); // department dropdown
  const servicesTbody = document.getElementById('servicesTableBody');
  const suppliesTbody = document.getElementById('suppliesTableBody');
  const medicinesTbody = document.getElementById('medicinesTableBody');

  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');

  let activeTab = 'services';

  fetch('Pages/get_pricing.php')
    .then(response => response.text())
    .then(text => {
      try {
        const data = JSON.parse(text);
        allItems = data;
      // For Debugging, load list of array from the excel file to JSON format and print it on the devtools
        // console.log('Loaded items:', allItems); 
        switchTab(activeTab);
      } catch (e) {
        console.error('Invalid JSON response:', text);
      }
    })
    .catch(err => console.error('Fetch error:', err));

  function switchTab(tabId) {
    activeTab = tabId;

    tabButtons.forEach(btn => {
      btn.classList.remove('tab-active', 'bg-[#29842e]', 'text-white');
      if (btn.dataset.tab === tabId) {
        btn.classList.add('tab-active', 'bg-[#29842e]', 'text-white');
      }
    });

    tabContents.forEach(content => {
      content.classList.add('tab-inactive');
    });
    document.getElementById(tabId + 'Tab').classList.remove('tab-inactive');

    searchInput.value = '';
    renderActiveTab();
  }

  tabButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      switchTab(this.dataset.tab);
    });
  });

  function renderActiveTab() {
    if (!allItems.length) return;

    const selectedDept = categorySelect.value;
    const searchText = searchInput.value.toLowerCase();

    let tbody;
    if (activeTab === 'services') {
      tbody = servicesTbody;
    } else if (activeTab === 'supplies') {
      tbody = suppliesTbody;
    } else {
      tbody = medicinesTbody;
    }

    let filtered = allItems.filter(item => {
      if (item.mainCategory !== tabCategories[activeTab]) return false;

      if (item.department !== selectedDept) return false;

      return true;
    });

    if (searchText !== '') {
      filtered = filtered.filter(item =>
        item.description.toLowerCase().includes(searchText)
      );
    }

    let html = '';
    filtered.forEach(item => {
      html += '<tr>' +
        '<td class="px-4 py-3">' + item.itemCode + '</td>' +
        '<td class="px-4 py-3">' + item.description + '</td>' +
        '<td class="px-4 py-3 text-right:">₱' + item.price.toFixed(2) + '</td>' +
        '</tr>';
    });

    if (filtered.length === 0) {
      html = '<tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">No matching items found.</td></tr>';
    }

    tbody.innerHTML = html;
  }

  // Event listeners
  searchInput.addEventListener('keyup', renderActiveTab);
  searchBtn.addEventListener('click', renderActiveTab);
  categorySelect.addEventListener('change', renderActiveTab);
})();

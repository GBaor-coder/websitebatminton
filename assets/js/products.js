// Products Filter JS
document.addEventListener('DOMContentLoaded', function() {
  const sidebar = document.querySelector('.product-sidebar');
  const overlay = document.querySelector('.offcanvas-overlay');
  const toggleBtn = document.querySelector('.mobile-filter-toggle');
  const applyBtn = document.querySelector('.btn-apply');
  const clearBtn = document.querySelector('.btn-clear');
  const checkboxes = document.querySelectorAll('.filter-checkbox input[type="checkbox"]');
  const radios = document.querySelectorAll('.filter-checkbox input[type="radio"]');
  const techSearch = document.querySelector('.tech-search input');
  
  let activeFilters = new Set();
  let filterTimeout;
  
  // Mobile Offcanvas
  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      sidebar.classList.add('show');
      overlay.classList.add('show');
    });
  }
  
  if (overlay) {
    overlay.addEventListener('click', () => {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    });
  }
  
  // Load filters from URL
  function loadFiltersFromURL() {
    const urlParams = new URLSearchParams(window.location.search);
    document.querySelectorAll('.filter-checkbox input').forEach(input => {
      const param = urlParams.get(input.name);
      if (param === input.value || (param && input.value.includes(param))) {
        input.checked = true;
        input.closest('.filter-checkbox').classList.add('active');
        activeFilters.add(input.name);
      }
    });
    
    // Tech search
    const techQuery = urlParams.get('tech');
    if (techSearch && techQuery) {
      techSearch.value = techQuery;
    }
    
    updateFilterCount();
    applyFilters();
  }
  
  // Update filter count
  function updateFilterCount() {
    const count = activeFilters.size;
    const countEl = document.querySelector('.filter-count');
    if (countEl) {
      countEl.textContent = count;
      countEl.style.display = count > 0 ? 'inline' : 'none';
    }
  }
  
  // Checkbox/Radio change
  function handleFilterChange(e) {
    const input = e.target;
    const checkbox = input.closest('.filter-checkbox');
    
    if (input.checked) {
      checkbox.classList.add('active');
      activeFilters.add(input.name);
    } else {
      checkbox.classList.remove('active');
      activeFilters.delete(input.name);
    }
    
    updateFilterCount();
    debounceApplyFilters();
  }
  
  checkboxes.forEach(cb => cb.addEventListener('change', handleFilterChange));
  radios.forEach(rb => rb.addEventListener('change', handleFilterChange));
  
  // Tech search
  if (techSearch) {
    techSearch.addEventListener('input', function() {
      debounceApplyFilters();
    });
  }
  
  // Debounced apply
  function debounceApplyFilters() {
    clearTimeout(filterTimeout);
    filterTimeout = setTimeout(applyFilters, 300);
  }
  
  // Apply filters to products (client-side for current page)
  function applyFilters() {
    const urlParams = new URLSearchParams(window.location.search);
    
    // Update URL without reload
    [...checkboxes].forEach(cb => {
      if (cb.checked) {
        addOrReplaceParam(urlParams, cb.name, cb.value);
      } else {
        urlParams.delete(cb.name);
      }
    });
    
    [...radios].forEach(rb => {
      if (rb.checked) {
        addOrReplaceParam(urlParams, rb.name, rb.value);
      }
    });
    
    if (techSearch && techSearch.value.trim()) {
      urlParams.set('tech', techSearch.value.trim());
    } else {
      urlParams.delete('tech');
    }
    
    // Update URL
    const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
    window.history.replaceState({}, '', newUrl);
    
    // Client-side product filtering (demo - hide unmatched)
    // Note: Real impl needs product data attributes
    const products = document.querySelectorAll('.product-card');
    let visibleCount = 0;
    
    products.forEach(product => {
      let match = true;
      // Example: check data attributes if available
      // if (activeFilters.has('brand') && !product.dataset.brand) match = false;
      if (match) {
        product.style.display = '';
        visibleCount++;
      } else {
        product.style.display = 'none';
      }
    });
    
    // Update count
    const countEl = document.querySelector('.product-count');
    if (countEl) {
      countEl.textContent = visibleCount;
    }
  }
  
  function addOrReplaceParam(params, name, value) {
    if (params.has(name)) {
      const values = params.getAll(name);
      const index = values.indexOf(value);
      if (index > -1) {
        values.splice(index, 1);
      } else {
        values.push(value);
      }
      params.delete(name);
      values.forEach(v => params.append(name, v));
    } else {
      params.append(name, value);
    }
  }
  
  // Apply button
  if (applyBtn) {
    applyBtn.addEventListener('click', applyFilters);
  }
  
  // Clear filters
  if (clearBtn) {
    clearBtn.addEventListener('click', () => {
      document.querySelectorAll('.filter-checkbox input').forEach(input => {
        input.checked = false;
        input.closest('.filter-checkbox').classList.remove('active');
      });
      activeFilters.clear();
      techSearch.value = '';
      updateFilterCount();
      applyFilters();
    });
  }
  
  // Price slider (if exists)
  const priceSlider = document.querySelector('#priceRange');
  if (priceSlider) {
    priceSlider.addEventListener('input', function() {
      const minPrice = document.querySelector('#minPrice');
      const maxPrice = document.querySelector('#maxPrice');
      if (minPrice) minPrice.textContent = formatPrice(this.value.split(',')[0]);
      if (maxPrice) maxPrice.textContent = formatPrice(this.value.split(',')[1]);
      debounceApplyFilters();
    });
  }
  
  function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
  }
  
  // Smooth scroll to products after mobile close
  const closeBtn = document.querySelector('.btn-close-sidebar');
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
      document.querySelector('.products-grid').scrollIntoView({ behavior: 'smooth' });
    });
  }
  
  // Initialize
  loadFiltersFromURL();
  
  // Resize handler for responsive
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      sidebar.classList.remove('show');
      overlay.classList.remove('show');
    }
  });
});

/**
 * Pinsaka - Modul Pelaporan Kerusakan Sarpras & Kendaraan Dinas
 * File: public/js/laporan-kerusakan.js
 * Bertanggung jawab atas:
 * 1. Switcher kategori Sarpras vs Kendaraan di form pelaporan.
 * 2. Preview gambar & validasi ukuran file sebelum upload.
 * 3. Pencegahan double-submit & status loading tombol.
 * 4. Filter pencarian instan pada tabel & kartu laporan.
 * 5. Penghitung karakter deskripsi kerusakan.
 */

document.addEventListener('DOMContentLoaded', () => {
  initCategorySwitcher();
  initPhotoPreview();
  initCharacterCounter();
  initFormSubmitState();
  initInstantSearch();
});

/**
 * 1. Switcher Kategori Pelaporan (Sarpras vs Kendaraan Dinas)
 */
function initCategorySwitcher() {
  const radioSarpras = document.querySelector('input[name="kategori_laporan"][value="sarpras"]');
  const radioKendaraan = document.querySelector('input[name="kategori_laporan"][value="kendaraan"]');
  const sectionSarpras = document.getElementById('lk-section-sarpras');
  const sectionKendaraan = document.getElementById('lk-section-kendaraan');
  const cardSarpras = document.getElementById('lk-card-sarpras');
  const cardKendaraan = document.getElementById('lk-card-kendaraan');

  if (!radioSarpras || !radioKendaraan || !sectionSarpras || !sectionKendaraan) return;

  function updateCategoryState(category) {
    if (category === 'kendaraan') {
      sectionSarpras.style.display = 'none';
      sectionKendaraan.style.display = 'block';

      if (cardSarpras) cardSarpras.classList.remove('is-active');
      if (cardKendaraan) cardKendaraan.classList.add('is-active');

      // Aktifkan required untuk field kendaraan
      setFieldsRequired(sectionKendaraan, true);
      setFieldsRequired(sectionSarpras, false);
    } else {
      sectionSarpras.style.display = 'block';
      sectionKendaraan.style.display = 'none';

      if (cardSarpras) cardSarpras.classList.add('is-active');
      if (cardKendaraan) cardKendaraan.classList.remove('is-active');

      setFieldsRequired(sectionSarpras, true);
      setFieldsRequired(sectionKendaraan, false);
    }
  }

  function setFieldsRequired(container, isRequired) {
    const requiredInputs = container.querySelectorAll('[data-required-toggle]');
    requiredInputs.forEach((el) => {
      if (isRequired) {
        el.setAttribute('required', 'required');
      } else {
        el.removeAttribute('required');
      }
    });
  }

  radioSarpras.addEventListener('change', () => updateCategoryState('sarpras'));
  radioKendaraan.addEventListener('change', () => updateCategoryState('kendaraan'));

  // Sync awal sesuai pilihan aktif
  const initialCategory = radioKendaraan.checked ? 'kendaraan' : 'sarpras';
  updateCategoryState(initialCategory);

  // Autofill kendaraan dinas saat dropdown dipilih
  const selectArmada = document.getElementById('lk-select-kendaraan');
  const inputNopol = document.getElementById('lk-input-nopol');
  const inputNamaKendaraan = document.getElementById('lk-input-nama-kendaraan');

  if (selectArmada && inputNopol && inputNamaKendaraan) {
    selectArmada.addEventListener('change', (e) => {
      const selectedOption = e.target.selectedOptions[0];
      if (selectedOption && selectedOption.value !== '') {
        const nopol = selectedOption.getAttribute('data-nopol') || '';
        const nama = selectedOption.getAttribute('data-nama') || '';
        inputNopol.value = nopol;
        inputNamaKendaraan.value = nama;
      }
    });
  }
}

/**
 * 2. Preview Foto & Validasi Ukuran/Format File
 */
function initPhotoPreview() {
  const fileInputs = document.querySelectorAll('.lk-file-input');

  fileInputs.forEach((input) => {
    const previewContainer = document.getElementById(input.dataset.previewTarget);
    const dropzone = input.closest('.lk-upload-zone');
    if (!previewContainer) return;

    input.addEventListener('change', (e) => {
      handleFiles(input.files, previewContainer, input);
    });

    if (dropzone) {
      ['dragenter', 'dragover'].forEach((eventName) => {
        dropzone.addEventListener(eventName, (e) => {
          e.preventDefault();
          dropzone.classList.add('is-dragover');
        });
      });

      ['dragleave', 'drop'].forEach((eventName) => {
        dropzone.addEventListener(eventName, (e) => {
          e.preventDefault();
          dropzone.classList.remove('is-dragover');
        });
      });

      dropzone.addEventListener('drop', (e) => {
        if (e.dataTransfer && e.dataTransfer.files.length > 0) {
          input.files = e.dataTransfer.files;
          handleFiles(input.files, previewContainer, input);
        }
      });
    }
  });

  function handleFiles(files, container, inputElement) {
    container.innerHTML = '';
    const maxFiles = 5;
    const maxSize = 5 * 1024 * 1024; // 5MB

    if (files.length > maxFiles) {
      alert(`Maksimal ${maxFiles} foto per unggahan. Hanya ${maxFiles} foto pertama yang akan diproses.`);
    }

    const filesToPreview = Array.from(files).slice(0, maxFiles);

    filesToPreview.forEach((file, index) => {
      if (file.size > maxSize) {
        alert(`File "${file.name}" melebihi batas 5MB.`);
        return;
      }

      if (!file.type.match('image.*')) {
        alert(`File "${file.name}" bukan format gambar yang didukung (JPG, PNG, WEBP).`);
        return;
      }

      const reader = new FileReader();
      reader.onload = (e) => {
        const item = document.createElement('div');
        item.className = 'lk-preview-item';
        item.innerHTML = `
          <img src="${e.target.result}" alt="Preview foto ke-${index + 1}" class="lk-preview-img">
          <div class="lk-preview-name">${file.name}</div>
        `;
        container.appendChild(item);
      };
      reader.readAsDataURL(file);
    });
  }
}

/**
 * 3. Penghitung Karakter Realtime untuk Deskripsi
 */
function initCharacterCounter() {
  const textareas = document.querySelectorAll('textarea[data-counter-target]');
  textareas.forEach((ta) => {
    const counterEl = document.getElementById(ta.dataset.counterTarget);
    if (!counterEl) return;

    const minChars = parseInt(ta.dataset.minChars || '10', 10);
    const maxChars = parseInt(ta.getAttribute('maxlength') || '2000', 10);

    function updateCount() {
      const current = ta.value.length;
      counterEl.textContent = `${current} / ${maxChars} karakter`;
      if (current < minChars && current > 0) {
        counterEl.style.color = 'var(--lk-status-danger-text)';
      } else {
        counterEl.style.color = 'var(--lk-text-subtle)';
      }
    }

    ta.addEventListener('input', updateCount);
    updateCount();
  });
}

/**
 * 4. Status Loading Submit & Pencegahan Double Submit
 */
function initFormSubmitState() {
  const forms = document.querySelectorAll('form[data-loading-submit]');
  forms.forEach((form) => {
    form.addEventListener('submit', (e) => {
      if (!form.checkValidity()) {
        return;
      }

      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.classList.add('is-disabled');
        const originalText = submitBtn.dataset.originalText || submitBtn.innerHTML;
        submitBtn.dataset.originalText = originalText;
        submitBtn.innerHTML = `
          <span class="lk-spinner" aria-hidden="true"></span>
          <span>Menyimpan &amp; Memproses...</span>
        `;
      }
    });
  });
}

/**
 * 5. Pencarian Instan Client-side untuk Tabel & Kartu
 */
function initInstantSearch() {
  const searchInput = document.getElementById('lk-search-input');
  if (!searchInput) return;

  const tableRows = document.querySelectorAll('.lk-table tbody tr');
  const cardItems = document.querySelectorAll('.lk-mobile-cards .lk-card-item');
  const emptySearchMessage = document.getElementById('lk-empty-search');

  searchInput.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase().trim();
    let matchCount = 0;

    tableRows.forEach((row) => {
      const text = row.textContent.toLowerCase();
      const isMatch = text.includes(term);
      row.style.display = isMatch ? '' : 'none';
      if (isMatch) matchCount++;
    });

    cardItems.forEach((card) => {
      const text = card.textContent.toLowerCase();
      const isMatch = text.includes(term);
      card.style.display = isMatch ? '' : 'none';
      if (isMatch) matchCount++;
    });

    if (emptySearchMessage) {
      if (matchCount === 0 && term !== '') {
        emptySearchMessage.style.display = 'block';
      } else {
        emptySearchMessage.style.display = 'none';
      }
    }
  });
}

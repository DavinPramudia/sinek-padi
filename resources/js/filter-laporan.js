window.changeFilterInput = function() {
    const type = document.getElementById('filterType').value;
    
    // Ambil semua wrapper filter
    const wrappers = document.querySelectorAll('.filter-input-wrapper');
    
    wrappers.forEach(el => {
        el.classList.add('hidden');
        // Nonaktifkan semua input/select di dalam wrapper yang tersembunyi agar tidak ikut terkirim ke URL
        el.querySelectorAll('input, select').forEach(input => input.disabled = true);
    });

    // Tampilkan wrapper yang dipilih dan aktifkan kembali input/select di dalamnya
    let activeWrapper = null;
    if (type === 'harian') {
        activeWrapper = document.getElementById('wrapperHarian');
    } else if (type === 'bulanan') {
        activeWrapper = document.getElementById('wrapperBulanan');
    } else if (type === 'tahunan') {
        activeWrapper = document.getElementById('wrapperTahunan');
    } else if (type === 'triwulanan') {
        activeWrapper = document.getElementById('wrapperTriwulanan');
    }

    if (activeWrapper) {
        activeWrapper.classList.remove('hidden');
        activeWrapper.querySelectorAll('input, select').forEach(input => input.disabled = false);
    }
};

// Jalankan saat halaman selesai dimuat
document.addEventListener("DOMContentLoaded", function() {
    if (document.getElementById('filterType')) {
        changeFilterInput();
    }
});
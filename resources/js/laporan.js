function changeFilterInput() {
    const filterType = document.getElementById('filterType').value;
    
    // Sembunyikan semua wrapper input
    document.querySelectorAll('.filter-input-wrapper').forEach(el => {
        el.classList.add('hidden');
    });

    // Tampilkan wrapper yang sesuai dengan pilihan mode
    if (filterType === 'harian') {
        document.getElementById('wrapperHarian').classList.remove('hidden');
    } else if (filterType === 'bulanan') {
        document.getElementById('wrapperBulanan').classList.remove('hidden');
    } else if (filterType === 'tahunan') {
        document.getElementById('wrapperTahunan').classList.remove('hidden');
    } else if (filterType === 'triwulanan') {
        document.getElementById('wrapperTriwulanan').classList.remove('hidden');
    }
}

// Jalankan saat halaman dimuat pertama kali agar input yang aktif sesuai
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('filterType')) {
        changeFilterInput();
    }
});
document.addEventListener('alpine:init', () => {
    Alpine.data('loketTransaksi', () => ({
        kategoriKendaraan: 'motor',
        tarifkendaraan: { motor: 2000, mobil: 4000 },

        qty: { lokal: 0, nusantara: 0, asing: 0 },

        tambah(kategori) {
            this.qty[kategori]++;
        },

        kurang(kategori) {
            if (this.qty[kategori] > 0) {
                this.qty[kategori]--;
            }
        },

        get totalPengunjung() {
            return this.qty.lokal + this.qty.nusantara + this.qty.asing;
        },

        get totalBayar() {
            let tarif = this.tarifkendaraan[this.kategoriKendaraan] || 0;
            return tarif * this.totalPengunjung;
        },

        formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        }
    }));
});
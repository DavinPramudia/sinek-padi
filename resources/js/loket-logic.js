document.addEventListener('alpine:init', () => {
    Alpine.data('loketTransaksi', (dataTarifDariDB, dataQtyDariDB, urlStore) => ({
        kategoriKendaraan: '', 
        tarifKendaraan: dataTarifDariDB,
        qty: dataQtyDariDB,

        // --- Variabel Modal Print ---
        openPrintModal: false,
        tahap: 'pilih',          // 'pilih' | 'proses' | 'sukses'
        metodePilihan: 'print',  
        urlCetak: '',

        // --- TAMBAHAN BARU: Variabel Modal Alert (Peringatan) ---
        openAlertModal: false,
        alertMessage: '',

        tambah(kategori) { this.qty[kategori]++; },
        kurang(kategori) { if (this.qty[kategori] > 0) this.qty[kategori]--; },

        get totalPengunjung() { return Object.values(this.qty).reduce((total, num) => total + num, 0); },
        get totalBayar() { return this.tarifKendaraan[this.kategoriKendaraan] || 0; },
        formatRupiah(angka) { return 'Rp ' + angka.toLocaleString('id-ID'); },

        bukaModal() {
            // Ubah alert() bawaan menjadi pemanggil modal custom
            if (!this.kategoriKendaraan) {
                this.alertMessage = "Pilih Kategori Kendaraan terlebih dahulu!";
                this.openAlertModal = true; // Buka modal peringatan
                return;
            }
            if (this.totalPengunjung <= 0) {
                this.alertMessage = "Minimal harus memilih 1 kategori wisatawan!";
                this.openAlertModal = true; // Buka modal peringatan
                return;
            }
            this.tahap = 'pilih';
            this.openPrintModal = true;
        },

        async simpanDanCetak() {
            this.tahap = 'proses';

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const response = await fetch(urlStore, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id_tarif: this.kategoriKendaraan,
                        total_bayar: this.totalBayar,
                        total_pengunjung: this.totalPengunjung,
                        metode_cetak: this.metodePilihan,
                        qty_wisatawan: this.qty
                    })
                });

                const data = await response.json();

                if (data.status === 'sukses') {
                    this.tahap = 'sukses';
                    this.urlCetak = data.url_print; 
                } else {
                    // Jika gagal simpan, pakai modal custom juga!
                    this.openPrintModal = false; // Tutup modal print dulu
                    this.alertMessage = 'Gagal menyimpan transaksi!';
                    this.openAlertModal = true;
                    this.tahap = 'pilih';
                }
            } catch (error) {
                console.error("Error:", error);
                // Jika error sistem, pakai modal custom juga!
                this.openPrintModal = false; // Tutup modal print dulu
                this.alertMessage = 'Terjadi kesalahan sistem.';
                this.openAlertModal = true;
                this.tahap = 'pilih';
            }
        },

        resetForm() {
            this.openPrintModal = false;
            this.openAlertModal = false; // Pastikan alert juga keriset
            this.tahap = 'pilih';
            this.kategoriKendaraan = '';
            for (let key in this.qty) {
                this.qty[key] = 0;
            }
            window.location.reload();
        }
    }));
});
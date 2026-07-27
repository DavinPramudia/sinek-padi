document.addEventListener('alpine:init', () => {
    Alpine.data('loketTransaksi', (dataTarifDariDB, dataQtyDariDB, urlStore) => ({
        kategoriKendaraan: '', 
        tarifKendaraan: dataTarifDariDB,
        qty: dataQtyDariDB,
        isSubmitting: false,

        tambah(kategori) { this.qty[kategori]++; },
        kurang(kategori) { if (this.qty[kategori] > 0) this.qty[kategori]--; },

        get totalPengunjung() { return Object.values(this.qty).reduce((total, num) => total + num, 0); },
        get totalBayar() { return this.tarifKendaraan[this.kategoriKendaraan] || 0; },
        formatRupiah(angka) { return 'Rp ' + angka.toLocaleString('id-ID'); },

        async simpanDanCetak() {
            if (!this.kategoriKendaraan) {
                alert("Pilih Kategori Kendaraan terlebih dahulu!");
                return;
            }
            if (this.totalPengunjung <= 0) {
                alert("Minimal harus memilih 1 kategori wisatawan!");
                return;
            }

            this.isSubmitting = true;

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
                        qty_wisatawan: this.qty
                    })
                });

                const data = await response.json();

                if (data.status === 'sukses') {
                    window.open(data.url_print, '_blank');
                    this.resetForm();
                } else {
                    alert('Gagal menyimpan transaksi!');
                }
            } catch (error) {
                console.error("Error:", error);
                alert('Terjadi kesalahan sistem.');
            } finally {
                this.isSubmitting = false;
            }
        },

        resetForm() {
            this.kategoriKendaraan = '';
            for (let key in this.qty) {
                this.qty[key] = 0;
            }
        }
    }));
});
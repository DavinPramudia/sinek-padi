document.addEventListener('alpine:init', () => {
    // Kita menerima 3 data dari blade: data tarif, data qty, dan URL route post
    Alpine.data('loketTransaksi', (dataTarifDariDB, dataQtyDariDB, urlStore) => ({
        isLoading: false, 
        kategoriKendaraan: '', 
        tarifKendaraan: dataTarifDariDB,
        qty: dataQtyDariDB,

        tambah(kategori) {
            this.qty[kategori]++;
        },

        kurang(kategori) {
            if (this.qty[kategori] > 0) {
                this.qty[kategori]--;
            }
        },

        get totalPengunjung() {
            return Object.values(this.qty).reduce((total, num) => total + num, 0);
        },

        get totalBayar() {
            return this.tarifKendaraan[this.kategoriKendaraan] || 0;
        },

        formatRupiah(angka) {
            return 'Rp ' + angka.toLocaleString('id-ID');
        },

        // Fungsi baru untuk mengirim data ke Controller dan membuka tab cetak
        async simpanDanCetak() {
            // 1. Validasi: Pastikan kendaran sudah dipilih
            if (!this.kategoriKendaraan) {
                alert("Pilih Kategori Kendaraan terlebih dahulu!");
                return;
            }

            this.isLoading = true;

            try {
                // 2. Ambil token keamanan Laravel dari <meta>
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // 3. Kirim data (POST) ke LoketController@store
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
                        // Jika Controller butuh menyimpan data wisatawan, kirim array-nya:
                        // detail_wisatawan: this.qty 
                    })
                });

                const data = await response.json();

                // 4. Jika controller merespons 'sukses'
                if (data.status === 'sukses') {
                    // Buka halaman cetak di tab baru menggunakan URL dari controller
                    window.open(data.url_print, '_blank');
                    
                    // Reset form agar siap untuk transaksi berikutnya
                    this.kategoriKendaraan = '';
                    for (let key in this.qty) {
                        this.qty[key] = 0;
                    }
                } else {
                    alert('Gagal menyimpan transaksi!');
                }
            } catch (error) {
                console.error("Error:", error);
                alert('Terjadi kesalahan sistem saat menyimpan transaksi.');
            } finally {
                this.isLoading = false;
            }
        }
    }));
});
// 1. Donut Pendataan Wisatawan Harian
document.addEventListener('DOMContentLoaded', function () {
    const canvasEl = document.getElementById('donutWisatawanChart');
    if (canvasEl) {
        const container = canvasEl.closest('.donut-wisatawan-container');
        const lokal = parseInt(container.dataset.lokal) || 0;
        const nusantara = parseInt(container.dataset.nusantara) || 0;
        const mancanegara = parseInt(container.dataset.mancanegara) || 0;

        const dataValues = (lokal === 0 && nusantara === 0 && mancanegara === 0) ? [1, 1, 1] : [lokal, nusantara, mancanegara];

        new window.Chart(canvasEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Lokal', 'Nusantara', 'Mancanegara'],
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#3aafa9', '#E17055', '#EDEDED'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '75%'
            }
        });
    }
});

// 2. Donut Kategori Kendaraan Harian
document.addEventListener('DOMContentLoaded', function () {
    const canvasEl = document.getElementById('donutKategoriKendaraan');
    if (canvasEl) {
        const container = canvasEl.closest('.donut-kategori-kendaraan-container');
        const motor = parseInt(container.dataset.motor) || 0;
        const mobil = parseInt(container.dataset.mobil) || 0;

        const dataValues = (motor === 0 && mobil === 0) ? [1, 1] : [motor , mobil];

        new window.Chart(canvasEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Motor', 'Mobil'],
                datasets: [{
                    data: dataValues,
                    backgroundColor: ['#3aafa9', '#E17055'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                cutout: '75%'
            }
        });
    }
});

// 3. Line Chart: Tren Kunjungan Harian Perjam
document.addEventListener('DOMContentLoaded', function () {
    const lineEl = document.getElementById('trenChart');
    if (lineEl) {
        const container = lineEl.closest('.line-chart-container');
        const trenData = JSON.parse(container.dataset.tren || '[]');

        // Jika data kosong semua, kita beri data dummy [0,0,0...] atau angka tes agar line chart terbentuk rapi
        const chartData = trenData.length > 0 ? trenData : [0, 0, 5, 12, 25, 30, 20, 15, 10, 5, 2, 0, 0];

        new window.Chart(lineEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00','20:00','21:00'],
                datasets: [{
                    label: 'Kunjungan',
                    data: chartData,
                    borderColor: '#3aafa9',
                    backgroundColor: 'rgba(58, 175, 169, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Membuat garisnya melengkung halus (smooth)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { 
                        grid: { color: '#243733' }, 
                        ticks: { color: '#d1d5dc', font: { size: 10 } } 
                    },
                    y: { 
                        grid: { color: '#243733' }, 
                        ticks: { 
                            color: '#d1d5dc', 
                            font: { size: 10 },
                            stepSize: 5 
                        },
                        beginAtZero: true,
                        suggestedMax: 20
                    }
                }
            }
        });
    }
});
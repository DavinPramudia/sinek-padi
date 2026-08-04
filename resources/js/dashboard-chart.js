// 1. Donut Pendataan Wisatawan Harian
document.addEventListener('DOMContentLoaded', function () {
    const canvasEl = document.getElementById('donutWisatawanChart');
    if (canvasEl) {
        const container = canvasEl.closest('.donut-wisatawan-container');
        const lokal = parseInt(container.dataset.lokal) || 0;
        const nusantara = parseInt(container.dataset.nusantara) || 0;
        const mancanegara = parseInt(container.dataset.mancanegara) || 0;

        // Jika semuanya 0, set ke [0, 0, 0] agar kosong bersih
        const dataValues = (lokal === 0 && nusantara === 0 && mancanegara === 0) ? [0, 0, 0] : [lokal, nusantara, mancanegara];
        const backgroundColors = (lokal === 0 && nusantara === 0 && mancanegara === 0) ? ['#243733', '#243733', '#243733'] : ['#3aafa9', '#E17055', '#EDEDED'];

        new window.Chart(canvasEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Lokal', 'Nusantara', 'Mancanegara'],
                datasets: [{
                    data: dataValues,
                    backgroundColor: backgroundColors,
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

        // Jika keduanya 0, set ke [0, 0] agar kosong bersih
        const dataValues = (motor === 0 && mobil === 0) ? [0, 0] : [motor, mobil];
        const backgroundColors = (motor === 0 && mobil === 0) ? ['#243733', '#243733'] : ['#3aafa9', '#E17055'];

        new window.Chart(canvasEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Motor', 'Mobil'],
                datasets: [{
                    data: dataValues,
                    backgroundColor: backgroundColors,
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
document.addEventListener("DOMContentLoaded", function() {
    const container = document.querySelector('.line-chart-container');
    if (container) {
        const trenData = JSON.parse(container.getAttribute('data-tren') || '[]');
        const labelsData = JSON.parse(container.getAttribute('data-labels') || '[]');
        
        // Ambil nilai max dan step dari atribut HTML
        const maxVal = parseInt(container.getAttribute('data-max')) || 20;
        const stepVal = parseInt(container.getAttribute('data-step')) || 5;

        const ctx = document.getElementById('trenChart').getContext('2d');
        
        if (window.myLineChart) {
            window.myLineChart.destroy();
        }

        window.myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsData,
                datasets: [{
                    label: 'Kunjungan',
                    data: trenData,
                    borderColor: '#3aafa9',
                    backgroundColor: 'rgba(58, 175, 169, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { color: '#243733' },
                        ticks: { color: '#d1d5dc' }
                    },
                    y: {
                        grid: { color: '#243733' },
                        ticks: { 
                            color: '#d1d5dc', 
                            stepSize: stepVal // <-- Mengatur kelipatan angka di sumbu Y
                        },
                        suggestedMax: maxVal, // <-- Mengatur batas minimal nilai maksimal grafik
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
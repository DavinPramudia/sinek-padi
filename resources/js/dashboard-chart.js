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
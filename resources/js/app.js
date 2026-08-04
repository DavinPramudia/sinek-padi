import './bootstrap';
import Alpine from 'alpinejs';
import './loket-logic';

import Chart from 'chart.js/auto';
window.Chart = Chart;

import './dashboard-chart';
import './filter-laporan';

window.Alpine = Alpine;
Alpine.start();
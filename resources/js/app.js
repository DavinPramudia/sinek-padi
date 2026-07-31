import './bootstrap';
import Alpine from 'alpinejs';
import './loket-logic';

import Chart from 'chart.js/auto';
window.Chart = Chart;

import './dashboard-chart';

window.Alpine = Alpine;
Alpine.start();
// ============================================
// DASHBOARD ADMIN - CHARTS
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initAreaChart();
    initPieChart();
    initLineChart();
});

function initAreaChart() {
    const canvas = document.getElementById('pengajuanAreaChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const labels = canvas.dataset.labels ? JSON.parse(canvas.dataset.labels) : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const data = canvas.dataset.data ? JSON.parse(canvas.dataset.data) : [];
    
    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(60,141,188,0.9)');
    gradient.addColorStop(1, 'rgba(60,141,188,0.1)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Pengajuan',
                data: data,
                backgroundColor: gradient,
                borderColor: '#3b8bba',
                pointBackgroundColor: '#3b8bba',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#3b8bba',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true },
                x: { grid: { display: false } }
            }
        }
    });
}

function initPieChart() {
    const canvas = document.getElementById('statusPieChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const proses = parseInt(canvas.dataset.proses || 0);
    const dikirim = parseInt(canvas.dataset.dikirim || 0);
    const selesai = parseInt(canvas.dataset.selesai || 0);
    
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Proses', 'Dikirim', 'Selesai'],
            datasets: [{
                data: [proses, dikirim, selesai],
                backgroundColor: ['#ffc107', '#17a2b8', '#28a745'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: { legend: { display: false } }
        }
    });
}

function initLineChart() {
    const canvas = document.getElementById('pengirimanLineChart');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    const labels = canvas.dataset.labels ? JSON.parse(canvas.dataset.labels) : ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const data = canvas.dataset.data ? JSON.parse(canvas.dataset.data) : [];
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Pengiriman',
                data: data,
                backgroundColor: 'transparent',
                borderColor: '#efefef',
                pointBackgroundColor: '#efefef',
                pointBorderColor: '#17a2b8',
                borderWidth: 2,
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
}
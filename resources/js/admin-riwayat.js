// ============================================
// RIWAYAT PENGIRIMAN - JAVASCRIPT
// ============================================

$(document).ready(function() {
    initDataTable();
    initAlerts();
});

function initDataTable() {
    if ($.fn.DataTable && $('#riwayatTable').length) {
        if ($.fn.DataTable.isDataTable('#riwayatTable')) {
            $('#riwayatTable').DataTable().destroy();
        }
        
        $('#riwayatTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "«",
                    last: "»",
                    next: "›",
                    previous: "‹"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'desc']],
            paging: true,
            searching: true,
            ordering: true,
            columnDefs: [
                { orderable: false, targets: [6, 7] }
            ]
        });
    }
}

function initAlerts() {
    $('.alert').each(function() {
        var $alert = $(this);
        setTimeout(function() {
            $alert.fadeOut(500, function() {
                $alert.remove();
            });
        }, 5000);
    });
}
// ============================================
// DATA MOBIL - JAVASCRIPT
// ============================================

$(document).ready(function() {
    initDataTable();
    initAlerts();
});

function initDataTable() {
    if ($.fn.DataTable && $('#mobilTable').length) {
        if ($.fn.DataTable.isDataTable('#mobilTable')) {
            $('#mobilTable').DataTable().destroy();
        }
        
        $('#mobilTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    next: "›",
                    previous: "‹"
                }
            },
            pageLength: 10,
            responsive: true,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [8] }
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
// ============================================
// DATA DRIVER - ADMINLTE PRO STYLE
// ============================================

$(document).ready(function() {
    // Inisialisasi DataTable
    initDataTable();
    
    // Auto dismiss alert
    initAlerts();
    
    // Tooltips
    initTooltips();
    
    // Delete confirmation with SweetAlert
    initDeleteConfirmation();
});

function initDataTable() {
    if ($.fn.DataTable && $('#driverTable').length) {
        if ($.fn.DataTable.isDataTable('#driverTable')) {
            $('#driverTable').DataTable().destroy();
        }
        
        $('#driverTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json',
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
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
            ordering: true,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [1, 8] },
                { className: 'text-center', targets: [0, 1, 7, 8] }
            ],
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
            }
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

function initTooltips() {
    $('[data-toggle="tooltip"]').tooltip();
}

function initDeleteConfirmation() {
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        var form = $(this).closest('form');
        var driverName = $(this).data('name');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: 'Data driver ' + driverName + ' akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dd4b39',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
}
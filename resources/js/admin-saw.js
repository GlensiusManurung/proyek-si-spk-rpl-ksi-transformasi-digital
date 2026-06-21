// ============================================
// SAW (SPK) - JAVASCRIPT
// ============================================

$(document).ready(function() {
    // Inisialisasi DataTable
    initDataTable();
    
    // Auto dismiss alert
    initAlerts();
    
    // Modal handler untuk kriteria
    initModalHandler();
});

// DataTable
function initDataTable() {
    if ($.fn.DataTable) {
        if ($('#kriteriaTable').length) {
            $('#kriteriaTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 10,
                responsive: true
            });
        }
        
        if ($('#penilaianTable').length) {
            $('#penilaianTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 10,
                scrollX: true,
                columnDefs: [
                    { orderable: false, targets: [0, 1] }
                ]
            });
        }
        
        if ($('#rankingTable').length) {
            $('#rankingTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 10,
                order: [[0, 'asc']]
            });
        }
    }
}

// Auto dismiss alert
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

// Modal handler untuk kriteria (tambah/edit)
function initModalHandler() {
    // Tombol edit
    $('.btn-edit').click(function() {
        var id = $(this).data('id');
        var kode = $(this).data('kode');
        var nama = $(this).data('nama');
        var jenis = $(this).data('jenis');
        var bobot = $(this).data('bobot');
        
        $('#formKriteria').attr('action', '/admin/saw/kriteria/' + id);
        $('#method').val('PUT');
        $('#kode_kriteria').val(kode);
        $('#nama_kriteria').val(nama);
        $('#jenis').val(jenis);
        $('#bobot').val(bobot);
        $('#modalKriteria .modal-title').text('Edit Kriteria');
        $('#modalKriteria').modal('show');
    });
    
    // Reset form setelah modal ditutup
    $('#modalKriteria').on('hidden.bs.modal', function() {
        $('#formKriteria').attr('action', '/admin/saw/kriteria');
        $('#method').val('POST');
        $('#formKriteria')[0].reset();
        $('#modalKriteria .modal-title').text('Tambah Kriteria');
    });
}

// Format angka ke persen
function formatPersen(value) {
    return (value * 100).toFixed(2) + '%';
}

// Export ke global
window.formatPersen = formatPersen;
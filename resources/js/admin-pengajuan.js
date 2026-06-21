// ============================================
// PENGAJUAN - SIMPLE JAVASCRIPT
// ============================================

$(document).ready(function() {
    if ($.fn.DataTable && $('#pengajuanTable').length) {
        if ($('#pengajuanTable tbody tr').length > 0) {
            $('#pengajuanTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 10,
                ordering: true,
                columnDefs: [
                    { orderable: false, targets: [4, 6] }
                ]
            });
        }
    }
    
    $('.alert').each(function() {
        var $alert = $(this);
        setTimeout(function() {
            $alert.fadeOut(500, function() {
                $alert.remove();
            });
        }, 5000);
    });
});

function previewStruk(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview-img').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
// ============================================
// DATA CUSTOMER - SIMPLE JAVASCRIPT
// ============================================

$(document).ready(function() {
    if ($.fn.DataTable && $('#customerTable').length) {
        if ($('#customerTable tbody tr').length > 0) {
            $('#customerTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
                },
                pageLength: 10,
                ordering: true
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
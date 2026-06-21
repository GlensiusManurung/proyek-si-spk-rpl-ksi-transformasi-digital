// ============================================
// BUKTI PENGIRIMAN - JAVASCRIPT
// ============================================

$(document).ready(function() {
    $('#buktiTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json'
        },
        pageLength: 10,
        ordering: true
    });
    
    $('.alert').each(function() {
        var $alert = $(this);
        setTimeout(function() {
            $alert.fadeOut(500, function() {
                $alert.remove();
            });
        }, 5000);
    });
});

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#preview-img').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(input.files[0]);
    }
}
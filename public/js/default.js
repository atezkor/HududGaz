$(function() {
    $('#search').on('search', function() {
        $('tbody tr').show();
    });
});

function search(event) {
    let value = $(event).val().toLowerCase();
    $('tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
}

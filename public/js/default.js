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

function datatable(lang, ...tables) {
    $(function() {
        for (let table of tables) {
            $(`#${table}`).DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": true,
                searching: true,
                language: lang
            });
        }
    });
}

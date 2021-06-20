function search(event) {
    let value = $(event).val().toLowerCase();
    $('tbody tr').filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
}

function fileUpload(reset, file, file_hint, text) {
    $(`#${file}`).change(function(input) {
        try {
            $(`#${file_hint}`).text(input.target.files[0].name);
        } catch (e) {}
    })

    $(`#${reset}`).on('click', function() {
        $(`#${file_hint}`).text(text);
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

// function searchStart() {$(function() {$('#search').on('search', function() {$('tbody tr').show();});});}

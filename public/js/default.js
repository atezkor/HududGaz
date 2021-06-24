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

function ajax(url, data = {}, callback, datatype = 'html') {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: url,
        method: 'POST',
        dataType: datatype,
        data: data,
        success: function(data, status) {
            callback(data, status);
        }
    });
}

function toast(message, type) {
    if (!message)
        return;

    if (!type)
        type = 'success';

    $(function() {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        Toast.fire({
            icon: type,
            title: message
        });
    });
}

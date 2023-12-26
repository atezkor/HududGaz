function toast(message, type, time = 3000) {
    if (!message)
        return;

    if (!type)
        type = 'success';

    $(function() {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: time
        });

        Toast.fire({
            icon: type,
            title: message
        });
    });
}

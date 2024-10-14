var Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
Livewire.on('message', function(message) {
    if (message.code == 200) {
        Toast.fire({
            icon: 'success',
            title: message.content
        });
    } else if (message.code == 500) {
        Toast.fire({
            icon: 'info',
            title: message.content
        });
    }
})
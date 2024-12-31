function evaluatebuttonPermissions(columnAttributes, permissions, buttonsTemplate) {

    if (permissions.can_edit || permissions.can_delete) {
        columnAttributes.push({
            "data": null,
            "render": function (data, type, row, meta) {
                buttons = '';

                if (permissions.can_edit) {
                    buttons += buttonsTemplate.edit.replace(':id', data.id);
                }
                if (permissions.can_delete) {
                    buttons += buttonsTemplate.delete;
                }

                return (
                    `<div class="d-flex flex-row justify-content-center">
                        ${buttons}
                    </div>`
                );
            },
            searchable: false,
            orderable: false
        });
    }
}

// exampleRoute: "{{ route('admin.offices.data') }}"
function applyDataTable(tableName, dataUrl, columnAttributes, columnDefs = [], responsive = true, layout = {}) {
    return $(`#${tableName}`).DataTable({
        ajax: {
            "url": dataUrl,
            "type": "GET",
            "dataSrc": "",
        },
        columns: columnAttributes,
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
        },
        columnDefs: columnDefs,
        responsive: responsive,
        layout: layout
    });
}

//exampleRoute: "{{ route('admin.offices.destroy') }}"
//exampleCsrfToken: "{{ csrf_token() }}"
function deleteElement(url, token, table, data) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar!',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                dataType: 'json',
                data: {
                    "_token": token,
                    id: data["id"],
                }
            }).done(function (response) {
                if (response.code == '200') {
                    table.ajax.reload();
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                } else if (response.code == '500') {
                    Toast.fire({
                        icon: 'info',
                        title: response.message
                    });
                }
            });
        }
    })
}
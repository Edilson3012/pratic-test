function deleteConfirmation(id) {
    Swal.fire({
        title: "Vai excluir mesmo?",
        text: "Deseja realmente excluir este registro?",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Sim, tenho certeza!",
        cancelButtonText: "Ops, vou não!",
        reverseButtons: !0
    }).then(function (e) {
        if (e.value === true) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: 'DELETE',
                url: `/admin/people/${id}`,
                data: {
                    _token: CSRF_TOKEN
                },
                dataType: 'JSON',
                success: function (results) {
                    if (results.type == 'success') {
                        Swal.fire(
                            'Excluído!',
                            results.message,
                            'success'
                        );
                        $('#line-people-' + id).remove();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ops...',
                            text: results.message,
                        });
                    }
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Ops...',
                text: 'Exclusão cancelada',
            });
            iziToast.info({
                title: 'INFO',
                message: 'Registro não foi excluído.',
                icon: '',
                iconText: '',
                iconColor: '',
                iconUrl: null,
                position: 'topRight', // bottomRight, bottomLeft, topRight,
            });
        }
    }, function (dismiss) {
        return false;
    })
}

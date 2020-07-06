$(function () {
    var rolesTable = $("#roles-data").DataTable({
        language: frLang,
        responsive: true,
        info: false,
        processing: true,
        serverSide: true,
        searching: false,
        ajax: 'getRoles',
        columns: [
            {data: 'name', name: 'name', title: 'Nom', class: 'capitalize'},
            {data: 'description', name: 'description', title: 'Description', class: 'capitalize'},
            {data: 'users_count', name: 'users_count', title: 'Utilisateurs', class: 'capitalize'},
            {
                data: 'id', name: 'id', title: 'Options',
                render: function (data, type, full, meta) {
                    return `<a href="${APP_URL}/roles/${data}" class="align-center blue d-block"><i class="far fa-edit big-icon-fz"></i></a>`;
                }
            },
        ]
    });

    $('#roles-data').on('click', '.delete-role', function () {
        var confirmed = confirm('Are you sure ?');
        if (confirmed) {
            role_id = $(this).attr('data-role');
            element = this;
            $.ajax({
                method: 'DELETE',
                url: APP_URL + '/roles/' + role_id,
                success: function (response) {
                    feedBack(response.message, 'success');
                    removeElement(element);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 401 || jqXHR.status === 422) {
                        feedBack(jqXHR.responseJSON.message, 'error');
                    }
                }
            });
        }
    });

    function removeElement(element) {
        $('#roles-data #role-' + role_id).addClass('danger');
        setTimeout(() => {
            var index = element.parentNode.parentNode.rowIndex;
            // document.getElementById("users-data").deleteRow(index);
            rolesTable.row($(this).parents('tr'))
                .remove()
                .draw();
        }, 200);
    }

    function feedBack(message, status) {
        swal(
            status.replace(/^\w/, c => c.toUpperCase()) + '!',
            message,
            status
        )
    }
});

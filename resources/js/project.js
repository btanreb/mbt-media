$( document ).ready(function () {

    $('#multi-add').click(function () {
        const select = $('<select class="form-control" name="clientIds[]"></select>');
        const div = $('<div class="select-wrapper"></div>');
        const destroyIcon = $('<button type="button" class="btn btn-default destroy-select"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button>');

        clients.forEach(function (client, index) {
            $(select).append(new Option(client.name, client.id));
        });

        div.append(select);
        div.append(destroyIcon);

        $('#selects').append(div);

        $('#selects .destroy-select').attr('disabled', false);

        getSelectedOptions();
    });

    $('#selects').on('click', '.destroy-select', function () {
        if ($('#selects select').length <= 1) {
            return;
        }

        $(this).parent().remove();

        if ($('#selects select').length <= 1) {
            $('#selects .destroy-select').attr('disabled', true);
        }

        getSelectedOptions();
    });

    $('#selects').on('change', 'select', function () {
        getSelectedOptions();
    });

});

function getSelectedOptions()
{
    selectedClientsJs = [];
    $('select option:selected').each(function (index, select) {
        selectedClientsJs.push(Number($(this).val()));
    });

    const data = {
        clientIds: selectedClientsJs,
    };

    if (projectId != null) {
        data.projectId = projectId;
    }

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        url: '/client/clients-logos',
        method: 'POST',
        data: data
    })
    .done(res => {
        $('#project-logos').html(res);
    });
}

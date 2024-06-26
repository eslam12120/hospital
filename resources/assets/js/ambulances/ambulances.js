'use strict';

Livewire.hook("element.init", ({component}) => {
    if(component.name == 'ambulance-table'){
        $('#ambulance_filter_status').select2({
            width: "100%",
        });
    }
});

listen('click', '.ambulance-delete-btn', function (event) {
    let ambulanceId = $(event.currentTarget).attr('data-id');
    deleteItem($('#indexAmbulanceUrl').val() + '/' + ambulanceId, '', $('#Ambulance').val());
});

listenChange('.ambulance-status', function (event) {
    let ambulanceId = $(event.currentTarget).attr('data-id');
    statusAmbulance(ambulanceId);
});

function statusAmbulance(id) {
    $.ajax({
        url: $('#indexAmbulanceUrl').val() + '/' + id + '/active-deactive',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                // tbl.ajax.reload(null, false);
                Livewire.dispatch('refresh');
            }
        },
    });
}

listenChange('#ambulance_filter_status', function () {
    Livewire.dispatch('changeFilter',  {statusFilter : $(this).val()})
});

listenClick('#ambulanceResetFilter', function () {
    $('#ambulance_filter_status').val(0).trigger('change');
    hideDropdownManually($('#ambulanceFilterBtn'), $('.dropdown-menu'));
});

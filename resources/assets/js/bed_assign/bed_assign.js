'use strict';

Livewire.hook("element.init", ({component}) => {
    if(component.name == 'bed-assign-table'){
        $('#bed_assigns_filter_status').select2({
            width: '100%',
        });
    }
});

listenClick('.bed-assign-delete-btn', function (event) {
    let bedAssignId = $(event.currentTarget).attr('data-id');
    deleteItem($('#bedAssignUrl').val() + '/' + bedAssignId, '',
        $('#bedAssign').val());
});

listenChange('.bed-assign-status', function (event) {
    let bedAssignId = $(event.currentTarget).attr('data-id');
    updateBedAssignStatus(bedAssignId);
});

listen('click', '#bedAssignResetFilter', function () {
    $('#bed_assigns_filter_status').val(0).trigger('change');
    hideDropdownManually($('#bedAssignFilterBtn'), $('.dropdown-menu'));
});

listenChange('#bed_assigns_filter_status', function () {
    Livewire.dispatch('changeFilter', {statusFilter: $(this).val()})
});

 function updateBedAssignStatus(id) {
    $.ajax({
        url: $('#bedAssignUrl').val() + '/' + +id + '/active-deactive',
        method: 'post',
        cache: false,
        success: function (result) {
            if (result.success) {
                displaySuccessMessage(result.message);
                Livewire.dispatch('refresh')
            }
        },
    });
}

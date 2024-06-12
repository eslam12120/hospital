document.addEventListener('turbo:load', loadDoctorHolidayDetails)

function loadDoctorHolidayDetails () {

    let lang = $('.currentLanguage').val()

    $('#doctorHolidayDate').flatpickr({
        'locale': lang,
        minDate: new Date().fp_incr(1),
        disableMobile: true,
    })
}

listenClick('.holiday-delete-btn', function (event) {
    let holidayRecordId = $(event.currentTarget).attr('data-id')
    deleteItem(route('doctors.holiday-destroy', holidayRecordId), Lang.get('js.holiday'))
});

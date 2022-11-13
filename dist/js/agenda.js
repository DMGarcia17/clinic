var agenda;

/** Add new event to calendar (just visual)
 * @param {string} title: Event title
 * @param {date} startDate: Start date for the event
 * @param {date} endDate: Finish date for the event
 * @param {string} eventColor: Color for the event
 */
let addEventToCalendar = (title, startDate, endDate, eventColor) => {
    agenda.addEvent({
        title: title,
        start: startDate,
        end: endDate,
        color: eventColor
      });
};

$(() => {

    /** Init the calendar object */
    var Calendar = FullCalendar.Calendar;
    let calendarEl = document.getElementById('calendar');

    agenda = new Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next,today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
            themeSystem: 'bootstrap',
            editable: true,
            droppable: true
        },
        locale: 'es'
    });

    agenda.render();

    /** Validation for add patient visits */
    $('#addVisitForm').validate({
        onfocusout: false,
        rules: {
            namev: {
                required: true,
                minlength: 1,
                maxlength: 200
            },
            startv: {
                required: true
            },
            endv: {
                required: true
            }
        },
        messages: {
            namev: "Por favor ingrese un nombre v&aacute;lido, con un ancho entre 1 y 200 caracteres."
        },
        submitHandler: function(form) {
            //save();
            addEventToCalendar($('#namev').val(), $('#startv').val(), $('#endv').val(), '#32a8a2')
            console.log($('#startv').val());
            
        $('#addVisit').modal('toggle');
            //resetForm();
          }
    });

    /** Add toggle function for buttons */
    $('#btnAddVisit').click(()=>{
        $('#addVisit').modal('toggle');
    });

    
    $('#calendarTag').addClass('active');
    

})
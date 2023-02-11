var agenda;
const process = '../Controllers/CalendarController.php';

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

let createEvent = () => {
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : $('#id').val(),
                    'name' : $('#namev').val(),
                    'start' : $('#startv').val(),
                    'end' : $('#endv').val(),
                    'function' : 'sc'
                },
        success: function (res) {
            
            let Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
                });

                Toast.fire({
                icon: 'success',
                title: 'Datos guardados!'
                });

                
                $('#add').modal('toggle');


        }
        });
}

let load = () => {
    $.ajax({
        type  : 'post',
        url   : process,
        success: function (res) {
            let json = JSON.parse(res);
            $.each(json, (i, item) => {
                addEventToCalendar(item['cod_event']+' - '+item['name'], item['start_at'], item['end_at'], '#32a8a2');
            });
        }
      });
}

let loadEvent = (id) => {
    $('#addVisit').modal('toggle');
    $.ajax({
        type  : 'post',
        url   : process,
        data  : {
                    'ID' : id,
                    'function' : 'ec'
                },
        success: function (res) {
            let json = JSON.parse(res);
            $('#id').val(json[0]['cod_event']);
            $('#namev').val(json[0]['name']);
            $('#startv').val(json[0]['start_at']);
            $('#endv').val(json[0]['end_at']);
        }
      });
}

let init = () => {
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
        locale: 'es',
        eventClick: function(info) {
            /*alert('Event: ' + info.event.title);
            alert('Coordinates: ' + info.jsEvent.pageX + ',' + info.jsEvent.pageY);
            alert('View: ' + info.view.type);*/

            loadEvent(info.event.title.split('-')[0].trim());
            // change the border color just for fun
            info.el.style.borderColor = 'red';
          }
    });

    agenda.render();
}

$(() => {
    init();
    load();
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
            createEvent();
            
            //addEventToCalendar($('#namev').val(), $('#startv').val(), $('#endv').val(), '#32a8a2');
            agenda.Destroy();
            init();
            $('#addVisitForm').trigger("reset");
        $('#addVisit').modal('toggle');
            //resetForm();
          }
    });

    /** Add toggle function for buttons */
    $('#btnAddVisit').click(()=>{
        $('#addVisit').modal('toggle');
    });

    /** Add toggle function for buttons */
    $('#btnAddEvent').click(()=>{
        $('#addVisit').modal('toggle');
    });

    
    $('#calendarTag').addClass('active');
    

})
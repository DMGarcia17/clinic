var agenda;

let addEventToCalendar = (startDate, endDate) => {
    agenda.addEvent({
        title: 'dynamic event',
        start: startDate,
        end: endDate,
        allDay: true
      });
};

$(() => {
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
})
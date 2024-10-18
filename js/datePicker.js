
    $(function() {
        $("#fecha").datepicker({
            minDate: 1, // Establece la fecha mínima como mañana
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [(day != 0 && day != 6), ''];
            }
        })
    });
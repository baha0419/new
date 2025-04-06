document.addEventListener('DOMContentLoaded', function() {
    $('#studentsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn-export' },
            { extend: 'csv',  text: 'CSV',  className: 'btn-export' },
            { extend: 'pdf',  text: 'PDF',  className: 'btn-export' }
        ],
        language: {
            search: "Filtrer (DataTables):",
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/fr-FR.json'
        },
        // Active le filtrage côté client
        initComplete: function() {
            $('.dataTables_filter input').unbind().bind('input', function() {
                this.value && $('.php-filter').hide(); // Cache le filtre PHP si on utilise DataTables
            });
        }
    });
});
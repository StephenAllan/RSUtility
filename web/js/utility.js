$(document).ready(function () {
    // JQuery Elements
    this.$table = $('#itemTable');

    // DataTable Configuration
    this.$table.DataTable({
        "order": [ 3, 'desc' ],
        "pageLength": 50,
        "lengthMenu": [ 10, 20, 50, 100, 1000, 10000 ]
    });

    window.setTimeout(function() { window.location.reload(); }, 10 * 60 * 1000);
});

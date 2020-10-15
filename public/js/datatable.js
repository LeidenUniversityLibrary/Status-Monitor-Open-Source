$(document).ready(function () {
    //SECTION Datatable
    //Datatable options go here!
    $('#datatablex').DataTable({
        "responsive": true,
        "processing": true,
        "order": [
            [1, "asc"]
        ],
        "columnDefs": [{
                responsivePriority: 1,
                targets: 2
            },
            {
                responsivePriority: 2,
                targets: -1
            },
            {
                targets: [0, 1, 2],
                className: 'dt-body-center'
            }
        ]
    });
});

// Normalize special charachters.
$.fn.DataTable.ext.type.search.string = function (data) {
    return !data ?
        '' :
        typeof data === 'string' ?
        data
        .replace(/[áÁàÀâÂäÄãÃåÅæÆ]/g, 'a')
        .replace(/[çÇ]/g, 'c')
        .replace(/[éÉèÈêÊëË]/g, 'e')
        .replace(/[íÍìÌîÎïÏîĩĨĬĭ]/g, 'i')
        .replace(/[ñÑ]/g, 'n')
        .replace(/[óÓòÒôÔöÖœŒ]/g, 'o')
        .replace(/[ß]/g, 's')
        .replace(/[úÚùÙûÛüÜ]/g, 'u')
        .replace(/[ýÝŷŶŸÿ]/g, 'n') :
        data;
};
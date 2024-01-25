"use strict";

$(document).ready(function () {
    $('#bootstrap-data-table').on('click', '.delete', function () {
        var href = $(this).attr('data-href');
        swal({
            title: "Are you sure?",
            text: "Your will not be able to recover this data.",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "No",
                    value: false,
                    visible: true,
                    className: 'btn btn-default',
                    closeModal: true,
                },
                confirm: {
                    text: "Yes",
                    value: true,
                    visible: true,
                    className: 'btn btn-danger',
                    closeModal: true
                }
            }
        }).then(function (isConfirm) {
            if (isConfirm) {
                window.location.href = './' + href
            }
        });
    });
});
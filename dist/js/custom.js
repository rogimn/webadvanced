/*jslint browser: true*/
/*jslint node: true*/
/*jslint browser: true*/
/*jslint es6*/
/*global $, jQuery, alert, btoa*/

$(document).ready(function () {
    'use strict';

    const fade = 150, swalButton = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        buttonsStyling: true
    });

    // TOOLTIP GLOBAL

    $('[data-toggle="tooltip"], .td-action span a, .blockquote-data p a, div a, td span a, span a').tooltip({
        boundary: 'window'
    });

    // LOGOUT

    $('.navbar-nav').on('click', '.a-logout-app', function(e) {
        e.preventDefault();
        
        swalButton.fire({
            icon: 'question',
            title: 'Sair do App',
            showCancelButton: true,
            confirmButtonText: 'Sim',
            cancelButtonText: 'Não',
        }).then((result) => {
            if(result.value == true) {
                location.href = '../appLogout.php';
            }
        });
    });

    /// SEARCH

    $('.form-search').on('click', function () {
        $('.page-search').fadeIn(fade);
        $('.div-search-close').fadeIn(fade);
    });

    $('.icon-search-close').on('click', function () {
        $('.page-search').fadeOut(fade);
        $('#search_keyword').val('');
        $('#search-result').empty();
        $('.div-search-close').fadeOut(fade);
    });

    $('#search_keyword').keyup(function () {
        /*let that = this,
            value = $(this).val(),
            minlength = 4;*/

        let value = $('#search_keyword').val(),
            minlength = 4;

        if (value.length >= minlength) {
            $.ajax({
                type: 'GET',
                url: 'api/servico/search.php',
                data: {'search_keyword': value},
                dataType: 'text',
                cache: false,
                beforeSend: function () {
                    $('#search-result').empty().append('<p style="position: relative;top: 15px;" class="lead"><i class="fas fa-cog fa-spin"></i> Processando...</p>');
                },
                /*error: function(result) {
                    $('.page-search').fadeOut(fade);
                    Swal.fire({icon: 'error',html: result.responseText,showConfirmButton: false});
                },*/
                success: function (data) {
                    //we need to check if the value is the same
                    if (value === $('#search_keyword').val()) {
                        $('#search-result').html(data);
                    }
                }
            });
        }

        if ($('#search_keyword').val() === '') {
            $('#search-result').empty();
        }
    });
});
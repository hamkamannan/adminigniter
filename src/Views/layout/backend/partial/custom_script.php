<script>
    /* Close Sidebar */
    $('.close-sidebar-btn').click(function() {
        var classToSwitch = $(this).attr('data-class');
        var containerElement = '.app-container';
        $(containerElement).toggleClass(classToSwitch);

        var closeBtn = $(this);

        if (closeBtn.hasClass('is-active')) {
            closeBtn.removeClass('is-active');
        } else {
            closeBtn.addClass('is-active');
        }
    });

    /* Toaster */
    var toastr_msg = '<?= get_message('toastr_msg'); ?>';
    var toastr_type = '<?= get_message('toastr_type'); ?>';
    if (toastr_msg.length > 0) {
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": true,
            "progressBar": true,
            "positionClass": "toast-top-full-width",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr[toastr_type](toastr_msg, "Information");
    }

    /* Magnific Popup */
    $('.ajax-popup-link').magnificPopup({
        type: 'iframe',
        iframe: {
            markup: '<style>.mfp-iframe-holder .mfp-content {max-width: 95%;height:95%}</style>' +
                '<div class="mfp-iframe-scaler" >' +
                '<div class="mfp-close"></div>' +
                '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                '</div></div>'
        },
    });

    $('.image-link').magnificPopup({
        type: 'image'
    });

    function setDataTable(dom, disableOrderCols = [4, 6, 7], defaultOrderCols = [0, 'asc'], autoNumber = false) {
        var t = $(dom).DataTable({
            "oLanguage": {
                "sSearch": "<?= lang('App.tbl.search'); ?>: _INPUT_",
                "sLengthMenu": "_MENU_ <?= lang('App.tbl.entries'); ?>",
                "sInfo": "<?= lang('App.tbl.showing'); ?> _START_ <?= lang('App.tbl.to'); ?> _END_ <?= lang('App.tbl.from'); ?> _TOTAL_ <?= lang('App.tbl.entries'); ?>",
                "oPaginate": {
                    "sNext": "<?= lang('App.tbl.next'); ?>",
                    "sPrevious": "<?= lang('App.tbl.previous'); ?>",
                }
            },
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": disableOrderCols
            }],
            "order": [
                defaultOrderCols
            ]
        });

        if (autoNumber) {
            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        }
    }

    function setParameter(name, value) {
        var data_post = {
            name: name,
            value: value,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>',
        };

        $('.loading').show();

        $.ajax({
                url: '<?= base_url('api/param/create') ?>',
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                window.location.reload();
            })
            .fail(function(res) {
                Swal.fire({
                    title: 'Oups',
                    text: 'Parameter gagal disimpan',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 3000
                });
            })
            .always(function() {
                $('.loading').hide();
            });

        return false;
    }
</script>
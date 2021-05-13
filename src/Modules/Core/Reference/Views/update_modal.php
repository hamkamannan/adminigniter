<?php
$baseModel = new \App\Models\BaseModel();
$request = \Config\Services::request();
$request->uri->setSilent();
$menu_id = $request->getVar('menu_id') ?? 0;
?>

<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="header-icon lnr-pencil icon-gradient bg-plum-plate"> </i> Ubah Reference
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_edit" method="post" data-action="<?= base_url('api/reference/edit') ?>" data-id="">
                <div class="modal-body">
                    <div id="frm_edit_message"></div>
                    <div class="form-row">
                        <div class="col-md-8">
                            <div class="position-relative form-group">
                                <label for="name">Label*</label>
                                <div>
                                    <input type="text" class="form-control" id="frm_edit_name" name="name" placeholder="Label" value="<?= set_value('name'); ?>" />
                                    <small class="info help-block text-muted">Label Referensi</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label for="sort">Urutan</label>
                                <div>
                                    <input type="number" class="form-control" id="frm_edit_sort" name="sort" placeholder="Urutan" value="<?= set_value('sort') ?>" />
                                    <small class="info help-block text-muted">Urutan Referensi</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Keterangan</label>
                        <div>
                            <textarea id="frm_edit_description" name="description" placeholder="Keterangan" rows="2" class="form-control autosize-input" style="min-height: 38px;"><?= set_value('description') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="menu_id" value="<?=$menu_id?>">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('App.btn.close') ?></button>
                    <button type="submit" class="btn btn-primary" name="submit"><?= lang('App.btn.save') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('.show-data').click(function() {
        // Dropzone.autoDiscover = false;
        var url = $(this).attr('data-href');
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                $('#frm_edit').attr("data-id", response.id);
                $('#frm_edit_name').val(response.name);
                $('#frm_edit_sort').val(response.sort);
                $('#frm_edit_description').val(response.description);

                $('#modal_edit').modal('show');
            }
        });
    });

    $('#modal_edit').on('hidden.bs.modal', function(event) {
        $(this).find('form').trigger('reset');
        $('#frm_edit_message').html('');
    });

    $('#modal_edit').on('shown.bs.modal', function(event) {
        // event.preventDefault();

    });

    $('#frm_edit').submit(function(event) {
        event.preventDefault();
        var data_post = $(this).serializeArray();
        var url = $(this).data('action') + '/' + $(this).data('id');

        $('.loading').show();

        $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                console.log(res)
                if (res.status === 201) {
                    if(res.error == null) {
                        Swal.fire({
                            title: 'Success',
                            text: 'Reference berhasil diubah',
                            type: 'success',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }

                    setTimeout(function() {
                        window.location.href = '<?= base_url('reference?menu_id='.$menu_id) ?>';
                    }, 2000);
                } else {
                    $('#frm_edit_message').html(res.messages.error);
                }
            })
            .fail(function(res) {
                console.log(res);
                $('#frm_edit_message').html(res.responseJSON.messages.error);
            })
            .always(function() {
                $('.loading').hide();
            });

        return false;
    });
</script>
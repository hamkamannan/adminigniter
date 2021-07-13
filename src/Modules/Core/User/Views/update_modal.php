<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="header-icon lnr-pencil icon-gradient bg-plum-plate"> </i> Ubah Profil User
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_edit" method="post" data-action="<?= base_url('api/user/edit/' . $user->id) ?>">
                <div class="modal-body">
                    <div id="frm_edit_message"></div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="username">Username*</label>
                                <div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="<?= lang('User.label.username') ?>" value="<?= $user->username ?: ''; ?>" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="email">Email*</label>
                                <div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?= lang('User.label.email') ?>" value="<?= $user->email ?: ''; ?>" readonly />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="first_name">Nama Depan</label>
                                <div>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="<?= lang('User.label.first_name') ?>" value="<?= $user->first_name ?: ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="last_name">Nama Belakang</label>
                                <div>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang" value="<?= $user->last_name ?: ''; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="phone">No. Telepon</label>
                                <div>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="No. Telepon" value="<?= $user->phone ?: ''; ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="unit">Unit Kerja</label>
                                <div>
                                    <input type="text" class="form-control" id="unit" name="unit" placeholder="Unit Kerja" value="<?= $user->unit ?: ''; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="company">Institusi</label>
                                <div>
                                    <input type="text" class="form-control" id="company" name="company" placeholder="Institusi" value="<?= $user->company ?: ''; ?>" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="address">Alamat</label>
                                <div>
                                    <textarea id="address" name="address" placeholder="Alamat" rows="2" class="form-control autosize-input" style="min-height: 38px;"><?= $user->address ?: ''; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
                                <small class="info help-block"><?= lang('User.info.update.password') ?> </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="pass_confirm">Konfirmasi Password</label>
                                <div>
                                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" placeholder="Konfirmasi Password" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (is_admin()) : ?>
                        <div class="position-relative form-group">
                            <label for="groups">Group*</label>
                            <div>
                                <?php foreach ($groups as $group) : ?>
                                    <div class="custom-checkbox custom-control custom-control-inline">
                                        <input type="checkbox" id="groups<?= $group->id ?>" name="groups[]" value="<?= $group->id ?>" class="custom-control-input" <?= (in_array($group->name, $currentGroups)) ? 'checked="checked"' : '' ?>>
                                        <label class="custom-control-label" for="groups<?= $group->id ?>"><?= $group->name ?></label>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif ?>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('App.btn.close'); ?></button>
                    <button type="submit" class="btn btn-primary" name="submit"><?= lang('App.btn.save'); ?></button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    var is_profile = '<?= $is_profile ?>';
    $('#frm_edit').submit(function(event) {
        event.preventDefault();
        var data_post = $(this).serializeArray();
        var url = $(this).data('action');

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
                    Swal.fire({
                        title: 'Success',
                        text: '<?= lang('User.info.success.profile') ?>',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(function() {
                        if (is_profile == true) {
                            window.location.href = '<?= base_url('user/profile') ?>';
                        } else {
                            window.location.href = '<?= base_url('user/detail/' . $user->id) ?>';
                        }

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
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
            });

        return false;
    });
</script>
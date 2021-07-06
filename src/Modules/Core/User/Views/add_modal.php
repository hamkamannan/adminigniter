<div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="header-icon lnr-plus-circle icon-gradient bg-plum-plate"> </i> <?= lang('User.btn.create'); ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_create" method="post" action="">
                <div class="modal-body">
                    <div id="frm_create_message"></div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="username">Username*</label>
                                <div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="position-relative form-group">
                                <label for="email">Email*</label>
                                <div>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?= set_value('email'); ?>" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="password">Password*</label>
                                <div class="input-group" id="show_hide_password">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" >
                                    <div class="input-group-append">
                                        <a class="btn btn-primary" href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                                <!-- <span id="strength">Type Password</span><br> -->
                                <small class="info help-block">Password Security Policy:
                                    <ul>
                                        <li id="firstRegex">Password diawali huruf kapital (A-Z)</li>
                                        <li>Password mengandung minimal 1 angka (0-9)</li>
                                        <li>Password mengandung minimal 1 karakter spesial (!@#%)</li>
                                        <li>Password memiliki panjang 8-15 karakter</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label for="password">Konfirmasi Password*</label>
                                <div class="input-group" id="show_hide_password_confirm">
                                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Konfirmasi Password" />
                                    <div class="input-group-append">
                                        <a class="btn btn-primary" href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('App.btn.close'); ?></button>
                    <button type="submit" class="btn btn-primary" name="submit"><?= lang('App.btn.save'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script language="javascript">
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });

        $("#show_hide_password_confirm a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_confirm input').attr("type") == "text"){
                $('#show_hide_password_confirm input').attr('type', 'password');
                $('#show_hide_password_confirm i').addClass( "fa-eye-slash" );
                $('#show_hide_password_confirm i').removeClass( "fa-eye" );
            }else if($('#show_hide_password_confirm input').attr("type") == "password"){
                $('#show_hide_password_confirm input').attr('type', 'text');
                $('#show_hide_password_confirm i').removeClass( "fa-eye-slash" );
                $('#show_hide_password_confirm i').addClass( "fa-eye" );
            }
        });
    });

    function passwordChanged() {
        var strength = document.getElementById('strength');
        var firstRegex = new RegExp("^(?=.*[A-Z]).*$", "g");
        var enoughRegex = new RegExp("(?=.{8,15}).*", "g");
        var numberRegex = new RegExp("^(?=.{8,15})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*$", "g");
        var strongRegex = new RegExp("^(?=.{8,15})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");

        var pwd = document.getElementById("password");
        if (pwd.value.length == 0) {
            strength.innerHTML = 'Type Password';
        }
        else if (false == firstRegex.test(pwd.value)) 
        {
            strength.innerHTML = 'Huruf Awal Kapital';
        } 
        else if (false == enoughRegex.test(pwd.value)) 
        {
            strength.innerHTML = 'Panjang minimal 8-15 karakter';
        } 
        else if (false == numberRegex.test(pwd.value)) 
        {
            strength.innerHTML = 'Minimal mengandung 1 angka';
        } 
        else if (false == strongRegex.test(pwd.value)) 
        {
            strength.innerHTML = 'Minimal mengandung 1 spesial karakter';
        } 
        else {
            strength.innerHTML = '<span style="green:red">OK</span>';
        }
    }
</script>
<script>
    $('#frm_create').submit(function(event) {
        event.preventDefault();
        var data_post = $(this).serializeArray();

        $('.loading').show();

        $.ajax({
                url: '<?= base_url('api/user/create') ?>',
                type: 'POST',
                dataType: 'json',
                data: data_post,
            })
            .done(function(res) {
                console.log(res)
                if (res.status === 201) {
                    Swal.fire({
                        title: 'Success',
                        text: '<?= lang('User.info.success.create') ?>',
                        type: 'success',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(function() {
                        window.location.href = '<?= base_url('user') ?>';
                    }, 2000);
                } else {
                    $('#frm_create_message').html(res.messages.error);
                }
            })
            .fail(function(res) {
                console.log(res);
                $('#frm_create_message').html(res.responseJSON.messages.error);
            })
            .always(function() {
                $('.loading').hide();
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 2000);
            });

        return false;
    });

    $('#modal_create').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $('#frm_create_message').html('');
    });
</script>
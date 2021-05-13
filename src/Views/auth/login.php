<?php
if (!function_exists('get_parameter')) {
  function get_parameter($param = null, $default = null)
  {
      $app = new \App\Libraries\App();
      return $app->getParameter($param, $default);
  }
}
?>

<?= $this->extend('layout/backend/blank'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-container">
    <div class="h-100 bg-plum-plate bg-animation">
        <div class="d-flex h-100 justify-content-center align-items-center">
            <div class="mx-auto app-login-box col-md-8">
                <div class="app-logo-inverse mx-auto mb-3"></div>
                <div class="modal-dialog w-100 mx-auto">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="h5 modal-title">
                                <?=lang('Auth.loginTitle')?>
                                <h6 class="mt-1 mb-0 opacity-8"><span><?=get_parameter('site-name')?></span></h6>
                            </div>
                        </div>

                        <form class="" action="<?= route_to('login') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="modal-body">
                            <div id="infoMessage">
                                <?= view('Myth\Auth\Views\_message_block') ?>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <input type="text" class="form-control <?php if(session('errors.login')) : ?>is-invalid<?php endif ?>" name="login" placeholder="<?=lang('Auth.emailOrUsername')?>" >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="position-relative form-group">
                                        <input type="password" class="form-control <?php if(session('errors.password')) : ?>is-invalid<?php endif ?>" name="password"  placeholder="<?=lang('Auth.password')?>" >
                                    </div>
                                </div>
                            </div>

                            <?php if ($config->allowRemembering): ?>
                            <div class="position-relative form-check">
                                <input name="remember" id="remember" type="checkbox" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
                                <label for="remember" class="form-check-label"><?=lang('Auth.rememberMe')?></label>
                            </div>
                            <?php endif; ?>

                            <div class="divider"></div>

                            <?php if ($config->allowRegistration) : ?>
                            <h6 class="mb-0">
                                <a href="<?= route_to('register') ?>" class="text-primary"><?=lang('Auth.needAnAccount')?></a>
                            </h6>
                            <?php endif; ?>
                        </div>
                        <div class="modal-footer clearfix">
                            <?php if ($config->activeResetter): ?>
                            <div class="float-left">
                                <a href="<?= route_to('forgot') ?>" class="btn-lg btn btn-link"><?=lang('Auth.forgotYourPassword')?></a>
                            </div>
                            <?php endif; ?>

                            <div class="float-right">
                                <button type="submit" class="btn btn-primary btn-lg"><?=lang('Auth.loginAction')?></button>
                            </div>
                        </div>
                        
                        </form>
                    </div>
                </div>
                <div class="text-center text-white opacity-8 mt-3"><?=get_parameter('site-copyright', '&copy; 2021 Adminigiter')?></div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page'); ?>
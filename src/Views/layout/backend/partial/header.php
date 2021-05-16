<style>
    .app-header__logo .site-name {
        font-size: 18px;
        margin: .75rem 0;
        font-weight: 700;
        color: #fff;
        white-space: nowrap;
        position: relative;
    }
</style>

<div class="app-header <?= get_parameter('header-cs-class'); ?>">
    <div class="app-header__logo">
        <div class="logo-src site-name">
            <a style="text-decoration: none; padding-right:9px; padding-bottom:3px;" href="<?= base_url() ?>" class="<?= get_parameter('text-cs-class', 'text-white'); ?>"><?= (get_parameter('show-logo-sidebar') == 0) ? get_parameter('site-name') : '' ?></a>
        </div>

        <div class="header__pane ml-auto">
            <div>
                <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v fa-w-6"></i>
                </span>
            </button>
        </span>
    </div>
    <div class="app-header__content">
        <?= $this->include('hamkamannan\adminigniter\layout\backend\partial\header_left'); ?>
        <?= $this->include('hamkamannan\adminigniter\layout\backend\partial\header_right'); ?>
    </div>
</div>
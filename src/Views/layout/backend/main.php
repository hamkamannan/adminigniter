<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?= $title ?? get_parameter('site-name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="msapplication-tap-highlight" content="no">
    <link href="<?= base_url(get_parameter('favicon')) ?>" rel="shortcut icon" type="image/ico">
    <link rel="stylesheet" href="<?= base_url('themes/uigniter'); ?>/css/base.css">
    <?php if (get_parameter('show-logo-sidebar') == '1') : ?>
        <style>
            .app-header__logo .logo-src {
                height: 23px;
                width: 97px;
                background: url("<?= base_url() . get_parameter('logo-small'); ?>");
            }

            .app-header__logo .logo-src {
                background: url("<?= base_url() . get_parameter('logo-small'); ?>");
            }
        </style>
    <?php endif; ?>
    <style>
        .site-name {
            font-size: 18px;
            margin: .75rem 0;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            position: relative;
        }
    </style>
    <?= $this->include('layout/backend/partial/style'); ?>
    <?= $this->include('layout/backend/partial/custom_style'); ?>
    <?= $this->renderSection('style'); ?>
</head>

<body>
    <div class="app-container app-theme-white body-tabs-shadow <?= get_parameter('container-header-class') ?> <?= get_parameter('container-sidebar-class') ?> <?= get_parameter('container-footer-class') ?>">
        <?= $this->include('layout/backend/partial/header'); ?>
        <?php if (is_admin()) : ?>
            <?php if (get_parameter('show-layout-setting') == '1') : ?>
                <?= $this->include('layout/backend/partial/setting'); ?>
            <?php endif; ?>
        <?php endif; ?>
        <div class="app-main">
            <?= $this->include('layout/backend/partial/sidebar'); ?>
            <div class="app-main__outer">
                <?= $this->renderSection('page'); ?>
                <?= $this->include('layout/backend/partial/footer'); ?>
            </div>
        </div>
    </div>
    <?= $this->include('layout/backend/partial/drawer'); ?>
    <?= $this->include('layout/backend/partial/script'); ?>
    <?= $this->include('layout/backend/partial/custom_script'); ?>
    <?= $this->renderSection('script'); ?>
</body>

</html>
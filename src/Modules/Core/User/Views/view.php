<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-user icon-gradient bg-strong-bliss"></i>
                </div>
                <div><?= lang('User.heading.profile') ?>
                    <div class="page-title-subheading"><?= lang('User.heading.sub.profile') ?></div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active breadcrumb-item" aria-current="page"><?= lang('User.heading.profile') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div class="card-shadow-dark profile-responsive card-border mb-3 card">
                <div class="dropdown-menu-header">
                    <div class="dropdown-menu-header-inner bg-primary">
                        <div class="menu-header-image" style="background-image: url('<?= base_url('themes/uigniter') ?>/images/dropdown-header/abstract4.jpg')"></div>
                        <div class="menu-header-content btn-pane-right">
                            <div class="avatar-icon-wrapper mr-2 avatar-icon-xl">
                                <div class="avatar-icon"><img src="<?= base_url('themes/uigniter') ?>/images/avatars/2.jpg" alt="User Profile"></div>
                            </div>
                            <div>
                                <h5 class="menu-header-title"><?= $user->first_name; ?> <?= $user->last_name; ?></h5>
                                <h6 class="menu-header-subtitle"><?= $user->unit ? $user->unit . ' - ' : '' ?> <?= $user->company; ?></h6>
                            </div>
                            <div class="menu-header-btn-pane">
                                <?php if(is_allowed('user/update')):?>
                                    <a data-toggle="modal" data-target="#modal_edit" href="javascript:void(0);" class="mb-2 mr-2 btn btn-pill btn-warning" title="<?= lang('User.btn.profile.update') ?>"><i class="fa fa-edit"></i> <?= lang('User.btn.profile.update') ?></a>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-user"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Username</div>
                                </div>
                                <div class="widget-content-right">
                                    <?= $user->username; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Email</div>
                                </div>
                                <div class="widget-content-right">
                                    <?= $user->email; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-check"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Status</div>
                                </div>
                                <div class="widget-content-right">
                                    <?php if ($user->active) : ?>
                                        <span class="mb-2 mr-2 badge badge-pill badge-success">Active</span>
                                    <?php else : ?>
                                        <span class="mb-2 mr-2 badge badge-pill badge-danger">Inactive</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Group</div>
                                </div>
                                <div class="widget-content-right">
                                    <?php foreach ($currentGroups as $group) : ?>
                                        <span class="mb-2 mr-2 badge badge-pill badge-secondary"><?= $group; ?></span>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">No Telepon</div>
                                </div>
                                <div class="widget-content-right">
                                    <?= $user->phone; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-building"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Unit Kerja</div>
                                </div>
                                <div class="widget-content-right">
                                    <?= $user->unit; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-university"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Institusi</div>
                                </div>
                                <div class="widget-content-right">
                                    <?= $user->company; ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="card-border m-3 card">
                    <div class="card-body">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left mr-3">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="widget-content-left">
                                    <div class="widget-heading">Alamat</div>
                                </div>
                                <div class="widget-content-right">
                                </div>
                            </div>
                            <p class="mt-3">
                                <?= $user->address ?>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-3">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Histori</h5>
                    <div class="scroll-area-md">
                        <div class="scrollbar-container ps ps--active-y">
                            <div class="vertical-time-icons vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <div class="vertical-timeline-element-icon bounce-in">
                                            <div class="timeline-icon border-secondary bg-secondary">
                                                <i class="fa fa-lock text-white"></i>
                                            </div>
                                        </div>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title text-secondary">Login Terakhir</h4>
                                            <p><?= $user->last_login ?: '-' ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <div class="vertical-timeline-element-icon bounce-in">
                                            <div class="timeline-icon border-secondary bg-secondary">
                                                <i class="fa fa-tv text-white"></i>
                                            </div>
                                        </div>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title text-secondary">IP Addres</h4>
                                            <p><?= $user->ip_address ?: '-' ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <div class="vertical-timeline-element-icon bounce-in">
                                            <div class="timeline-icon border-secondary bg-secondary">
                                                <i class="fa fa-calendar text-white"></i>
                                            </div>
                                        </div>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title text-secondary">Daftar Akun</h4>
                                            <p><?= $user->created_at ?: '-' ?></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <div class="vertical-timeline-element-icon bounce-in">
                                            <div class="timeline-icon border-secondary bg-secondary">
                                                <i class="fa fa-calendar text-white"></i>
                                            </div>
                                        </div>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title text-secondary">Update Profile</h4>
                                            <p><?= $user->updated_at ?: '-' ?></p>

                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                            </div>
                            <div class="ps__rail-y" style="top: 0px; right: 0px; height: 290px;">
                                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 290px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection('page'); ?>

<?= $this->section('script'); ?>
<?= $this->include(APPPATH.'Modules/Core/User/Views/update_modal'); ?>

<?= $this->endSection('script'); ?>
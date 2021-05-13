<?= $this->extend('layout/backend/main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-user icon-gradient bg-strong-bliss"></i>
                </div>
                <div>User
                    <div class="page-title-subheading">Daftar Semua User</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active breadcrumb-item" aria-current="page"><?= lang('User.heading') ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-header"><i class="header-icon lnr-list icon-gradient bg-plum-plate"> </i><?= lang('User.heading.sub.table') ?>
            <div class="btn-actions-pane-right actions-icon-btn">
                <?php if(is_allowed('user/create')):?>
                    <a data-toggle="modal" data-target="#modal_create" href="javascript:void(0);" class=" btn btn-success" title="Tambah User"><i class="fa fa-plus"></i> Tambah User</a>
                <?php endif;?>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" id="tbl_users" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Group</th>
                        <th>Status</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($users as $row) : ?>
                        <tr>
                            <td width="35"></td>
                            <td><?= _spec($row->username); ?></td>
                            <td><?= _spec($row->email); ?></td>
                            <td>
                                <?php foreach($row->groups as $group):?>
                                    <span class="mb-2 mr-2 badge badge-pill badge-primary"><?= $group; ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td width="100">
                                <?php if ($row->active) : ?>
                                    <?php if(is_allowed('user/disable')):?>  
                                        <a href="<?= base_url('user/disable/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Nonaktifkan" class="mb-2 mr-2 badge badge-pill badge-success">Aktif</a>
                                    <?php else:?>
                                        <span class="mb-2 mr-2 badge badge-pill badge-success">Aktif</span>
                                    <?php endif;?>
                                <?php else : ?>
                                    <?php if(is_allowed('user/enable')):?>  
                                        <a href="<?= base_url('user/enable/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Aktifkan" class="mb-2 mr-2 badge badge-pill badge-danger">Nonaktif</a>
                                    <?php else:?>
                                        <span class="mb-2 mr-2 badge badge-pill badge-danger">Nonaktif</span>
                                    <?php endif;?>
                                <?php endif; ?>
                            </td>
                            <td width="100">
                                <span class="badge badge-pill badge-warning"><?= _spec($row->updated_at); ?></span>
                            </td>
                            <td width="80">
                                <?php if(is_allowed('user/read')):?>  
                                    <a href="<?= base_url('user/detail/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Profil User" class="btn btn-xs btn-warning"><i class="pe-7s-user font-weight-bold"> </i></a>
                                <?php endif;?>
                                <?php if(is_allowed('user/delete')):?>  
                                    <a href="javascript:void(0);" data-href="<?= base_url('user/delete/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Hapus User" class="btn btn-xs btn-danger remove-data"><i class="pe-7s-trash font-weight-bold"> </i></a>
                                <?php endif;?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection('page'); ?>


<?= $this->section('script'); ?>
<?= $this->include(APPPATH.'Modules/Core/User/Views/add_modal'); ?>

<script>
    setDataTable('#tbl_users', disableOrderCols = [0, 6], defaultOrderCols = [5, 'desc'], autoNumber = true);

    $('#tbl_users').on('click', '.remove-data', function() {
        var url = $(this).attr('data-href');
        Swal.fire({
            title: '<?= lang('App.swal.are_you_sure') ?>',
            text: "<?= lang('App.swal.can_not_be_restored') ?>",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#dd6b55',
            confirmButtonText: '<?= lang('App.btn.yes') ?>',
            cancelButtonText: '<?= lang('App.btn.no') ?>'
        }).then((result) => {
            if (result.value) {
                window.location.href = url;
            }
        });
        return false;
    });
</script>
<?= $this->endSection('script'); ?>
<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-photo icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Sample
                    <div class="page-title-subheading">Daftar Semua Sample</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('sample') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Sample</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header"><i class="header-icon lnr-list icon-gradient bg-plum-plate"> </i>Tabel Sample
            <div class="btn-actions-pane-right actions-icon-btn">
                <?php if(is_allowed('sample/create')):?>
                    <a href="<?= base_url('sample/create') ?>" class=" btn btn-success" title=""><i class="fa fa-plus"></i> Tambah Sample</a>
                <?php endif;?>
            </div>
        </div>
        <div class="card-body">
            <?= get_message('message'); ?>
            <table style="width: 100%;" id="tbl_samples" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Sample</th>
                        <th>Deskripsi</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th>Tanggal Update</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($samples as $row) : ?>
                        <tr>
                            <td width="35"></td>
                            <td width="200">
                                <?= _spec($row->name); ?> <br>
                            </td>
                            <td><?= _spec($row->description); ?></td>
                            <td width="35"><?= _spec($row->sort); ?></td>
                            <td width="100">
                                <?php if ($row->active) : ?>
                                    <a href="<?= base_url('sample/disable/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Nonaktikan Sample" class="mb-2 mr-2 badge badge-pill badge-success">Aktif</a>
                                <?php else : ?>
                                    <a href="<?= base_url('sample/enable/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Aktifkan Sample" class="mb-2 mr-2 badge badge-pill badge-danger">Nonaktif</a>
                                <?php endif; ?>
                            </td>
                            <td width="100">
                                <span class="badge badge-pill badge-warning"><?= _spec($row->updated_at); ?></span>
                            </td>
                            <td width="80">
                                <?php if(is_allowed('sample/update')):?>
                                    <a href="<?= base_url('sample/edit/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Ubah Sample" class="btn btn-xs btn-warning show-data"><i class="pe-7s-note font-weight-bold"> </i></a>
                                <?php endif;?>
                                <?php if(is_allowed('sample/delete')):?>
                                    <a href="javascript:void(0);" data-href="<?= base_url('sample/delete/' . $row->id); ?>" data-toggle="tooltip" data-placement="top" title="Hapus Sample" class="btn btn-xs btn-danger remove-data"><i class="pe-7s-trash font-weight-bold"> </i></a>
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

<script>
    setDataTable('#tbl_samples', disableOrderCols = [0, 6], defaultOrderCols = [5, 'desc'], autoNumber = true);

    $("body").on("click", ".remove-data", function() {
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
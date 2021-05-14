<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-config icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Ubah Parameter
                    <div class="page-title-subheading">Mohon melengkapi data pada form berikut.
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item"><a href="<?= base_url('param') ?>">Paramater</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Ubah Parameter</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-header">
            <i class="header-icon lnr-pencil icon-gradient bg-plum-plate"> </i> Form Edit Parameter
        </div>
        <div class="card-body">
            <div id="infoMessage"><?= $message ?? ''; ?></div>
            <?= get_message('message'); ?>
            <form id="frm_edit_param" class="col-md-12 mx-auto" method="post" action="<?= base_url('param/edit/' . $param->id); ?>">
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                                <label for="name">Nama Parameter</label>
                                <div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Parameter" value="<?= set_value('name', $param->name); ?>" />
                                </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="position-relative form-group">
                                <label for="value">Nilai Parameter</label>
                                <div>
                                    <textarea id="value" name="value" placeholder="Nilai Parameter" rows="1" class="form-control autosize-input"><?= set_value('value', $param->value); ?></textarea>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Keterangan</label>
                    <div>
                        <textarea id="description" name="description" placeholder="Keterangan" rows="2" class="form-control autosize-input" style="min-height: 38px;"><?= set_value('description', $param->description); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection('page'); ?>

<?= $this->section('script'); ?>
<?= $this->endSection('script'); ?>
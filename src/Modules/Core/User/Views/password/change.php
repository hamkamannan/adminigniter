<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
      <div class="app-page-title">
            <div class="page-title-wrapper">
                  <div class="page-title-heading">
                        <div class="page-title-icon">
                              <i class="pe-7s-lock icon-gradient bg-strong-bliss"></i>
                        </div>
                        <div>Ubah Password
                              <div class="page-title-subheading">Ubah password akun Anda</div>
                        </div>
                  </div>
                  <div class="page-title-actions">
                        <nav class="" aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active breadcrumb-item" aria-current="page">Ubah Password</li>
                              </ol>
                        </nav>
                  </div>
            </div>
      </div>
      <div class="main-card mb-3 card">
            <div class="card-header">
                  <i class="header-icon lnr-pencil icon-gradient bg-plum-plate"> </i> Form Ubah Password
            </div>
            <div class="card-body">
                  <div id="infoMessage"><?= $message ?? ''; ?></div>
                  <?= get_message('message'); ?>
                  <form id="frm_change_password" class="col-md-12 mx-auto" method="post" action="<?= base_url('auth/change_password/'); ?>">
                        <div class="form-row">
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="old">Password Lama</label>
                                          <div>
                                                <input type="password" class="form-control" id="old" name="old" placeholder="Password Lama" value="" />
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="new">Password Baru</label>
                                          <div>
                                                <input type="password" class="form-control" id="new" name="new" placeholder="Password Baru" value="" />
                                                <small class="info help-block">Min 8 characters </small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="new_confirm">Konfirmasi Password Baru</label>
                                          <div>
                                                <input type="password" class="form-control" id="new_confirm" name="new_confirm" placeholder="Konfirmasi Password Baru" value="" />
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <?php echo form_hidden('id', user_id()); ?>
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
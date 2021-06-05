<?php
$request = \Config\Services::request();
$request->uri->setSilent();
$slug = $request->getVar('slug') ?? 'backend-menu';
$parent_id = $request->getVar('parent_id');

$baseModel = new \hamkamannan\adminigniter\Models\BaseModel();
$baseModel->setTable('c_references');
$permissions = $baseModel
      ->select('c_references.*')
      ->join('c_menus', 'c_menus.id = c_references.menu_id', 'inner')
      ->where('c_menus.name', 'Permission')
      ->find_all('c_references.sort', 'asc');

$baseModel->setTable('c_menus');
$menus = $baseModel
      ->select('c_menus.*')
      ->where('active', '1')
      ->find_all('sort', 'asc');

$baseModel->setTable('c_categories');
$category = $baseModel
      ->select('c_categories.*')
      ->where('slug', $slug)
      ->row();
?>

<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>
<?= $this->section('page'); ?>
<div class="app-main__inner">
      <div class="app-page-title">
            <div class="page-title-wrapper">
                  <div class="page-title-heading">
                        <div class="page-title-icon">
                              <i class="pe-7s-menu icon-gradient bg-strong-bliss"></i>
                        </div>
                        <div>Tambah Menu
                              <div class="page-title-subheading">Mohon melengkapi data pada form berikut.</div>
                        </div>
                  </div>
                  <div class="page-title-actions">
                        <nav class="" aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="breadcrumb-item">Setting</li>
                                    <li class="breadcrumb-item"><a href="<?= base_url('param') ?>">Paramater</a></li>
                                    <li class="active breadcrumb-item" aria-current="page">Tambah Menu</li>
                              </ol>
                        </nav>
                  </div>
            </div>
      </div>
      <div class="main-card mb-3 card">
            <div class="card-header">
                  <i class="header-icon lnr-plus-circle icon-gradient bg-plum-plate"> </i> Form Tambah Menu
            </div>
            <div class="card-body">
                  <div id="infoMessage"><?= $message ?? ''; ?></div>
                  <?= get_message('message'); ?>
                  <form id="frm_create_menu" class="col-md-12 mx-auto" method="post" action="<?= base_url('menu/create?slug=' . $slug); ?>">
                        <div class="form-row">
                              <div class="col-md-12">
                                    <div class="position-relative form-group">
                                          <label for="name">Tipe</label>
                                          <div>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                      <input type="radio" name="type" id="type_menu" value="menu" checked class="custom-control-input">
                                                      <label class="custom-control-label" for="type_menu">Menu</label>
                                                </div>

                                                <div class="custom-radio custom-control custom-control-inline">
                                                      <input type="radio" name="type" id="type_label" value="label" class="custom-control-input">
                                                      <label class="custom-control-label" for="type_label">Label</label>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="parent">Parent</label>
                                          <div>
                                                <select class="form-control" name="parent" id="parent" tabindex="-1" aria-hidden="true">
                                                      <option value="0">&nbsp;Blank</option>
                                                      <?= display_menu_option($category->id, 0) ?>
                                                </select>
                                                <small class="info help-block text-muted">Menu Induk</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="name">Label*</label>
                                          <div>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Label" value="<?= set_value('name'); ?>" />
                                                <small class="info help-block text-muted">Label menu pada navigasi</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="name">URL/Controller</label>
                                          <div>
                                                <input type="text" class="form-control" id="frm_create_controller" name="controller" placeholder="URL/Controller" value="<?= set_value('controller') ?>" />
                                                <small class="info help-block text-muted">Contoh: {admin_url}/frontend/home/welcome</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="description">Keterangan</label>
                                          <div>
                                                <textarea id="description" name="description" placeholder="Keterangan" rows="1" class="form-control autosize-input" style="min-height: 38px;"><?= set_value('description'); ?></textarea>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6 label">
                                    <div class="position-relative form-group">
                                          <label for="name">Icon</label>
                                          <div>
                                                <input type="text" class="form-control" id="frm_create_icon" name="icon" placeholder="Icon" value="<?= set_value('icon') ?>" />
                                                <small class="info help-block text-muted">Contoh: <i class="fa fa-home"></i> fa fa-home</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6 label">
                                    <div class="position-relative form-group">
                                          <label for="permission">Permission*</label>
                                          <div>
                                                <?php foreach ($permissions as $row) : ?>
                                                      <div class="custom-checkbox custom-control custom-control-inline">
                                                            <input type="checkbox" id="frm_create_permission_<?= $row->name ?>" name="permission[]" value="<?= $row->name ?>" class="custom-control-input" <?= ($row->name == 'access') ? 'checked' : '' ?>>
                                                            <label class="custom-control-label" for="frm_create_permission_<?= $row->name ?>"><?= $row->name ?></label>
                                                      </div>
                                                <?php endforeach; ?>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-12 label">
                                    <div class="position-relative form-group">
                                          <label for="file_image" class="">Thumbnail</label>
                                          <div id="dropzone_file_image" class="dropzone"></div>
                                          <div id="dropzone_file_image_listed"></div>
                                          <div>
                                                <small class="info help-block text-muted">Format (JPG|PNG), Max 10 MB.</small>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <div class="form-group">
                              <input type="hidden" name="category_id" value="<?= $category->id ?>">
                              <button type="submit" class="btn btn-primary" name="submit">Simpan</button>
                        </div>
                  </form>
            </div>
      </div>
</div>
<?= $this->endSection('page'); ?>
<?= $this->section('script'); ?>
<script>
      $(document).ready(function() {
            var parent_id = '<?= $parent_id ?>';
            console.log(parent_id);
            $('#parent').val(parent_id);

            $('.label').show();
            $('.thumbnail').hide();

            $('#type_menu').click(function() {
                  $('.label').show();
                  $('.thumbnail').hide();
            });

            $('#type_label').click(function() {
                  $('.label').hide();
                  $('.thumbnail').hide();
            });
      });
</script>
<script>
      Dropzone.autoDiscover = false;

      var dropzone_file_image = new Dropzone("#dropzone_file_image", {
            url: "<?= base_url('menu/do_upload') ?>", // /do_uploads if multiple
            paramName: "file", // files if multiple
            maxFiles: 1,
            maxFilesize: 10,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            renameFile: function(file) {
                  return new Date().getTime() + '_' + file.name.toLowerCase().replace(' ', '_');
            },
            accept: function(file, done) {
                  console.log("uploaded");
                  done();
            },
            init: function() {
                  this.on("maxfilesexceeded", function(file) {
                        console.log("max file");
                  });
            },
            success: function(file, response) {
                  console.log(file);
                  console.log(response);
                  // file.previewElement.querySelector("img").src = response.files[0].url;
                  // file.previewElement.classList.add("dz-success");
                  // var fileuploded = file.previewElement.querySelector("[data-dz-name]");
                  // fileuploded.innerHTML = response.files[0].name;
                  // file.name = response.files[0].name;

                  var uuid = file.upload.uuid;
                  var name = file.upload.filename;

                  $('#dropzone_file_image_listed').append('<input type="hidden" name="file_image[' + uuid + ']" value="' + name + '" />');
            },
            removedfile: function(file) {
                  console.log(file);
                  var name = "";
                  var path = "<?= WRITEPATH . 'uploads/' ?>";
                  if (file.upload !== undefined) {
                        name = file.upload.filename;
                  } else {
                        name = file.name;
                        path = "<?= ROOTPATH . 'public/uploads/menu/' ?>";
                  }

                  $.ajax({
                        type: 'POST',
                        url: "<?= base_url('menu/do_delete') ?>",
                        data: "name=" + name + "&path=" + path,
                        dataType: 'html'
                  });
                  var _ref;
                  return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }

      });
</script>
<?= $this->endSection('script'); ?>
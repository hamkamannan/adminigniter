<?php
$request = \Config\Services::request();
$request->uri->setSilent();
$slug = $request->getVar('slug') ?? 'backend-menu';

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
                        <div>Ubah Menu
                              <div class="page-title-subheading">Mohon melengkapi data pada form berikut.</div>
                        </div>
                  </div>
                  <div class="page-title-actions">
                        <nav class="" aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="breadcrumb-item">Setting</li>
                                    <li class="breadcrumb-item"><a href="<?= base_url('param') ?>">Paramater</a></li>
                                    <li class="active breadcrumb-item" aria-current="page">Ubah Menu</li>
                              </ol>
                        </nav>
                  </div>
            </div>
      </div>
      <div class="main-card mb-3 card">
            <div class="card-header">
                  <i class="header-icon lnr-plus-circle icon-gradient bg-plum-plate"> </i> Form Ubah Menu
            </div>
            <div class="card-body">
                  <div id="infoMessage"><?= $message ?? ''; ?></div>
                  <?= get_message('message'); ?>
                  <form id="frm_edit_menu" class="col-md-12 mx-auto" method="post" action="<?= base_url('menu/edit/' . $menu->id . '?slug=' . $slug); ?>">
                        <div class="form-row">
                              <div class="col-md-12">
                                    <div class="position-relative form-group">
                                          <label for="name">Tipe</label>
                                          <div>
                                                <div class="custom-radio custom-control custom-control-inline">
                                                      <input type="radio" name="type" id="type_menu" value="menu" class="custom-control-input" <?= ($menu->type == 'menu') ? 'checked' : '' ?>>
                                                      <label class="custom-control-label" for="type_menu">Menu</label>
                                                </div>

                                                <div class="custom-radio custom-control custom-control-inline">
                                                      <input type="radio" name="type" id="type_label" value="label" class="custom-control-input" <?= ($menu->type == 'label') ? 'checked' : '' ?>>
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
                                                      <option value="0"></option>
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
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Label" value="<?= set_value('name', $menu->name); ?>" />
                                                <small class="info help-block text-muted">Label menu pada navigasi</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="name">URL/Controller</label>
                                          <div>
                                                <input type="text" class="form-control" id="frm_edit_controller" name="controller" placeholder="URL/Controller" value="<?= set_value('controller', $menu->controller) ?>" />
                                                <small class="info help-block text-muted">Contoh: {admin_url}/frontend/home/welcome</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-6">
                                    <div class="form-group">
                                          <label for="description">Keterangan</label>
                                          <div>
                                                <textarea id="description" name="description" placeholder="Keterangan" rows="1" class="form-control autosize-input" style="min-height: 38px;"><?= set_value('description', $menu->description); ?></textarea>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-6 label">
                                    <div class="position-relative form-group">
                                          <label for="name">Icon</label>
                                          <div>
                                                <input type="text" class="form-control" islug" name="icon" placeholder="Icon" value="<?= set_value('icon', $menu->icon) ?>" />
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
                                                            <input type="checkbox" id="frm_edit_permission_<?= $row->name ?>" name="permission[]" value="<?= $row->name ?>" class="custom-control-input">
                                                            <label class="custom-control-label" for="frm_edit_permission_<?= $row->name ?>"><?= $row->name ?></label>
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
                              <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="description">Slug</label>
                                          <div>
                                                <input type="text" class="form-control" id="frm_edit_slug" name="form_slug" placeholder="Slug" value="<?= set_value('form_slug', $menu->slug) ?>" />
                                          </div>
                                    </div>
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
<script>
      $(document).ready(function() {
            var permission = '<?= $menu->permission ?>';
            var permissions = permission.split("|");
            $.each(permissions, function(index, value) {
                  $('#frm_edit_permission_' + value).prop("checked", true);
            });

            var parent_id = '<?= $menu->parent ?>';
            console.log(parent_id);
            $('#parent').val(parent_id);

            var menu_type = '<?= $menu->type  ?>';

            if(menu_type == 'label'){
                  $('.label').hide();
            } else {
                  $('.label').show();
            }

            $('#type_menu').click(function() {
                  $('.label').show();
            });

            $('#type_label').click(function() {
                  $('.label').hide();
            });
      });
</script>
<script>
      Dropzone.autoDiscover = false;

      var dropzone_file_image = new Dropzone("#dropzone_file_image", {
            url: "<?= base_url('menu/do_upload') ?>", // /do_uploads if multiple
            paramName: "file", // files if multiple
            maxFiles: 2,
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
            thisDropzone = this;

            var existingFile = "<?= $menu->file_image ?? '' ?>";
            if (existingFile) {
                  var files = existingFile.split(',');
                  files.forEach(function(file) {
                        var uuid = Date.now();
                        var modulePath = "<?= base_url('uploads/menu/') ?>";
                        var filePath = modulePath + '/' + file;
                        var mockFile = {
                        name: file,
                        size: 68000
                        };
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile, filePath); {
                        $('[data-dz-thumbnail]').css('height', '120');
                        $('[data-dz-thumbnail]').css('width', '120');
                        $('[data-dz-thumbnail]').css('object-fit', 'cover');
                        };
                        $(thisDropzone.previewsContainer).find('.dz-progress').hide();
                        $('#file_image_listed').append('<input type="hidden" name="file_image[' + uuid + ']" value="' + file + '" />');
                  });
            }
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
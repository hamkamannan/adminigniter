<?php
$request = \Config\Services::request();
$request->uri->setSilent();

$baseModel = new \hamkamannan\adminigniter\Models\BaseModel();
$baseModel->setTable('c_references');
$categories = $baseModel
    ->select('c_references.*')
    ->join('c_menus','c_menus.id = c_references.menu_id', 'inner')
    ->where('c_menus.name','Banner')
    ->find_all('name', 'asc');
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
                    <i class="pe-7s-photo icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Ubah Banner
                    <div class="page-title-subheading">Mohon melengkapi data pada form berikut.</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('banner') ?>">Banner</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Ubah Banner</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
            <div class="card-header">
                  <i class="header-icon lnr-plus-circle icon-gradient bg-plum-plate"> </i> Form Ubah Banner
            </div>
            <div class="card-body">
                  <div id="infoMessage"><?= $message ?? ''; ?></div>
                  <?= get_message('message'); ?>

                  <form id="frm" class="col-md-12 mx-auto" method="post" action="">
                        <div class="form-row">
                              <div class="col-md-6">
                                    <div class="position-relative form-group">
                                          <label for="name">Judul Banner*</label>
                                          <div>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="<?= set_value('name', $banner->name); ?>" />
                                                <small class="info help-block text-muted">Judul Banner</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-3">
                                    <div class="position-relative form-group">
                                          <label>Kategori*</label>
                                          <select class="form-control" name="category_id" id="category_id" tabindex="-1" aria-hidden="true">
                                                <?php foreach ($categories as $row) : ?>
                                                <option value="<?= $row->id ?>" <?=($row->id == $banner->category_id) ? 'selected':''?>><?= $row->name ?></option>
                                                <?php endforeach; ?>
                                          </select>
                                    </div>
                              </div>
                              <div class="col-md-3">
                                    <div class="position-relative form-group">
                                          <label for="sort">Urutan</label>
                                          <div>
                                                <input type="number" class="form-control" id="sort" name="sort" placeholder="Urutan" value="<?= set_value('sort', $banner->sort) ?>" />
                                                <small class="info help-block text-muted">Urutan Banner</small>
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <div class="form-group">
                              <label for="description">Deskripsi</label>
                              <div>
                                    <textarea id="description" name="description" placeholder="Deskripsi" rows="2" class="form-control autosize-input" style="min-height: 38px;"><?= set_value('description', $banner->description) ?></textarea>
                              </div>
                        </div>
                        <div class="form-row">
                              <div class="col-md-12">
                                    <div class="form-row">
                                          <div class="col-md-12">
                                                <div class="position-relative form-group">
                                                      <label for="file_image" class="">Foto Banner</label>
                                                      <div id="dropzone_file_image" class="dropzone"></div>
                                                      <div id="dropzone_file_image_listed"></div>
                                                      <div>
                                                            <small class="info help-block text-muted">Format (JPG|PNG). Max 10 MB</small>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <div class="form-row">
                              <div class="col-md-8">
                                    <div class="position-relative form-group">
                                          <label for="url">Alamat URL</label>
                                          <div>
                                                <input type="text" class="form-control" id="url" name="url" placeholder="Alamat URL" value="<?= set_value('url', $banner->url) ?>" />
                                                <small class="info help-block text-muted">Alamat URL jika banner diklik, contoh: https://google.com</small>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-4">
                                    <div class="position-relative form-group">
                                          <label for="url_title">Judul URL</label>
                                          <div>
                                                <input type="text" class="form-control" id="url_title" name="url_title" placeholder="Judul Link" value="<?= set_value('url_title', $banner->url_title); ?>" />
                                                <small class="info help-block text-muted">Contoh: Selengkapnya</small>
                                          </div>
                                    </div>
                              </div>
                        </div>

                        <div class="form-group">
                              <button type="submit" class="btn btn-primary" name="submit"><?= lang('App.btn.save') ?></button>
                        </div>
                  </form>
            </div>
    </div>
</div>


<?= $this->endSection('page'); ?>

<?= $this->section('script'); ?>
<script>
      Dropzone.autoDiscover = false;

      var dropzone_file_image = new Dropzone("#dropzone_file_image", {
            url: "<?= base_url('banner/do_upload') ?>", // /do_uploads if multiple
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

            var existingFile = "<?= $banner->file_image ?>";
            if (existingFile) {
                  var files = existingFile.split(',');
                  files.forEach(function(file) {
                        var uuid = Date.now();
                        var modulePath = "<?= base_url('uploads/banner/') ?>";
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
                  path = "<?= ROOTPATH . 'public/uploads/banner/' ?>";
            }

            $.ajax({
                  type: 'POST',
                  url: "<?= base_url('banner/do_delete') ?>",
                  data: "name=" + name + "&path=" + path,
                  dataType: 'html'
            });
            var _ref;
            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            }

      });
</script>
<?= $this->endSection('script'); ?>
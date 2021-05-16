<?= $this->extend('hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-news-paper icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Ubah Halaman
                    <div class="page-title-subheading">Mohon melengkapi data pada form berikut.
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('page') ?>">Halaman</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Ubah Halaman</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="main-card mb-3 card">
        <div class="card-header">
            <i class="header-icon lnr-pencil icon-gradient bg-plum-plate"> </i> Form Ubah Halaman
        </div>
        <div class="card-body">
            <div id="infoMessage"><?= $message ?? ''; ?></div>
            <?= get_message('message'); ?>
            <form id="frm_edit_group" class="col-md-12 mx-auto" method="post" action="<?= base_url('page/edit/' . $page->id); ?>">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Judul Halaman*</label>
                            <div>
                                <input type="text" class="form-control" id="title" name="title" placeholder="Judul" value="<?= set_value('title', $page->title); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <div>
                                <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug" value="<?= set_value('slug', $page->slug); ?>" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">Uraian Halaman*</label>
                    <div>
                        <textarea id="content" name="content" placeholder="Uraian Halaman" rows="1" class="form-control autosize-input"><?= set_value('content', $page->content); ?></textarea>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <div class="position-relative form-group">
                            <label for="file_image" class="">Gambar</label>
                            <div id="dropzone_file_image" class="dropzone"></div>
                            <div id="dropzone_file_image_listed"></div>
                            <div>
                                <small class="info help-block">Format (JPG|PNG). Max 10 MB</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <div>
                        <textarea id="description" name="description" placeholder="Deskripsi" rows="1" class="form-control autosize-input"><?= set_value('description', $page->description); ?></textarea>
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
        url: "<?= base_url('page/do_upload') ?>", // /do_uploads if multiple
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

        var existingFile = "<?= $page->file_image ?>";
        if (existingFile) {
                var files = existingFile.split(',');
                files.forEach(function(file) {
                    var uuid = Date.now();
                    var modulePath = "<?= base_url('uploads/page/') ?>";
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
                path = "<?= ROOTPATH . 'public/uploads/page/' ?>";
        }

        $.ajax({
                type: 'POST',
                url: "<?= base_url('page/do_delete') ?>",
                data: "name=" + name + "&path=" + path,
                dataType: 'html'
        });
        var _ref;
        return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
        }

    });

    $(document).ready(function() {
        tinyMCE.init({
            selector: 'textarea#content',
            height: 430,
            menubar: false,
            pagebreak_separator: '<div style="page-break-after:always;clear:both"></div>',
            plugins: 'link image code table pagebreak paste media lists',
            toolbar: 'code | undo redo | bold italic underline strikethrough | fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl  | table tabledelete ',
            setup: function(editor) {
                editor.on('init', function(e) {
                    // editor.setContent(content);
                });
            },
            fontsize_formats: "12px 14px 16px 18px 20px 24px 28px 32px",
            content_style: "body { font-size: 14px;}",
        });

    });
</script>
<?= $this->endSection('script'); ?>
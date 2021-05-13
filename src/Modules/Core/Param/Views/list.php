<?= $this->extend('layout/backend/main'); ?>
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
                <div>Parameter
                    <div class="page-title-subheading">Daftar Semua Parameter</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('param') ?>">Paramater</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <?php if(get_parameter('show-top-checkbox') == 1):?>
    <div class="row">
        <div class="col-md-3">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="switch has-switch switch-container-class" data-class="show-layout-setting">
                            <div class="switch-animate switch-on">
                                <input type="checkbox" class="apply-param-status" data-param="show-layout-setting" data-class="1" <?= (get_parameter('show-layout-setting') == '1') ? 'checked' : '' ?> data-toggle="toggle" data-onstyle="success">
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">Tampilkan Layout</div>
                        <div class="widget-subheading">Tampilkan Layout Setting</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="widget-content p-0">
                <div class="widget-content-wrapper">
                    <div class="widget-content-left mr-3">
                        <div class="switch has-switch switch-container-class" data-class="show-logo-sidebar">
                            <div class="switch-animate switch-on">
                                <input type="checkbox" class="apply-param-status" data-param="show-logo-sidebar" data-class="1" <?= (get_parameter('show-logo-sidebar') == '1') ? 'checked' : '' ?> data-toggle="toggle" data-onstyle="success">
                            </div>
                        </div>
                    </div>
                    <div class="widget-content-left">
                        <div class="widget-heading">Tampilkan Logo</div>
                        <div class="widget-subheading">Tampilkan Logo Sidebar</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>

    <br>
    <div class="main-card mb-3 card">
        <div class="card-header"><i class="header-icon lnr-list icon-gradient bg-plum-plate"> </i>Semua Paramater
            <div class="btn-actions-pane-right actions-icon-btn">
                <a href="<?= base_url('param/create'); ?>" class=" btn btn-success"><i class="fa fa-plus"></i> Tambah Parameter</a>
            </div>
        </div>
        <div class="card-body">
            <?= get_message('message'); ?>
            <table style="width: 100%;" id="tbl_params" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Parameter</th>
                        <th>Nilai Parameter</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th>#</th>
                        <th><input type="text" id="search_name" class="form-control form-control-sm" placeholder="Cari" /></th>
                        <th><input type="text" id="search_value" class="form-control form-control-sm" placeholder="Cari" /></th>
                        <th><input type="text" id="search_description" class="form-control form-control-sm" placeholder="Cari" /></th>
                        <th>#</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection('page'); ?>

<?= $this->section('script'); ?>
<script>
    var tbl_params = $('#tbl_params').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
            url: '<?=base_url('param/json')?>',
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'value', name: 'value'},
            {data: 'description', name: 'description'},
            {
                data: 'id', orderable: false, searchable: false
            }
        ],
        columnDefs:[
            {
                targets:4, data:'id', render: function(data,type,full,meta) { 
                    var button_edit = '<a href="<?=base_url('param/edit')?>/'+data+'" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" title="Ubah Param"><i class="pe-7s-note font-weight-bold"> </i></a> ';
                    var button_delete = '<a href="javascript:void(0);" data-href="<?=base_url('param/delete')?>/'+data+'" class="btn btn-xs btn-danger remove-data" data-toggle="tooltip" data-placement="top" title="Hapus Param"><i class="pe-7s-trash font-weight-bold"> </i></a>';
                    return button_edit + button_delete;
                },
            }
        ],
        order: [[0, 'desc']]
    });

    $('#search_name').on( 'keyup', function (e) {
        tbl_params.columns('name:name').search( this.value ).draw();
    });

    $('#search_value').on( 'keyup', function () {
        tbl_params.columns('value:name').search( this.value ).draw();
    });

    $('#search_description').on( 'keyup', function () {
        tbl_params.columns('description:name').search( this.value ).draw();
    });

    $('#tbl_params').on('click', '.remove-data', function() {
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

    $(".apply-param-status").on('change', function() {
        var switchStatus = $(this).is(':checked');
        var paramName = $(this).attr('data-param');
        var paramValue = $(this).attr('data-class');

        if (switchStatus) {
            setParameter(paramName, 1);
        } else {
            setParameter(paramName, 0);
        }
    });
</script>
<?= $this->endSection('script'); ?>
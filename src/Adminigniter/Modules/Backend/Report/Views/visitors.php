<?= $this->extend('\hamkamannan\adminigniter\Views\layout\backend\main'); ?>
<?= $this->section('style'); ?>
<?= $this->endSection('style'); ?>

<?= $this->section('page'); ?>
<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-graph2 icon-gradient bg-strong-bliss"></i>
                </div>
                <div>Laporan Kunjungan
                    <div class="page-title-subheading">Daftar Semua Kunjungan</div>
                </div>
            </div>
            <div class="page-title-actions">
                <nav class="" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('auth') ?>"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                        <li class="active breadcrumb-item" aria-current="page">Kunjungan </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="card-body pt-0">
            <h5 class="card-title">Periode Kunjungan</h5>
            <!-- <form action=""> -->
            <button class="btn btn-primary" id="reportrange">
                <i class="fa fa-calendar pr-1"></i>
                <span></span>
                <i class="fa pl-1 fa-caret-down"></i>
            </button>

            <button class="btn btn-primary" id="btnSearch">
                <i class="fa fa-search pr-1"></i> <span>Search</span>
            </button>
        </div>
    </div>

    <div class="main-card mb-3 card">
        <div class="card-header"><i class="header-icon lnr-list icon-gradient bg-plum-plate"> </i>Laporan Kunjungan
            <div class="btn-actions-pane-right actions-icon-btn">
                <a href="<?= base_url('report/visitors_export'); ?>" class=" btn btn-success"><i class="fa fa-file-excel"></i> Export Excel</a>
            </div>
        </div>
        <div class="card-body">
            <table style="width: 100%;" id="tbl_visitors" class="table table-hover table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Alamat IP</th>
                        <th>Kota</th>
                        <th>Negara</th>
                        <th>Hits</th>
                        <th>Tanggal Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($visitors as $row) : ?>
                        <tr>
                            <td width="35"></td>
                            <td width="160"><?= $row->timestamp ?></td>
                            <td width="160"><?= _spec($row->ip_address); ?></td>
                            <td><?= _spec($row->ip_regionName); ?></td>
                            <td><?= _spec($row->ip_country); ?></td>
                            <td width="100"><?= _spec($row->hits); ?></td>
                            <td width="160">
                                <span class="badge badge-warning badge-pill"><?= $row->updated_at ?></span>
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

$( document ).ready(function() {

    var start = moment();
    var end = moment();

    var from_date, to_date, url;

    function cb(start, end) {
        $('#reportrange span').html(start.format('D/M/YYYY') + ' - ' + end.format('D/M/YYYY'));
        from_date = start.format('YYYY') +'-'+ start.format('M').padStart(2, '0') +'-'+ start.format('D').padStart(2, '0') ;
        to_date = end.format('YYYY') +'-'+ end.format('M').padStart(2, '0') +'-'+ end.format('D').padStart(2, '0') ;
        url = '<?=base_url('report/visitors')?>' + '?from_date='+from_date+'&to_date='+to_date;
        console.log(url);
    }

    $('#reportrange').daterangepicker({
        startDate: start.format('D/M/YYYY'),
        endDate: end.format('D/M/YYYY'),
        showDropdowns: true,
        "opens": "right",
        ranges: {
            'Hari ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Minggu ini': [moment().startOf('week'), moment().endOf('week')],
            'Minggu lalu': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
            'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
            'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Tahun ini': [moment().startOf('year'), moment().endOf('year')],
            'Tahun lalu': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
        },
    }, cb);

    cb(start, end);

    $('#btnSearch').click(function(){
        window.location.replace(url);
    });



});
</script>
<script>
    setDataTable('#tbl_visitors', disableOrderCols = [0], defaultOrderCols = [6, 'desc'], autoNumber = true);
</script>
<?= $this->endSection('script'); ?>
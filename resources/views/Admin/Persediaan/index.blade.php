@extends('Master.Layouts.app', ['title' => $title])

@section('content')
<!-- PAGE-HEADER -->
<div class="page-header">
    <h1 class="page-title">{{$title}}</h1>
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item text-gray">Persediaan Obat</li>
            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
        </ol>
    </div>
</div>
<!-- PAGE-HEADER END -->


<!-- ROW -->
<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3 class="card-title">Data</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-1" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">Tanggal Masuk</th>
                            <th class="border-bottom-0">Supplier</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Jumlah Masuk (/Satuan)</th>
                            <th class="border-bottom-0">Stok Gudang</th>
                            <th class="border-bottom-0">Etalase</th>
                            <th class="border-bottom-0">Letak Gudang</th>
                            <th class="border-bottom-0">Letak Etalase</th>
                            <th class="border-bottom-0">Tanggal Kadaluarsa</th>
                            <th class="border-bottom-0">Harga Jual (/Satuan)</th>
                            <th class="border-bottom-0">Harga Beli (/Satuan)</th>
                            <th class="border-bottom-0" width="1%">Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END ROW -->


@include('Admin.Persediaan.edit')
@include('Admin.Persediaan.hapus')

<script>
    function generateID() {
        id = new Date().getTime();
        $("input[name='bmkode']").val("BM-" + id);
    }
    
    function update(data) {
        $("input[name='idbmU']").val(data.bm_id);
        $("input[name='bmkodeU']").val(data.bm_kode);
        $("input[name='kdbarangU']").val(data.barang_kode);
        $("select[name='customerU']").val(data.customer_id);
        $("input[name='jmlU']").val(data.bm_jumlah);
        $("input[name='hargajualU']").val(data.bm_hargajual);
        $("input[name='hargabeliU']").val(data.bm_hargabeli);
        $("input[name='totalstokU']").val(data.bm_stok);
        $("input[name='etalaseU']").val();
        $("input[name='letakGU']").val(data.bm_ltkgudang);
        $("input[name='letakEU']").val(data.bm_ltketalase);

        getbarangbyidU(data.barang_kode);

        $("input[name='tglmasukU']").bootstrapdatepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        }).bootstrapdatepicker("update", data.bm_tanggal);

        $("input[name='tglkadaluarsaU']").bootstrapdatepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        }).bootstrapdatepicker("update", data.bm_tglex);
    }

    function hapus(data) {
        $("input[name='idbm']").val(data.bm_id);
        $("#vbm").html("Kode BM " + "<b>" + data.bm_kode + "</b>");
    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "Iya."
        });
    }
</script>
@endsection

@section('scripts')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table;
    $(document).ready(function() {
        //datatables
        table = $('#table-1').DataTable({

            "processing": true,
            "serverSide": true,
            "info": true,
            "order": [],
            "scrollX": true,
            "stateSave": true,
            "lengthMenu": [
                [5, 10, 25, 50, 100],
                [5, 10, 25, 50, 100]
            ],
            "pageLength": 10,

            lengthChange: true,

            "ajax": {
                "url": "{{ route('persediaan.getpersediaan') }}",
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'tgl',
                    name: 'bm_tanggal',
                },
                {
                    data: 'customer',
                    name: 'customer_nama',
                },
                {
                    data: 'barang_kode',
                    name: 'barang_kode',
                },
                {
                    data: 'barang',
                    name: 'barang_nama',
                },
                {
                    data: 'satuan',
                    name: 'satuan_nama',
                },
                {
                    data: 'jenisbarang',
                    name: 'jenisbarang_nama',
                },
                {
                    data: 'merk',
                    name: 'merk_nama',
                },
                {
                    data: 'bm_jumlah',
                    name: 'bm_jumlah',
                },
                {
                    data: 'totalstok',
                    name: 'bm_stok',
                },
                {
                    data: 'etalase',
                    name: 'bm_etalase',
                },
                {
                    data: 'letakG',
                    name: 'bm_ltkgudang',
                },
                {
                    data: 'letakE',
                    name: 'bm_ltketalase',
                },
                {
                    data: 'tglexp',
                    name: 'bm_tglex',
                },
                {
                    data: 'harga_jual',
                    name: 'bm_hargajual',
                },
                {
                    data: 'harga_beli',
                    name: 'bm_hargabeli',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],

        });
    });
</script>
@endsection
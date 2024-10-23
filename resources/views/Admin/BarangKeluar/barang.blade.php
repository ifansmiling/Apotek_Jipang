<!-- MODAL BARANG -->
<div class="modal fade" data-bs-backdrop="static" style="overflow-y:scroll;" id="modalBarang">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Pilih Obat</h6><button onclick="resetB('tambah')" aria-label="Close" class="btn-close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-4 pb-5">
                <input type="hidden" value="tambah" name="param">
                <input type="hidden" id="randkey">
                <div class="table-responsive">
                    <table id="table-2" width="100%" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">Gambar</th>
                            <th class="border-bottom-0">No Nota</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Tanggal Kadaluarsa</th>
                            <th class="border-bottom-0">Stok</th>
                            <th class="border-bottom-0">Etalase</th>
                            <th class="border-bottom-0">Harga Jual</th>
                            <th class="border-bottom-0" width="1%">Action</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('formOtherJS')
<script>
    document.getElementById('randkey').value = makeid(10);

    function resetB() {
        param = $('input[name="param"]').val();
        if (param == 'tambah') {
            $('#modalBarang').modal('hide');
            $('#modaldemo8').removeClass('d-none');
        } else {
            $('#modalBarang').modal('hide');
            $('#Umodaldemo8').removeClass('d-none');
        }

    }

    function pilihBarang(data) {
        console.log(data);
        if (data.bm_etalase <= 0) {
            validasi('Etalase kosong. Isi terlebih dahulu sebelum melanjutkan.', 'warning');
            setLoading(false);
            return false;
        } else if (data.bm_stok <= 0 && data.bm_etalase <= 0) {
            validasi('Stok kosong. Lakukan Pembelian.', 'warning');
            setLoading(false);
            return false;
        }
        const key = $("#randkey").val();
        $("#status").val("true");
        $("input[name='bm_id']").val(data.bm_id);
        $("#bmkode").val(data.bm_kode.replace(/_/g, ' '));
        $("#kdbarang").val(data.barang_kode.replace(/_/g, ' '));
        $("#nmbarang").val(data.barang_nama.replace(/_/g, ' '));
        $("#satuan").val(data.satuan_nama.replace(/_/g, ' '));
        $("#jenisbarang").val(data.jenisbarang_nama.replace(/_/g, ' '));
        $("#merk").val(data.merk_nama.replace(/_/g, ' '));
        $("#tglexp").val(data.bm_tglex.replace(/_/g, ' '));
        $("#totalstok").val(data.bm_stok.replace(/_/g, ' '));
        $("#etalase").val(data.bm_etalase.replace(/_/g, ' '));
        $("#harga_jual").val(data.bm_hargajual.replace(/_/g, ' '));
        tambahBarisObat();
        $('#modaldemo8').removeClass('d-none');
        $('#modalBarang').modal('hide');
    }


    function pilihBarangU(data) {
        if (data.bm_etalase <= 0) {
            validasi('Etalase kosong. Isi terlebih dahulu sebelum melanjutkan.', 'warning');
            setLoading(false);
            return false;
        // if (data.bm_etalase <= 0) {
            // Tampilkan pesan peringatan bahwa etalase kosong
            //alert('Etalase kosong. Isi terlebih dahulu sebelum melanjutkan.');
            //return; // Hentikan eksekusi lebih lanjut
        }else if(data.bm_stok <= 0 && data.bm_etalase <= 0){
            validasi('Stok kosong. Lakukan Pembelian.', 'warning');
            setLoading(false);
            return false;
        }
        const key = $("#randkey").val();
        $("#statusU").val("true");
        $("input[name='bm_idU']").val(data.bm_id);
        $("#bmkodeU").val(data.bm_kode.replace(/_/g, ' '));
        $("#kdbarangU").val(data.barang_kode.replace(/_/g, ' '));
        $("#nmbarangU").val(data.barang_nama.replace(/_/g, ' '));
        $("#satuanU").val(data.satuan_nama.replace(/_/g, ' '));
        $("#jenisbarangU").val(data.jenisbarang_nama.replace(/_/g, ' '));
        $("#merkU").val(data.merk_nama.replace(/_/g, ' '));
        $("#tglexpU").val(data.bm_tglex.replace(/_/g, ' '));
        $("#totalstokU").val(data.bm_stok.replace(/_/g, ' '));
        $("#etalaseU").val(data.bm_etalase.replace(/_/g, ' '));
        $("#harga_jualU").val(data.bm_hargajual.replace(/_/g, ' '));
        $('#Umodaldemo8').removeClass('d-none');
        $('#modalBarang').modal('hide');
    }

    var table2;
    $(document).ready(function() {
        //datatables
        table2 = $('#table-2').DataTable({

            "processing": true,
            "serverSide": true,
            "info": false,
            "order": [],
            "ordering": false,
            "scrollX": false,
            // "lengthMenu": [
            //     [5, 10, 25, 50, 100],
            //     [5, 10, 25, 50, 100]
            // ],
            "pageLength": 10,

            "lengthChange": true,

            "ajax": {
                "url": "{{url('admin/persediaan/listpersediaan')}}/param",
                "data": function(d) {
                    d.param = $('input[name="param"]').val();
                }
            },

            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'img',
                    name: 'barang_foto',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'bm_kode',
                    name: 'bm_kode',
                },
                {
                    data: 'barang_kode',
                    name: 'barang_kode',
                },
                {
                    data: 'barang_nama',
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
                    data: 'tglexp',
                    name: 'bm_tglex',
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
                    data: 'harga_jual',
                    name: 'bm_hargajual',
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

    function makeid(length) {
        var result = '';
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>
@endsection
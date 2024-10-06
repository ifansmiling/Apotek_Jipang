<!-- MODAL BARANG -->
<div class="modal fade" data-bs-backdrop="static" style="overflow-y:scroll;" id="modalBarang" aria-labelledby="exampleModalLabel" aria-hidden="true" onclick="closeModalBarang()">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Pilih Barang</h6><button onclick="resetB('tambah')" aria-label="Close" class="btn-close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body p-4 pb-5">
                <input type="hidden" value="tambah" name="param">
                <input type="hidden" id="randkey">
                <div class="table-responsive">
                    <table id="table-2" width="100%" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">Gambar</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Supplier</th> 
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
    //const customerNama = $("#customer").val(data.customer_nama.replace(/_/g, ' '));
    //if(selectedSupplier !== customerNama){
      // validasi('Pilih Obat sesuai dengan Supplier yang anda pilih sebelumnya!', 'warning');
    //}else{
        param = $('input[name="param"]').val();
        if (param == 'tambah') {
            $('#modalBarang').modal('hide');
            $('#modaldemo8').removeClass('d-none');
        } else {
            $('#modalBarang').modal('hide');
            $('#Umodaldemo8').removeClass('d-none');
        }
    }
    //}
    

    function pilihBarang(data) {
        const obatSupplier = data.customer_nama.replace(/_/g, ' ');  // Nama supplier obat yang dipilih

        // Validasi apakah supplier sesuai
        if (selectedSupplier !== '' && selectedSupplier !== obatSupplier) {
            validasi('Supplier berbeda, pilih Obat dengan supplier yang sesuai!', 'warning')
            return; // Hentikan proses jika supplier tidak sesuai
        }

        // Jika supplier sesuai, lanjutkan proses
        const key = $("#randkey").val();
        $("#status").val("true");
        $("input[name='kdbarang']").val(data.barang_kode.replace(/_/g, ' '));
        $("#nmbarang").val(data.barang_nama.replace(/_/g, ' '));
        $("#satuan").val(data.satuan_nama.replace(/_/g, ' '));
        $("#jenis").val(data.jenisbarang_nama.replace(/_/g, ' '));
        $("#merk").val(data.merk_nama.replace(/_/g, ' '));
        $("#customer").val(data.customer_nama.replace(/_/g, ' '));
        tambahDataKeTabel();
        $('#modaldemo8').removeClass('d-none');
        $('#modalBarang').modal('hide');
    }
    

    function pilihBarangU(data) {
        const key = $("#randkey").val();
        $("#statusU").val("true");
        $("input[name='kdbarangU']").val(data.barang_kode.replace(/_/g, ' '));
        $("#nmbarangU").val(data.barang_nama.replace(/_/g, ' '));
        $("#satuanU").val(data.satuan_nama.replace(/_/g, ' '));
        $("#jenisU").val(data.jenisbarang_nama.replace(/_/g, ' '));
        $("#merkU").val(data.merk_nama.replace(/_/g, ' '));
        $("#customerU").val(data.customer_nama.replace(/_/g, ' '));
        $('#Umodaldemo8').removeClass('d-none');
        $('#modalBarang').modal('hide');
    }


    var table2;
    var selectedSupplier = ''; // Variabel untuk menyimpan supplier yang dipilih

    $(document).ready(function() {
        // Inisialisasi DataTables
        table2 = $('#table-2').DataTable({
            "processing": true,
            "serverSide": true,
            "info": false,
            "order": [],
            "ordering": false,
            "pageLength": 10,
            "lengthChange": true,
            "ajax": {
                "url": "{{url('admin/barang/listbarang')}}/param",
                "data": function(d) {
                    d.param = $('input[name="param"]').val();
                }
            },
            "columns": [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
                {data: 'img', name: 'barang_foto', searchable: false, orderable: false},
                {data: 'barang_kode', name: 'barang_kode'},
                {data: 'barang_nama', name: 'barang_nama'},
                {data: 'jenisbarang', name: 'jenisbarang_nama'},
                {data: 'satuan', name: 'satuan_nama'},
                {data: 'merk', name: 'merk_nama'},
                {data: 'customer', name: 'customer_nama'}, // Nama supplier
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });

        // Simpan nama supplier yang dipilih
        $('#supplier').change(function() {
            selectedSupplier = $('#supplier option:selected').text(); // Tangkap supplier yang dipilih
            table2.ajax.reload(); // Reload tabel setelah supplier dipilih
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
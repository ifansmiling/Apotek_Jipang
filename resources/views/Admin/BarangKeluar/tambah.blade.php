<!-- MODAL TAMBAH -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Obat Keluar</h6>
                <button aria-label="Close" onclick="reset()" class="btn-close" data-bs-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bkkode" class="form-label">Kode Obat Keluar <span class="text-danger">*</span></label>
                            <input type="text" name="bkkode" readonly class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglkeluar" class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                            <input type="text" name="tglkeluar" class="form-control datepicker-date" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tujuan" class="form-label">Nama Pembeli</label>
                            <input type="text" name="tujuan" class="form-control" placeholder="">
                        </div>
                        <label><span class="text-danger me-1"></span>
                            <input type="hidden" id="status" value="false">
                            <div class="spinner-border spinner-border-sm d-none" id="loaderkd" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </label>
                        <div class="input-group d-flex justify-content-end mr-3">
                            <button class="btn btn-success" onclick="modalBarang()" type="button">Tambah Obat <i class="fe fe-plus"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Tabel dengan scroll vertikal dan horizontal -->
                <div style="max-height: 300px; overflow-x: auto; overflow-y: 300px;">
                    <table class="table table-bordered" style="white-space: nowrap;">
                        <thead>
                            <tr>
                                <th style="width: 100px;">Kode Obat</th>
                                <th style="width: 100px;">No Nota</th>
                                <th style="width: 200px;">Nama Obat</th>
                                <th style="width: 100px;">Satuan</th>
                                <th style="width: 150px;">Jenis</th> 
                                <th style="width: 150px;">Kategori</th>
                                <th style="width: 150px;">Tanggal Kadaluarsa</th>
                                <th style="width: 100px;">Etalase</th>
                                <th style="width: 120px;">Harga Jual (/Satuan)</th>
                                <th style="width: 120px;">Jumlah Keluar <span class="text-danger">*</span></th>
                                <th style="width: 120px;">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" id="kdbarang" name="kdbarang" class="form-control" readonly></td>
                                <td><input type="text" id="bmkode" name="bmkode" class="form-control" readonly></td>
                                <td><input type="text" class="form-control" id="nmbarang" name="nmbarang" readonly></td>
                                <td><input type="text" class="form-control" id="satuan" name="satuan" readonly></td>
                                <td><input type="text" class="form-control" id="jenisbarang" name="jenisbarang" readonly></td>
                                <td><input type="text" class="form-control" id="merk" name="merk" readonly></td>
                                <td><input type="text" id="tglexp" name="tglexp" class="form-control datepicker-date" readonly></td>
                                <td><input type="text" id="etalase" name="etalase" class="form-control" readonly></td>
                                <td><input type="text" id="harga_jual" name="harga_jual" class="form-control" readonly></td>
                                <td>
                                    <input type="text" name="jml" value="0" class="form-control" 
                                           oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0'); 
                                           hitungHargaTotal();" placeholder="">
                                </td>
                                <td>
                                    <input type="text" name="hargatotal" value="0" class="form-control" readonly>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Akhir Tabel -->

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="disabled">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">
                    Simpan <i class="fe fe-check"></i>
                </a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">
                    Batal <i class="fe fe-x"></i>
                </a>
            </div>
        </div>
    </div>
</div>

@section('formTambahJS')
<script>  
    $('input[name="bmkode"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            getpersediaanbyid($('input[name="bmkode"]').val());
        }
    });

    
    function modalBarang() {
        $('#modalBarang').modal('show');
        $('#modaldemo8').addClass('d-none');
        $('input[name="param"]').val('tambah');
        resetValid();
        table2.ajax.reload();
    }

    function searchBarang() {
        getpersediaanbyid($('input[name="bmkode"]').val());
        resetValid();
    }
   
    function getpersediaanbyid(id) {
    $("#loaderkd").removeClass('d-none');
    $.ajax({
        type: 'GET',
        url: "{{ url('admin/persediaan/getpersediaan') }}/" + id,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                $("#loaderkd").addClass('d-none');
                $("#status").val("true");
                $("#kdbarang").val(data[0].barang_kode);
                $("#nmbarang").val(data[0].barang_nama);
                $("#satuan").val(data[0].satuan_nama);
                $("#jenisbarang").val(data[0].jenisbarang_nama);
                $("#merk").val(data[0].merk_nama);
                $("#tglexp").val(data[0].bm_tglex);
                $("#harga_jual").val(data[0].bm_hargajual);
                $("#etalase").val(data[0].bm_etalase);

            } else {
                $("#loaderkd").addClass('d-none');
                $("#status").val("false");
                $("#kdbarang").val('');
                $("#nmbarang").val('');
                $("#satuan").val('');
                $("#jenisbarang").val('');
                $("#merk").val('');
                $("#tglexp").val('');
                $("#totalstok").val('');
                $("#etalase").val('');
                $("#harga_jual").val('');
                $("#etalase").val('');
            }
        }
    });
}

    $("input[name='jml']").on('input', function() {
        hitungHargaTotal();
    });

    // Call hitungHargaTotal function when the price input changes
    $("#harga_jual").on('input', function() {
        hitungHargaTotal();
    });

    // Function to calculate total price
    function hitungHargaTotal() {
        var jumlahKeluar = parseFloat($("input[name='jml']").val()) || 0;
        var hargaJual = parseFloat($("#harga_jual").val()) || 0;

        // Calculate total price
        var hargatotal = jumlahKeluar * hargaJual;

        // Display total price in the total price input
        $("input[name='hargatotal']").val(hargatotal);
    }

    function checkForm() {
        const tglkeluar = $("input[name='tglkeluar']").val();
        const status = $("#status").val();
        const bmkode = $("input[name='bmkode']").val();
        const jml = $("input[name='jml']").val();
        const tujuan = $("input[name='tujuan']").val();
        const hargatotal = $("input[name='hargatotal']").val();
        const etalase = parseFloat($("#etalase").val());
        setLoading(true);
        resetValid();

        if (tglkeluar == "") {
            validasi('Tanggal Keluar wajib di isi!', 'warning');
            $("input[name='tglkeluar']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (status == "false") {
            validasi('Barang wajib di pilih!', 'warning');
            $("input[name='bmkode']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (tujuan == "") {
            validasi('Nama Pembeli wajib di isi!', 'warning');
            $("input[name='tujuan']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (jml == "" || jml == "0") {
            validasi('Jumlah Keluar wajib di isi!', 'warning');
            $("input[name='jml']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (parseFloat(jml) > etalase) {
            validasi('Jumlah melebihi stok di etalase!', 'warning');
            $("input[name='jml']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else {
            submitForm();
        }
    }

    function submitForm() {
    const bkkode = $("input[name='bkkode']").val();
    const tglkeluar = $("input[name='tglkeluar']").val();
    const kdbarang = $("input[name='kdbarang']").val();
    const tujuan = $("input[name='tujuan']").val();
    const jml = $("input[name='jml']").val();
    const tglexp = $("input[name='tglexp']").val(); 
    const harga_jual = $("input[name='harga_jual']").val();
    const etalase = $("input[name='etalase']").val();
    const bmkode = $("input[name='bmkode']").val(); // pastikan bmkode dikirim
    const hargatotal = $("input[name='hargatotal']").val();

    $.ajax({
        type: 'POST',
        url: "{{ route('barang-keluar.store') }}",
        data: {
            _token: "{{ csrf_token() }}",
            bkkode: bkkode,
            tglkeluar: tglkeluar,
            kdbarang: kdbarang,
            tujuan: tujuan,
            jml: jml,
            tglexp: tglexp,
            harga_jual: harga_jual,
            etalase: etalase,
            bmkode: bmkode, // kirim bmkode
            hargatotal: hargatotal,
        },
        beforeSend: function() {
            // Sembunyikan tombol simpan dan tampilkan loader
            $('#btnSimpan').hide();
            $('#btnLoader').removeClass('d-none');
        },
        success: function(data) {
            if (data.success) {
                // Tutup modal setelah sukses
                $('#modaldemo8').modal('toggle'); 
                swal({
                    title: "Berhasil ditambah!",
                    type: "success"
                });
                // Reload tabel data
                table.ajax.reload(null, false);
                // Reset form setelah sukses submit
                resetForm();
            } else {
                swal({
                    title: "Gagal!",
                    text: data.error,
                    type: "error"
                });
            }
        },
        error: function(xhr, status, error) {
            // Tampilkan error jika ada masalah
            swal({
                title: "Gagal!",
                text: 'Gagal memproses permintaan: ' + xhr.responseJSON.message,
                type: "error"
            });
        },
        complete: function() {
            // Setelah proses selesai, tampilkan kembali tombol simpan dan sembunyikan loader
            $('#btnLoader').addClass('d-none');
            $('#btnSimpan').show();
        }
        });
    }

    // Fungsi untuk mereset form setelah berhasil submit
    function resetForm() {
        $("input[name='bkkode']").val('');
        $("input[name='tglkeluar']").val('');
        $("input[name='bmkode']").val('');
        $("input[name='tujuan']").val('');
        $("input[name='jml']").val('0');
        $("input[name='hargatotal']").val('');
        $("#kdbarang").val('');
        $("#nmbarang").val('');
        $("#satuan").val('');
        $("#jenisbarang").val('');
        $("#merk").val('');
        $("#tglexp").val('');    
        $("#harga_jual").val('');
        $("#etalase").val('');
        $("#status").val('false');
        setLoading(false);
    }

    function resetValid() {
        $("input[name='tglkeluar']").removeClass('is-invalid');
        $("input[name='bmkode']").removeClass('is-invalid');
        $("input[name='tujuan']").removeClass('is-invalid');
        $("input[name='jml']").removeClass('is-invalid');
        $("input[name='hargatotal']").removeClass('is-invalid');
    };

    function reset() {
        resetValid();
        $("input[name='bkkode']").val('');
        $("input[name='tglkeluar']").val('');
        $("input[name='bmkode']").val('');
        $("input[name='tujuan']").val('');
        $("input[name='jml']").val('0');
        $("input[name='hargatotal']").val('');
        $("#kdbarang").val('');
        $("#nmbarang").val('');
        $("#satuan").val('');
        $("#jenisbarang").val('');
        $("#merk").val('');
        $("#tglexp").val('');    
        $("#harga_jual").val('');
        $("#etalase").val('');
        $("#status").val('false');
        setLoading(false);
    }

    function setLoading(bool) {
        if (bool == true) {
            $('#btnLoader').removeClass('d-none');
            $('#btnSimpan').addClass('d-none');
        } else {
            $('#btnSimpan').removeClass('d-none');
            $('#btnLoader').addClass('d-none');
        }
    }
</script>
@endsection
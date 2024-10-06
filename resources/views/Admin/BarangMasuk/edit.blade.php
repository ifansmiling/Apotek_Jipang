<!-- MODAL EDIT -->
<div class="modal fade" data-bs-backdrop="static" id="Umodaldemo8">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Barang Masuk</h6>
                <button aria-label="Close" onclick="resetU()" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Kode Barang Masuk -->
                    <div class="col-md-6">
                        <input type="hidden" name="idbmU">
                        <div class="form-group">
                            <label for="bmkodeU" class="form-label">Kode Barang Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="bmkodeU" readonly class="form-control" placeholder="">
                        </div>
                        <!-- Tanggal Masuk -->
                        <div class="form-group">
                            <label for="tglmasukU" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="tglmasukU" class="form-control datepicker-date" placeholder="">
                        </div>
                        <!-- Customer -->
                        <div class="form-group">
                            <label for="customerU" class="form-label">Pilih Customer <span class="text-danger">*</span></label>
                            <select name="customerU" id="customerU" class="form-control">
                                <option value="">-- Pilih Customer --</option>
                                @foreach ($customer as $c)
                                <option value="{{ $c->customer_id }}">{{ $c->customer_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Kode Barang -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Barang <span class="text-danger me-1">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" autocomplete="off" name="kdbarangU" placeholder="">
                                <button class="btn btn-primary-light" onclick="searchBarangU()" type="button"><i class="fe fe-search"></i></button>
                                <button class="btn btn-success-light" onclick="modalBarangU()" type="button"><i class="fe fe-box"></i></button>
                            </div>
                        </div>
                        <!-- Nama Barang -->
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" class="form-control" id="nmbarangU" readonly>
                        </div>
                        <div class="row">
                            <!-- Satuan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuanU" readonly>
                                </div>
                            </div>
                            <!-- Jenis -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <input type="text" class="form-control" id="jenisU" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Fields -->
                <div class="row mt-3">
                    <!-- Harga Jual -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hargajualU" class="form-label">Harga Jual <span class="text-danger">*</span></label>
                            <input type="text" name="hargajualU" class="form-control" placeholder="">
                        </div>
                    </div>
                    <!-- Harga Beli -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="hargabeliU" class="form-label">Harga Beli <span class="text-danger">*</span></label>
                            <input type="text" name="hargabeliU" class="form-control" placeholder="">
                        </div>
                    </div>
                    <!-- Total Harga -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="totalhargaU" class="form-label">Total Harga <span class="text-danger">*</span></label>
                            <input type="text" name="totalhargaU" class="form-control" placeholder="">
                        </div>
                    </div>
                    <!-- Jumlah -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jmlU" class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                            <input type="number" name="jmlU" class="form-control" placeholder="Masukkan Jumlah" value="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-success d-none" id="btnLoaderU" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkFormU()" id="btnSimpanU" class="btn btn-success">Simpan Perubahan <i class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="resetU()" data-bs-dismiss="modal">Batal <i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>

@section('formEditJS')
<script>
    $('input[name="kdbarangU"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            getbarangbyidU($('input[name="kdbarangU"]').val());
        }
    });

    function modalBarangU() {
        $('#modalBarang').modal('show');
        $('#Umodaldemo8').addClass('d-none');
        $('input[name="param"]').val('ubah');
        resetValidU();
        table2.ajax.reload();
    }

    function searchBarangU() {
        getbarangbyidU($('input[name="kdbarangU"]').val());
        resetValidU();
    }

    function getbarangbyidU(id) {
        $("#loaderkdU").removeClass('d-none');
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/barang/getbarang') }}/" + id,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                $("#loaderkdU").addClass('d-none');
                if (data.length > 0) {
                    $("#statusU").val("true");
                    $("#nmbarangU").val(data[0].barang_nama);
                    $("#satuanU").val(data[0].satuan_nama);
                    $("#jenisU").val(data[0].jenisbarang_nama);
                } else {
                    $("#statusU").val("false");
                    $("#nmbarangU").val('');
                    $("#satuanU").val('');
                    $("#jenisU").val('');
                }
            }
        });
    }

    function setLoadingU(isLoading) {
        const btnSimpanU = $('#btnSimpanU');
        const btnLoaderU = $('#btnLoaderU');

        if (isLoading) {
            btnSimpanU.addClass('d-none');
            btnLoaderU.removeClass('d-none');
        } else {
            btnSimpanU.removeClass('d-none');
            btnLoaderU.addClass('d-none');
        }
    }

    function resetValidU() {
        $("input[name='tglmasukU']").removeClass('is-invalid');
        $("input[name='kdbarangU']").removeClass('is-invalid');
        $("select[name='customerU']").removeClass('is-invalid');
        $("input[name='jmlU']").removeClass('is-invalid');
        $("input[name='hargajualU']").removeClass('is-invalid');
        $("input[name='hargabeliU']").removeClass('is-invalid');
        $("input[name='totalhargaU']").removeClass('is-invalid');
    }

    function checkFormU() {
    const tglmasuk = $("input[name='tglmasukU']").val();
    const status = $("#statusU").val();
    const kdbarang = $("input[name='kdbarangU']").val();
    const customer = $("select[name='customerU']").val();
    const jml = $("input[name='jmlU']").val();
    const hargajual = $("input[name='hargajualU']").val();
    const hargabeli = $("input[name='hargabeliU']").val();
    const totalharga = $("input[name='totalhargaU']").val();

    setLoadingU(true);
    resetValidU();

    // Validasi field
    if (tglmasuk === "" || customer === "" || kdbarang === '' || jml === "" || jml === "0" || 
        hargajual === "" || hargabeli === "" || totalharga === "") {
        validasi('Semua field wajib diisi!', 'warning');
        setLoadingU(false); // Menambahkan ini untuk menghentikan loading saat validasi gagal
        return false;
    } else {
        submitFormU();
    }
}

function submitFormU() {
    const id = $("input[name='idbmU']").val();
    const bmkode = $("input[name='bmkodeU']").val();
    const tglmasuk = $("input[name='tglmasukU']").val();
    const kdbarang = $("input[name='kdbarangU']").val();
    const customer = $("select[name='customerU']").val();
    const jml = $("input[name='jmlU']").val();
    const hargajual = $("input[name='hargajualU']").val();
    const hargabeli = $("input[name='hargabeliU']").val();
    const totalharga = $("input[name='totalhargaU']").val();

    $.ajax({
        type: 'POST',
        url: "{{ url('admin/barang-masuk/proses_ubah') }}/" + id,
        data: {
            bmkode: bmkode,
            tglmasuk: tglmasuk,
            barang: kdbarang,
            customer: customer,
            jml: jml,
            hargajual: hargajual,
            hargabeli: hargabeli,
            totalharga: totalharga,
        },
        success: function(data) {
            swal({
                title: "Berhasil diubah!",
                type: "success"
            });
            $('#Umodaldemo8').modal('toggle');
            table.ajax.reload(null, false);
            resetU();
            setLoadingU(false); // Pastikan untuk menghentikan loading di sini
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            setLoadingU(false); // Pastikan untuk menghentikan loading jika ada kesalahan
            validasi('Terjadi kesalahan saat menyimpan data!', 'danger'); // Menambahkan pesan kesalahan
        }
    });
}

function resetU() {
    // Logika untuk mereset form atau modal
    $('input[name="idbmU"]').val('');
    $('input[name="bmkodeU"]').val('');
    $('input[name="tglmasukU"]').val('');
    $('input[name="kdbarangU"]').val('');
    $('#nmbarangU').val('');
    $('#satuanU').val('');
    $('#jenisU').val('');
    $('select[name="customerU"]').val('');
    $('input[name="jmlU"]').val(0);
    $('input[name="hargajualU"]').val('');
    $('input[name="hargabeliU"]').val('');
    $('input[name="totalhargaU"]').val('');
    resetValidU(); // Panggil reset validasi jika perlu
}


</script>
@endsection


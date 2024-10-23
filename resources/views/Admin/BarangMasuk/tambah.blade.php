<!-- MODAL TAMBAH -->
<div class="modal fade" data-bs-backdrop="static" id="modaldemo8">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Obat Masuk</h6><button onclick="reset()" aria-label="Close" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="bmkode" class="form-label">No Nota <span class="text-danger">*</span></label>
                            <input type="text" name="bmkode" class="form-control" placeholder="Masukkan Nomor Nota">
                        </div>
                        <div class="form-group">
                            <label for="tglmasuk" class="form-label">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="text" name="tglmasuk" readonly class="form-control" value="<?php echo date("d-m-Y"); ?>" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="customer" class="form-label">Pilih Supplier <span class="text-danger">*</span></label>
                            <select name="customer" id="customer" class="form-control">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach ($customer as $c)
                                <option value="{{ $c->customer_id }}">{{ $c->customer_nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="hidden" id="status" value="true">
                                <div class="spinner-border spinner-border-sm d-none" id="loaderkd" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </label>
                            <div class="form-input d-flex justify-content-end mt-3">
                                <input type="hidden" class="form-control" autocomplete="off" name="kdbarang" placeholder="">
                                <button class="btn btn-success" onclick="modalBarang()" type="button">Tambah Obat <i class="fe fe-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-3" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Tanggal Kadaluarsa</th>
                            <th class="border-bottom-0">Jumlah Masuk (/Satuan)</th>
                            <th class="border-bottom-0">Harga Jual (/Satuan)</th>
                            <th class="border-bottom-0">Harga Beli (/Satuan)</th>
                            <th class="border-bottom-0">Total Harga</th>
                            <th class="border-bottom-0">Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>  
            <div class="modal-footer">
                <button class="btn btn-primary d-none" id="btnLoader" type="button" disabled="">
                    <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <a href="javascript:void(0)" onclick="checkForm()" id="btnSimpan" class="btn btn-primary">Simpan <i class="fe fe-check"></i></a>
                <a href="javascript:void(0)" class="btn btn-light" onclick="reset()" data-bs-dismiss="modal">Batal <i class="fe fe-x"></i></a>
            </div>
        </div>
    </div>
</div>


@section('formTambahJS')
<script>
    $('input[name="kdbarang"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        getbarangbyid($('input[name="kdbarang"]').val());
    });
    var selectedSupplier = ""; // Inisialisasi selectedSupplier

    function modalBarang() {
        // Jika belum ada supplier yang dipilih, ambil dari dropdown
        if (selectedSupplier === "") {
            const customer = $("select[name='customer']").val();
            if (customer == "") {
                validasi('isi supplier terlebih dahulu!', 'warning');
                $("input[name='customer']").addClass('is-invalid');
                setLoading(false);
                return false;
            } else {
                // Ambil nama supplier yang dipilih
                const customerName = $("select[name='customer'] option:selected").text();
                selectedSupplier = customerName; // Simpan nama supplier yang dipilih
            }
        }

        // Tampilkan modal dan gunakan selectedSupplier untuk pencarian
        $('#modalBarang').modal('show');
        $('#modaldemo8').addClass('d-none');
        $('input[name="param"]').val('tambah');
        resetValid();// Gunakan nama supplier yang disimpan
        table2.search(selectedSupplier).draw(); 
        // table2.ajax.reload();
    }

    function closeModalBarang() {
        // Tetapkan nilai dropdown ke selectedSupplier
        $("select[name='customer']").val($("select[name='customer'] option").filter(function() {
            return $(this).text() === selectedSupplier; // Mencari option dengan nama supplier
        }).val()).change(); // Memastikan dropdown memperbarui tampilannya

        $('#modalBarang').modal('show'); 
    }
    function searchBarang() {
        getbarangbyid($('input[name="kdbarang"]').val());
        resetValid();
    }
   
    function tambahDataKeTabel() {
                const kdbarang = $("input[name='kdbarang']").val();
                const existingRow = $("#table-3 tbody tr").filter(function() {
                    return $(this).find("td:nth-child(2)").text() === kdbarang;
                });

                if(existingRow.length > 0){
                    validasi('Obat sudah ada dalam tabel!', 'warning');
                }else{
                    const newRow = $("<tr>");
                    newRow.append("<td></td>");
                    newRow.append("<td>" + kdbarang + "</td>");
                    newRow.append("<td><input type='text' class='form-control nmbarang' name='nmbarang[]' readonly></td>");
                    newRow.append("<td><input type='text' class='form-control satuan' name='satuan[]' readonly></td>");
                    newRow.append("<td><input type='text' class='form-control jenis' name='jenis[]' readonly></td>");
                    newRow.append("<td><input type='text' class='form-control merk' name='merk[]' readonly></td>");
                    newRow.append("<td><input type='date' name='tglkadaluarsa[]' class='form-control datepicker-date' value=''></td>");
                    newRow.append("<td><input type='text' name='jml[]' class='form-control'></td>");
                    newRow.append("<td><input type='text' name='hargajual[]' class='form-control'></td>");
                    newRow.append("<td><input type='text' name='hargabeli[]' class='form-control'></td>");
                    newRow.append("<td><input type='text' name='totalharga[]' class='form-control totalharga' readonly></td>");
                    newRow.append("<td><button type='button' class='btn btn-danger' onclick='hapusBaris(this)'>Hapus</button></td>");
                    $("#table-3 tbody").append(newRow);
                    updateNomorUrut();
                    fillDataFromAjax(kdbarang, newRow);
                    hitungTotalHarga();
                }
    }

    function fillDataFromAjax(kdbarang, newRow) {
        $.ajax({
            type: 'GET',
            url: "{{ url('admin/barang/getbarang') }}/" + kdbarang,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    newRow.find(".nmbarang").val(data[0].barang_nama);
                    newRow.find(".satuan").val(data[0].satuan_nama);
                    newRow.find(".jenis").val(data[0].jenisbarang_nama);
                    newRow.find(".merk").val(data[0].merk_nama);
                    newRow.find("input[name='tglkadaluarsa[]']").val(data[0].bm_tglex);
                    newRow.find("input[name='jml[]']").val(data[0].bm_jumlah);
                    newRow.find("input[name='hargajual[]']").val(data[0].bm_hargajual);
                    newRow.find("input[name='hargabeli[]']").val(data[0].bm_hargabeli);
                    newRow.find("input[name='totalharga[]']").val(data[0].bm_totalharga);
                }
            }
        });
    }

    function hapusBaris(button) {
        $(button).closest('tr').remove();
        updateNomorUrut(); 
    }

    function updateNomorUrut() {
        $("#table-3 tbody tr").each(function(index) {
            $(this).find("td:first").text(index + 1);
        });
    }

    $("#table-3").on('input', "input[name='jml[]'], input[name='hargabeli[]']", function() {
        hitungTotalHarga();
    });

    function resetTable() {
     $("#table-3 tbody").empty(); 
    }


    function hitungTotalHarga() {
        $("#table-3 tbody tr").each(function() {
            var jumlahMasuk = parseFloat($(this).find("input[name='jml[]']").val());
            var hargaBeli = parseFloat($(this).find("input[name='hargabeli[]']").val());

            var totalHarga = jumlahMasuk * hargaBeli;

            if (isNaN(jumlahMasuk) || isNaN(hargaBeli) || jumlahMasuk === 0 || hargaBeli === 0) {
                totalHarga = "";
            }

            $(this).find("input[name='totalharga[]']").val(totalHarga);
        });
    }

    $("input[name='jml[]'], input[name='hargabeli[]']").on('input', function() {
        hitungTotalHarga();
    });

    function checkForm() {
        const bmkode = $("input[name='bmkode']").val();
        const tglmasuk = $("input[name='tglmasuk']").val();
        const status = $("#status").val();
        const customer = $("select[name='customer']").val();
        const jml = $("input[name='jml[]']").val();
        const tglkadaluarsa = $("input[name='tglkadaluarsa[]']").val();
        const hargajual = $("input[name='hargajual[]']").val();
        const hargabeli = $("input[name='hargabeli[]']").val();
        const totalharga = $("input[name='totalharga[]']").val();
        hitungTotalHarga();
        setLoading(true);
        resetValid();

        if (bmkode == "") {
            validasi('No Nota wajib di isi!', 'warning');
            $("input[name='bmkode']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (tglmasuk == "") {
            validasi('Tanggal Masuk wajib di isi!', 'warning');
            $("input[name='tglmasuk']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (customer == "") {
            validasi('Customer wajib di pilih!', 'warning');
            $("select[name='customer']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (status == "false") {
            validasi('Barang wajib di pilih!', 'warning');
            $("input[name='kdbarang']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (tglkadaluarsa == "") {
            validasi('Tanggal Kadaluarsa wajib di isi!', 'warning');
            $("input[name='tglkadaluarsa[]']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (jml == "" || jml == "0") {
            validasi('Jumlah Masuk wajib di isi!', 'warning');
            $("input[name='jml[]']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (hargajual == "" || hargajual == "0") {
            validasi('Harga Jual wajib di isi!', 'warning');
            $("input[name='hargajual[]']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else if (hargabeli == "" || hargabeli == "0") {
            validasi('Harga Beli wajib di isi!', 'warning');
            $("input[name='hargabeli[]']").addClass('is-invalid');
            setLoading(false);
            return false;
        } else {
            submitForm();
        }

    }

    function submitForm() {
    const bmkode = $("input[name='bmkode']").val();
    const tglmasuk = $("input[name='tglmasuk']").val();
    const customer = $("select[name='customer']").val();
    
    let barangList = [];
    $("#table-3 tbody tr").each(function() {
        const kdbarang = $(this).find("td:nth-child(2)").text();
        const nmbarang = $(this).find("input[name='nmbarang[]']").val();
        const satuan = $(this).find("input[name='satuan[]']").val();
        const jenis = $(this).find("input[name='jenis[]']").val();
        const tglkadaluarsa = $(this).find("input[name='tglkadaluarsa[]']").val();
        const jml = $(this).find("input[name='jml[]']").val();
        const hargajual = $(this).find("input[name='hargajual[]']").val();
        const hargabeli = $(this).find("input[name='hargabeli[]']").val();
        const totalharga = $(this).find("input[name='totalharga[]']").val();
        
        barangList.push({
            kdbarang: kdbarang,
            nmbarang: nmbarang,
            satuan: satuan,
            jenis: jenis,
            tglkadaluarsa: tglkadaluarsa,
            jml: jml,
            hargajual: hargajual,
            hargabeli: hargabeli,
            totalharga: totalharga
        });
    });

    $.ajax({
        type: 'POST',
        url: "{{ route('barang-masuk.store') }}",
        enctype: 'multipart/form-data',
        data: {
            bmkode: bmkode,
            tglmasuk: tglmasuk,
            customer: customer,
            barangList: barangList, // Mengirim semua barang dalam satu array
        },
        success: function(data) {
            $('#modaldemo8').modal('toggle');
            swal({
                title: "Berhasil ditambah!",
                type: "success"
            });
            table.ajax.reload(null, false);
            resetTable();
            reset();
        }
    });
}


    function resetValid() {
        $("input[name='tglmasuk']").removeClass('is-invalid');
        $("input[name='kdbarang']").removeClass('is-invalid');
        $("select[name='customer']").removeClass('is-invalid');
        $("input[name='jml[]']").removeClass('is-invalid');
        $("input[name='tglkadaluarsa[]']").removeClass('is-invalid');
        $("input[name='hargajual[]']").removeClass('is-invalid');
        $("input[name='hargabeli[]']").removeClass('is-invalid');
        $("input[name='totalharga[]']").removeClass('is-invalid');
    };

    function reset() {
        resetValid();
        resetTable();
        $("input[name='bmkode']").val('');
        $("input[name='kdbarang']").val('');
        $("select[name='customer']").val('');
        $("input[name='jml[]']").val('0');
        $("input[name='tglkadaluarsa[]']").val('');
        $("input[name='hargajual[]']").val('');
        $("input[name='hargabeli[]']").val('');
        $("input[name='totalharga[]']").val('');
        $("#nmbarang").val('');
        $("#satuan").val('');
        $("#jenis").val('');
        $("#merk").val('');
        $("#status").val('false');
        setLoading(false);
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); 
        const yyyy = today.getFullYear();
        const formattedDate = dd + '-' + mm + '-' + yyyy;
        $("input[name='tglmasuk']").val(formattedDate);
        selectedSupplier = "";
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
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
                            <input type="text" name="bkkode" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="tglkeluar" class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                            <input type="text" name="tglkeluar" readonly class="form-control" value="<?php echo date("d-m-Y"); ?>" placeholder="">
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
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
                                
                            <input type="hidden" class="form-control" autocomplete="off" name="kdbarang" placeholder="">
                                <button class="btn btn-success" onclick="modalBarang()" type="button">Tambah Obat <i class="fe fe-plus"></i></button>
                              
                            </div>
<<<<<<< HEAD
=======
                        </label>
                        <div class="input-group d-flex justify-content-end mr-3">
                            <input type="hidden" class="form-control" autocomplete="off" name="bm_id" placeholder="">
                            <button class="btn btn-success" onclick="modalBarang()" type="button">Tambah Obat <i class="fe fe-plus"></i></button>
>>>>>>> 02d7c5665bd24ff38656fa2fc2bc2ca42906123e
                        </div>
                    </div>
                </div>

                <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelObatKeluar" class="table table-bordered text-nowrap border-bottom dataTable no-footer dtr-inline collapsed">
                        <thead>
<<<<<<< HEAD
                            <tr>
                                <th style="width: 100px;">Kode Obat</th>
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
=======
                            <th class="border-bottom-0" width="1%">No</th>
                            <th class="border-bottom-0">bmID</th>
                            <th class="border-bottom-0">No Nota</th>
                            <th class="border-bottom-0">Kode Obat</th>
                            <th class="border-bottom-0">Nama Obat</th>
                            <th class="border-bottom-0">Satuan</th>
                            <th class="border-bottom-0">Jenis</th>
                            <th class="border-bottom-0">Kategori</th>
                            <th class="border-bottom-0">Tanggal Kadaluarsa</th>
                            <th class="border-bottom-0">Etalase</th>
                            <th class="border-bottom-0">Harga Jual (/Satuan)</th>
                            <th class="border-bottom-0">Jumlah Keluar (/Satuan)</th>
                            <th class="border-bottom-0">Total Harga</th>
                            <th class="border-bottom-0">Action</th>
                        </thead>
                        <tbody>
>>>>>>> 02d7c5665bd24ff38656fa2fc2bc2ca42906123e
                        </tbody>
                    </table>
                </div>
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
    $('input[name="bm_id"]').keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
            getpersediaanbyid($('input[name="bm_id"]').val());
    });

    function modalBarang() {
        $('#modalBarang').modal('show');
        $('#modaldemo8').addClass('hide');
        $('input[name="param"]').val('tambah');
        resetValid();
        table2.ajax.reload();
    }

    function closeModalBarang() {
        $('#modalBarang').modal('hide'); 
    }

    function searchBarang() {
        getpersediaanbyid($('input[name="bm_id"]').val());
        resetValid();
    }

    function tambahBarisObat() {
    // Ambil nilai dari inputan
        const bmid = $("input[name='bm_id']").val();
        const existingRow = $("#tabelObatKeluar tbody tr").filter(function() {
            return $(this).find("td:nth-child(2)").text() === bmid;
        });

        if(existingRow.length > 0){
            validasi('Obat sudah ada dalam tabel!', 'warning');                
        }else{                
            const barisBaru = $("<tr>");
            barisBaru.append("<td></td>");
            barisBaru.append("<td>" + bmid + "</td>");
            barisBaru.append("<td><input type='text' class='form-control bmkode' name='bmkode[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control kdbarang' name='kdbarang[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control nmbarang' name='nmbarang[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control satuan' name='satuan[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control jenisbarang' name='jenisbarang[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control merk' name='merk[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control tglexp' name='tglexp[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control etalase' name='etalase[]' readonly></td>");
            barisBaru.append("<td><input type='text' class='form-control harga_jual' name='harga_jual[]' readonly></td>");
            barisBaru.append("<td><input type='text' name='jml[]' class='form-control'></td>");
            barisBaru.append("<td><input type='text' name='hargatotal[]' class='form-control hargatotal' readonly></td>");
            barisBaru.append("<td><button type='button' class='btn btn-danger' onclick='hapusBaris(this)'>Hapus</button></td>");
            // Tambahkan baris baru ke tabel
            $("#tabelObatKeluar").append(barisBaru);
            updateNomorUrut(); 
            getpersediaanbyid(bmid, barisBaru);
            hitungHargaTotal();
        }
    }

    function getpersediaanbyid(bmid, barisBaru) {
    $.ajax({
        type: 'GET',
        url: "{{ url('admin/persediaan/getpersediaan') }}/" + bmid,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
            if (data.length > 0) {
                console.log(data); // Log data untuk memastikan data berhasil didapat
                barisBaru.find(".kdbarang").val(data[0].barang_kode);
                barisBaru.find(".bmkode").val(data[0].bm_kode);
                barisBaru.find(".nmbarang").val(data[0].barang_nama);
                barisBaru.find(".satuan").val(data[0].satuan_nama);
                barisBaru.find(".jenisbarang").val(data[0].jenisbarang_nama);
                barisBaru.find(".merk").val(data[0].merk_nama);
                barisBaru.find(".tglexp").val(data[0].bm_tglex);
                barisBaru.find(".etalase").val(data[0].bm_etalase);
                barisBaru.find(".harga_jual").val(data[0].bm_hargajual);
            } else {
                alert("Data obat tidak ditemukan.");
            }
        }
    });
    }

    function hapusBaris(button) {
        $(button).closest('tr').remove();
        updateNomorUrut(); 
    }

    function updateNomorUrut() {
        $("#tabelObatKeluar tbody tr").each(function(index) {
            $(this).find("td:first").text(index + 1);
        });
    }

    $("#tabelObatKeluar").on('input', "input[name='jml[]']", function() {
        hitungHargaTotal();
    });

    function resetTable() {
     $("#tabelObatKeluar tbody").empty(); 
    }

    // Function to calculate total price
    function hitungHargaTotal() {
        // Loop through each row in the table
        $("#tabelObatKeluar tbody tr").each(function() {
            var jumlahKeluar = parseFloat($(this).find("input[name='jml[]']").val()) || 0;
            var hargaJual = parseFloat($(this).find("input[name='harga_jual[]']").val()) || 0;

            // Calculate total price
            var hargatotal = jumlahKeluar * hargaJual;

            // Display total price in the total price input
            $(this).find("input[name='hargatotal[]']").val(hargatotal);
        });
    }

    // Event listener untuk input jumlah keluar
    $("#tabelObatKeluar").on('input', "input[name='jml[]']", function() {
        const row = $(this).closest('tr'); // Ambil baris saat ini
        const etalase = parseFloat(row.find("input[name='etalase[]']").val()) || 0; // Ambil nilai etalase dari baris yang bersangkutan
        const jumlahKeluar = parseFloat($(this).val()) || 0; // Ambil nilai jumlah keluar yang diinputkan

        // Validasi jika jumlah keluar melebihi etalase
        if (jumlahKeluar > etalase) {
            validasi('Jumlah melebihi stok di etalase!', 'warning');
            $(this).val(etalase); // Atur kembali nilai ke etalase jika melebihi
        }

        // Hitung total harga
        hitungHargaTotal();
    });



    function checkForm() {
        const tglkeluar = $("input[name='tglkeluar']").val();
        const status = $("#status").val();
        const bmkode = $("input[name='bmkode']").val();
        const jml = $("input[name='jml']").val();
        const tujuan = $("input[name='tujuan']").val();
        const hargatotal = $("input[name='hargatotal']").val();
        const etalase = parseFloat($("#etalase").val());
        hitungHargaTotal();
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
        } else if (parseFloat(jml) > etalase) { // Periksa jika jumlah melebihi etalase
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
    const tujuan = $("input[name='tujuan']").val();

    let barangList = [];
    $("#tabelObatKeluar tbody tr").each(function() {
        const bmid = $(this).find("td:nth-child(2)").text();
        const bmkode = $(this).find("input[name='bmkode[]']").val();
        const kdbarang = $(this).find("input[name='kdbarang[]']").val();
        const nmbarang = $(this).find("input[name='nmbarang[]']").val();
        const satuan = $(this).find("input[name='satuan[]']").val();
        const jenis = $(this).find("input[name='jenisbarang[]']").val();
        const merk = $(this).find("input[name='merk[]']").val();
        const tglexp = $(this).find("input[name='tglexp[]']").val();
        const etalase = $(this).find("input[name='etalase[]']").val();
        const harga_jual = $(this).find("input[name='harga_jual[]']").val();
        const jml = $(this).find("input[name='jml[]']").val();
        const hargatotal = $(this).find("input[name='hargatotal[]']").val();

        barangList.push({
            bmid: bmid,
            bmkode: bmkode,
            kdbarang: kdbarang,
            nmbarang: nmbarang,
            satuan: satuan,
            jenis: jenis,
            merk: merk,
            tglexp: tglexp,
            etalase: etalase,
            harga_jual: harga_jual,
            jml: jml,
            hargatotal: hargatotal
        });
    });

    $.ajax({
        type: 'POST',
        url: "{{ route('barang-keluar.store') }}",
        data: {
            _token: "{{ csrf_token() }}", // Pastikan Anda menyertakan CSRF token di sini
            bkkode: bkkode,
            tglkeluar: tglkeluar,
            tujuan: tujuan,
            barangList: barangList,
        },
        success: function(data) {
            if(data.success) {
                $('#modaldemo8').modal('toggle');
                swal({
                    title: "Berhasil ditambah!",
                    type: "success"
                });
                table.ajax.reload(null, false);
<<<<<<< HEAD
                reset();
            }
        });
    }
    
=======
                resetTable();
                reset();
            } else {
                swal({
                    title: "Gagal ditambah!",
                    text: data.error,
                    type: "error"
                });
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText); // Untuk debugging jika terjadi error
            swal({
                title: "Error",
                text: "Terjadi kesalahan pada server!",
                type: "error"
            });
        }
    });
}


    $.ajax({
        type: 'POST',
        url: "{{ route('barang-keluar.store') }}",
        enctype: 'multipart/form-data',
        data: {
            bkkode: bkkode,
            tglkeluar: tglkeluar,
            tujuan: tujuan,
            barangList: barangList,
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
    


>>>>>>> 02d7c5665bd24ff38656fa2fc2bc2ca42906123e

    function resetValid() {
        $("input[name='tglkeluar']").removeClass('is-invalid');
        $("input[name='bm_id']").removeClass('is-invalid');
        $("input[name='tujuan']").removeClass('is-invalid');
        $("input[name='jml[]']").removeClass('is-invalid');
        $("input[name='hargatotal[]']").removeClass('is-invalid');
    };

    function reset() {
        resetValid();
        resetTable();
        $("input[name='bkkode']").val('');
        $("input[name='tglkeluar']").val('');
        $("input[name='bm_id']").val('');
        $("input[name='tujuan']").val('');
        $("input[name='jml[]']").val('0');
        $("input[name='hargatotal[]']").val('');
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
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); 
        const yyyy = today.getFullYear();
        const formattedDate = dd + '-' + mm + '-' + yyyy;
        $("input[name='tglkeluar']").val(formattedDate);
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

//dokumen siap panggil
$(document).ready(function () {
    // Main Template Color
    var brandPrimary = '#33b35a';
    // ------------------------------------------------------- //
    // Custom Scrollbar
    // ------------------------------------------------------ //

    if ($(window).outerWidth() > 992) {
         $(window).on("load",function(){
            $("nav.side-navbar").mCustomScrollbar({
                scrollInertia: 200
            });
        });
    }

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })

    // ------------------------------------------------------- //
    // Side Navbar Functionality
    // ------------------------------------------------------ //
    $('#toggle-btn').on('click', function (e) {

        e.preventDefault();

        if ($(window).outerWidth() > 1194) {
            $('nav.side-navbar').toggleClass('shrink');
            $('.page').toggleClass('active');
        } else {
            $('nav.side-navbar').toggleClass('show-sm');
            $('.page').toggleClass('active-sm');
        }
    });


    // ------------------------------------------------------- //
    // Transition Placeholders
    // ------------------------------------------------------ //
    $('input').on('focus', function () {
        $(this).siblings('.label-custom').addClass('active');
    });

    $('input').on('blur', function () {
        $(this).siblings('.label-custom').removeClass('active');

        if ($(this).val() !== '') {
            $(this).siblings('.label-custom').addClass('active');
        } else {
            $(this).siblings('.label-custom').removeClass('active');
        }
    });
    
    $('#see_ubah_pass')
        .mouseup(function(){
            $('#pass_baru').attr('type','password');
        })
        .mousedown(function(){
            $('#pass_baru').attr('type','text');
        })
    // ------------------------------------------------------- //
    // External links to new window
    // ------------------------------------------------------ //

    $('.external').on('click', function (e) {

        e.preventDefault();
        window.open($(this).attr("href"));
    });


    // ------------------------------------------------------- //
    // MEMANGGIL FUNGSI JS
    // ------------------------------------------------------ //

    //menentukan uri segment di js
    var url = get_url(parseInt(uri_js));
    var url2 = get_url((parseInt(uri_js)+1));
    var url3 = get_url((parseInt(uri_js)+2));

    //memanggil fungsi datatabel
    if(url == "datapeserta"){
        Datatabel("datatable",base_url+"administrator/datapeserta/fetch_data_peserta",
            [{"targets" : "no-sort","orderable" : false}]);
    }
    else if(url == "soaltrial"){
        Datatabel("datatrial",base_url+"administrator/soaltrial/look_all_d4t4",
            [{"orderable" : false,"targets" : '_all'}]);
        if(url2 == "edit"){
            TextEditor("soal",base_url+'importimage/upload');
            TextEditor("opsia",base_url+'importimage/upload');
            TextEditor("opsib",base_url+'importimage/upload');
            TextEditor("opsic",base_url+'importimage/upload');
            TextEditor("opsid",base_url+'importimage/upload');
        }
    }
    else if(url == "banksoalv1"){
        Datatabel("dataversi1",base_url+"administrator/banksoalv1/look_all_d4t4",
            [{"targets" : '_all',"orderable" : false}]);
        
        $(document).on('change','#kategori',function(){
            var category = $(this).val();
            $('#dataversi1').DataTable().destroy();
            if(category != ''){
                Datatabel("dataversi1",base_url+"administrator/banksoalv1/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}],category);
            }
            else{
                Datatabel("dataversi1",base_url+"administrator/banksoalv1/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}]);
            }
        });

        if(url2 == "edit"){
            TextEditor("soal",base_url+'importimage/uploadsoal');
            TextEditor("opsia",base_url+'importimage/uploadsoal');
            TextEditor("opsib",base_url+'importimage/uploadsoal');
            TextEditor("opsic",base_url+'importimage/uploadsoal');
            TextEditor("opsid",base_url+'importimage/uploadsoal');
        }
    }
    else if(url == "banksoalv2"){
        Datatabel("dataversi2",base_url+"administrator/banksoalv2/look_all_d4t4",
            [{"targets" : '_all',"orderable" : false}]);
        
        $(document).on('change','#kategori',function(){
            var category = $(this).val();
            $('#dataversi2').DataTable().destroy();
            if(category != ''){
                Datatabel("dataversi2",base_url+"administrator/banksoalv2/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}],category);
            }
            else{
                Datatabel("dataversi2",base_url+"administrator/banksoalv2/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}]);
            }
        });

        if(url2 == "edit"){
            TextEditor("soal",base_url+'importimage/uploadsoal');
            TextEditor("opsia",base_url+'importimage/uploadsoal');
            TextEditor("opsib",base_url+'importimage/uploadsoal');
            TextEditor("opsic",base_url+'importimage/uploadsoal');
            TextEditor("opsid",base_url+'importimage/uploadsoal');
        }
    }
    else if(url == "banksoalv3"){
        Datatabel("dataversi3",base_url+"administrator/banksoalv3/look_all_d4t4",
            [{"targets" : '_all',"orderable" : false}]);
        
        $(document).on('change','#kategori',function(){
            var category = $(this).val();
            $('#dataversi3').DataTable().destroy();
            if(category != ''){
                Datatabel("dataversi3",base_url+"administrator/banksoalv3/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}],category);
            }
            else{
                Datatabel("dataversi3",base_url+"administrator/banksoalv3/look_all_d4t4",
                [{"targets" : '_all',"orderable" : false}]);
            }
        });

        if(url2 == "edit"){
            TextEditor("soal",base_url+'importimage/uploadsoal');
            TextEditor("opsia",base_url+'importimage/uploadsoal');
            TextEditor("opsib",base_url+'importimage/uploadsoal');
            TextEditor("opsic",base_url+'importimage/uploadsoal');
            TextEditor("opsid",base_url+'importimage/uploadsoal');
        }
    }
    else if(url == "kategorisoal"){
        Datatabel("datakategori",base_url+"administrator/kategorisoal/data",
            [{"targets" : "no-sort","orderable" : false}]);
    }
    else if(url == "dataoperator"){
        Datatabel("dataoperator",base_url+"administrator/dataoperator/data",
            [{"targets" : "no-sort","orderable" : false}]);
            $('#peran').on('change',function(){
                var value = $(this).val();
                if(value == 'operator ruangan'){
                    $('#tr-periode').show();
                    $('#tr-idruang').show();
                    $("#periode").prop('required',true);
                    $("#idruang").prop('required',true);
                }
                else{
                    $('#tr-periode').hide();
                    $('#tr-idruang').hide();
                    $('#periode').removeAttr('required');
                    $('#idruang').removeAttr('required');
                }
            });

        $('#m_dataoperator').on('shown.bs.modal', function () {
            var value = $('#peran').val();
                if(value == 'operator ruangan'){
                    $('#tr-periode').show();
                    $('#tr-idruang').show();
                    $("#periode").prop('required',true);
                    $("#idruang").prop('required',true);
                }
                else{
                    $('#tr-periode').hide();
                    $('#tr-idruang').hide();
                    $('#periode').removeAttr('required');
                    $('#idruang').removeAttr('required');
                }
        });

        $('#see_pass')
        .mouseup(function(){
            $('#password').attr('type','password');
        })
        .mousedown(function(){
            $('#password').attr('type','text');
        })
    }
    else if(url == "dataruang"){
        Datatabel("dataruang",base_url+"administrator/dataruang/data",
            [{"targets" : "_all","orderable" : false}]);
    }
    else if(url == "aktivasisoal"){
        Datatabel("aktivasisoal",base_url+"administrator/aktivasisoal/data",
            [{"targets" : "_all","orderable" : false}]);
        if(url2 == "lihatnilai"){
            Datatabel("lihatnilai",base_url+"administrator/aktivasisoal/data_rekap/"+url3,
            [{"targets" : "no-sort","orderable" : false}]);
        }
    }
    else if(url == "rekapnilai"){
        var ujian = '<thead class="text-center thead-light"><tr><th width="5%">Id</th><th width="20%">Nama</th><th width="15%">No Peserta</th><th width="15%">Pilih Prodi</th><th width="10%">Periode</th><th width="15%">Nilai</th><th class="no-sort" width="20%">Aksi</th></tr></thead><tbody></tbody><tfoot class="text-center thead-light"><tr><th width="5%">Id</th><th width="20%">Nama</th><th width="15%">No Peserta</th><th width="15%">Pilih Prodi</th><th width="10%">Periode</th><th width="15%">Nilai</th><th class="no-sort" width="20%">Aksi</th></tr></tfoot>';
        var trial = '<thead class="text-center thead-light"><tr><th width="5%">Id</th><th width="20%">Nama</th><th width="15%">No Peserta</th><th width="15%">Pilih Prodi</th><th width="10%">Periode</th><th width="15%">Nilai</th><th class="no-sort" width="20%">Status</th></tr></thead><tbody></tbody><tfoot class="text-center thead-light"><tr><th width="5%">Id</th><th width="20%">Nama</th><th width="15%">No Peserta</th><th width="15%">Pilih Prodi</th><th width="10%">Periode</th><th width="15%">Nilai</th><th class="no-sort" width="20%">Status</th></tr></tfoot>';
        $('#rekapnilaiavg').html(ujian);
        Datatabel("rekapnilaiavg",base_url+"administrator/rekapnilai/data_rekap_rata2",[{"targets" : "no-sort","orderable" : false}]);

        $('#refresh_ujian,#refresh_trial').on('click',function(){
            $('#rekapnilaiavg').DataTable().ajax.reload(null,false);
        });

        $('#pilih_rekap').on('change',function(){
            var value = $(this).val();
            if(value == ""){
                $('#rekapnilaiavg').DataTable().destroy();
                $('#rekapnilaiavg').empty();
                $('#rekapnilaiavg').html(ujian);
                Datatabel("rekapnilaiavg",base_url+"administrator/rekapnilai/data_rekap_rata2",[{"targets" : "no-sort","orderable" : false}]);
                $('#link-rekap').attr('href',base_url+"export/excelrata2");
                $('button').attr('id',"refresh_ujian");
            }
            else{
                $('#rekapnilaiavg').DataTable().destroy();
                $('#rekapnilaiavg').empty();
                $('#rekapnilaiavg').html(trial);
                Datatabel("rekapnilaiavg",base_url+"administrator/rekapnilai/data_rekap_trial",[{"targets" : "no-sort","orderable" : false}]);
                $('#link-rekap').attr('href',base_url+"export/exceltrial");
                $('button').attr('id',"refresh_trial");
            }
        });

        updateData();
        setInterval(function(){updateData()},3000);
    }
    else if(url == 'lihat_laporan'){
        Datatabel("lihat_laporan",base_url+"administrator/lihat_laporan/data_rekap",
            [{"targets" : '_all',"orderable" : false}]);

        $('.periode').select2({
            width: '75%'
        });
        
        $('#refresh_laporan').on('click',function(){
            $('#lihat_laporan').DataTable().ajax.reload(null,false);
        });

        $('#cetak_laporan').attr('href',base_url+"export/excel");

        $(document).on('change','#periode',function(){
            var periode = $(this).val();
            $('#lihat_laporan').DataTable().destroy();
            if(periode != ''){
                Datatabel("lihat_laporan",base_url+"administrator/lihat_laporan/data_rekap",
                [{"targets" : '_all',"orderable" : false}],periode);
                $('#cetak_laporan').attr('href',base_url+"export/excel/"+periode);
            }
            else{
                Datatabel("lihat_laporan",base_url+"administrator/lihat_laporan/data_rekap",
                [{"targets" : '_all',"orderable" : false}]);
                $('#cetak_laporan').attr('href',base_url+"export/excel");
            }
        });
    }

    // //memanggil notif
    // if(localStorage.getItem("notif")){
    //     toastr.success(localStorage.getItem("notif"),'Sukses!',{
    //         timeOut: 2000,
    //         "positionClass": "toast-top-center",
    //         "progressBar": true
    //     });
    //     localStorage.clear();
    // }

    // if(localStorage.getItem("notif_swal")){
    //     swal({
    //         title: "Sukses!",
    //         text: localStorage.getItem("notif_swal"),
    //         timer: 1500,
    //         showConfirmButton: false,
    //         type: 'success'
    //     });
    //     localStorage.clear();
    // }

});

    // ------------------------------------------------------- //
    // DECLARE JS FUNCTION
    // ------------------------------------------------------ //
    function updateData(){
        $.getJSON(base_url+"administrator/rekapnilai/progress",function(data){
            $('#banyak_soal').html(data.angka);
            $('#kategori-uji').html(data.kategori);
        });
    }

    //fungsi global
    function TextEditor(id,url){
            $('#'+id).froalaEditor({
                toolbarSticky: false,
                imageUploadURL: url,
                toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 
                                 'strikeThrough', 'subscript', 'superscript', '|', 
                                 'fontFamily', 'fontSize', 'color', 'inlineStyle', 
                                 'paragraphStyle', '|', 'paragraphFormat', 'align', 
                                 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', '-', 
                                 'insertLink', 'insertImage', 'embedly','insertTable', '|',
                                 'specialCharacters', 'insertHR', 'selectAll', 'clearFormatting', 
                                 '|', 'print', 'spellChecker', 'help', 'html', '|', 'undo', 'redo'],
                imageUploadParams: {
                    id: 'my_editor',
                    "csrf_token" : data_csrf.token_value
                },
            })
    }

    function get_url(segmen) {
        var url1 = window.location.protocol;
        var url2 = window.location.host;
        var url3 = window.location.pathname;
        var pathArray = window.location.pathname.split('/');
        return pathArray[segmen];
    }

    function Datatabel(identifier,url,config,data) {
      $('#'+identifier).DataTable({
        responsive : true,
        "autoWidth" : false,
        "language": {
            "emptyTable":     "Data kosong",
            "info":           "Menampilkan _START_ - _END_ dari _TOTAL_ entri",
            "infoEmpty":      "Menampilkan 0 - 0 dari 0 entri",
            "infoFiltered":   "(filter dari total _MAX_ entri)",
            "lengthMenu":     "Menampilkan _MENU_ entri",
            "loadingRecords": "Loading...",
            "processing":     "Sedang Proses...",
            "search":         "Cari:",
            "zeroRecords":    "Tak ada record yang cocok",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Next",
                "previous":   "Prev"
            }
        },
        "columnDefs": config,
        processing: true,
        serverSide: true,
        "ajax":{
            "url" : url, // json datasource
            "type": "POST",
            data : {data : data}    
        }
    }); 
    }

    //end fungsi global
    function get_pass(){
        $('#m_ubahpassword').modal('show');
        $.ajax({
            type : "GET",
            url : base_url+"administrator/rubah_password",
            success : function(response){
                $('#username').val(response.data);
                $('#pass_lama').val('');
                $('#pass_baru').val('');
                $('#konf_baru').val('');
            }
        }); 
    }

    function ubah_password(){
        var data = $('#edit_pass').serialize();
        $.ajax({
            type : "post",
            url : base_url+"administrator/rubah_password/simpan",
            data : data,     
        }).done(function(response){
            if(response.status == "ok"){
                $('#m_ubahpassword').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.msg,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });
            }
            else{
                toastr.error(response.msg,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
        });

        return false;
    }

    function logout(){
        var modal_html = '<div id="m_soaltrial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade"><div role="document" class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 id="exampleModalLabel" class="modal-title">Konfirmasi Logout</h5><button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button></div><div class="modal-body"><p>Keluar dari sistem ini ?</p></div><div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-success"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button><a href="#" class="btn btn-danger" id="delete_link"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Keluar</a ></div></div></div></div>';
        $("#modal-logout").html(modal_html);
        $("#m_soaltrial").modal('show');
        $("#delete_link").attr('href',base_url+"administrator/logout");
    }

    function list_ganda(){
        $('#m_akun').modal('show');
        $.ajax({
            type : "GET",
            url : base_url+"administrator/datapeserta/akun_ganda",
            success : function(response){
                $('#data-akun').html(response.data);
            }
        }); 
    }

    //begin siswa region
    function m_siswa_e(id){
        $("#m_siswa").modal('show');
        $("#content-peserta").hide();
        $("#alert-proses").show();
        $.ajax({
            type: "GET",
            url: base_url+"administrator/datapeserta/editdatapeserta/"+id,
            success: function(response) {
                if(response.data.id != 0){
                    $("#alert-proses").hide();
                    $("#content-peserta").show();
                    $("#id").val(response.data.id);
                    $("#nama").val(response.data.nama);
                    $("#nopeserta").val(response.data.no_peserta);
                    $("#nokursi").val(response.data.no_kursi);
                    $("#kodeprodi").val(response.data.kode_prodi);
                    $("#periode").val(response.data.periode);
                    $("#pilihprodi").val(response.data.pilih_prodi);
                    $("#tgllahir").val(response.data.tgl_lahir);
                    $("#nama").focus();
                }
                    $("#header-modal-siswa").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function m_siswa_simpan(){
        var data = $("#edit_peserta").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/datapeserta/simpan_data_peserta",
            data: data,
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_siswa').modal('hide');
                    swal({
                        title: "Sukses!",
                        text: response.caption,
                        timer: 1500,
                        showConfirmButton: false,
                        type: 'success'
                    });
                $('#datatable').DataTable().ajax.reload(null,false);
            } else {
                toastr.error(response.caption,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
         });
        return false;
    }

    function m_siswa_h(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/datapeserta/hapus_Data_Peserta/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#datatable').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
          allowOutsideClick: () => !swal.isLoading()
        });
    }

    function h_siswa_all(){
        swal({
          title: 'Apa kamu yakin ingin menghapus semua data?',
          text: 'Aksi ini akan menghapus semua data peserta',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/datapeserta/HaPus_D4ta_aLL",
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#datatable').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
          allowOutsideClick: () => !swal.isLoading()
        });
    }
    //end siswa region

    //begin soaltrial region
    function soaltrial_h(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/soaltrial/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#datatrial').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }

    function h_soaltrial_all(){
        swal({
          title: 'Apa kamu yakin ingin menghapus semua data?',
          text: 'Aksi ini akan menghapus semua data soal dan tak dapat dikembalikan seperti semula',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/soaltrial/hapus_all",
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#datatrial').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }
    //end soaltrial region

    //begin soal
    function soal_h(){
        swal({
          title: 'Apa kamu yakin ingin menghapus semua data?',
          text: 'Aksi ini akan menghapus semua data soal dan tak dapat dikembalikan seperti semula',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/hapusbanksoal",
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            }); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    } 

    function soalversi1_h(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/banksoalv1/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#dataversi1').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }

    function soalversi2_h(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/banksoalv2/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#dataversi2').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }

    function soalversi3_h(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/banksoalv3/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            }); 
                            $('#dataversi3').DataTable().ajax.reload(null,false);
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }
    //end soal

    //data kategori
    function m_kategori(id){
        $("#m_datakategori").modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"administrator/kategorisoal/editdatakategori/"+id,
            success: function(response) {
                if(response.data.id != 0){
                    $("#id").val(response.data.id);
                    $("#kategori").val(response.data.kategori);
                    $("#kategori").focus();
                }
                $("#header-modal-kategori").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function m_simpan_kategori(){
        var data = $("#edit_kategori").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/kategorisoal/simpan_data_kategori",
            data: data
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_datakategori').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.caption,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });
                $('#datakategori').DataTable().ajax.reload(null,false);
            } else {
                console.log('gagal');
            }
        });
        return false;
    }

    function hapus_kategori(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/kategorisoal/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#datakategori').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }
    //end data kategori
    
    //begin data operator
    function m_operator(id){
        $("#m_dataoperator").modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"administrator/dataoperator/editdataoperator/"+id,
            success: function(response) {
                if(response.id == "ok"){
                    $("#password").prop("required",true);
                    $("#password").removeAttr("placeholder");
                }
                else{
                    $("#password").removeAttr("required");
                    $("#password").attr("placeholder","field ini tidak harus diisi, ubahlah jika perlu..");
                }
                $("#id").val(response.id);
                $("#user_operator").val(response.username);
                $("#idruang").val(response.id_ruang);
                $("#peran").val(response.grup);
                $("#periode").val(response.periode);
                $("#username").focus();
                $("#password").val("");
                $("#label-password").html(response.label);
                $("#header-modal-operator").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function m_simpan_operator(){
        var form  = $("#edit_operator").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/dataoperator/simpan_data_operator",
            data: form
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_dataoperator').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.caption,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });
                $('#dataoperator').DataTable().ajax.reload(null,false); 
            } else {
                toastr.error(response.caption,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
        });
        return false;
    }

    function hapus_operator(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/dataoperator/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                            $('#dataoperator').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }
    //end data operator

    //begin data ruang
    function m_ruang(id){
        $("#m_dataruang").modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"administrator/dataruang/editdataruang/"+id,
            success: function(response) {
                if(response.status === "edit"){
                    $("#id").val(response.data.id_ruang);
                    $("#idruang").val(response.data.id_ruang);
                    $("#idruangmin").val(response.data.min);
                    $("#idruangmax").val(response.data.max);
                    $("#idruangmin").attr('min','1');
                    $("#idruangmin").attr('max','100');
                    $("#idruangmax").attr('min','1');
                    $("#idruangmax").attr('max','100');
                    $("#idruang").focus();
                }
                if(response.status === "tambah"){
                    $("#id").val(response.status);
                    $("#idruang").val("");
                    $("#idruangmin").val("");
                    $("#idruangmax").val("");
                    $("#idruangmin").attr('min','1');
                    $("#idruangmin").attr('max','100');
                    $("#idruangmax").attr('min','1');
                    $("#idruangmax").attr('max','100');
                }
                $("#header-modal-ruang").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function dataruang_s() 
    {
        var data = $("#edit_ruang").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/dataruang/simpan",
            data: data
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_dataruang').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.msg,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });
                $('#dataruang').DataTable().ajax.reload(null,false);
            }else {
                toastr.error(response.msg,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
        });
        return false;
    }

    function hapus_ruang(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/dataruang/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.msg,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });
                        $('#dataruang').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
        });
    }
    //end data ruang 

    //begin aktivasi soal 
    function m_editactive(id){
        $("#m_aktifsoal").modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"administrator/aktivasisoal/editdata/"+id,
            success: function(response) {
                    $("#id").val(response.id);
                    $("#nmujian").val(response.nama_ujian);
                    $("#kategori").val(response.idkategori);
                    $("#waktu").val(response.waktu);
                    $("#terlambat").val(response.terlambat);
                    $("#tgl").val(response.tanggal);
                    $("#time").val(response.jam);
                $("#header-modal-aktif").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function set_trial(id){
        $("#m_aktiftrial").modal('show');
        $.ajax({
            type: "GET",
            url: base_url+"administrator/aktivasisoal/getwaktu/"+id,
            success: function(response){
                $("#id_trial").val(response.id);
                $("#waktu_trial").val(response.waktu);
                $("#header-modal-trial").html("<h5 id='exampleModalLabel' class='modal-title'>"+response.judul+"</h5>");
            }
        });
        return false;
    }

    function m_simpan_trial(){
        var form = $("#e_aktiftrial").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/aktivasisoal/simpan_trial",
            data: form
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_aktiftrial').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.caption,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });                 
                $('#aktivasisoal').DataTable().ajax.reload(null,false);
            }else {
                toastr.error(response.caption,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
        });
        return false;
    }

    function m_simpan_active() 
    {
        var form = $("#e_aktifsoal").serialize();
        $.ajax({        
            type: "POST",
            url: base_url+"administrator/aktivasisoal/simpan",
            data: form
        }).done(function(response) {
            if (response.status == "ok") {
                $('#m_aktifsoal').modal('hide');
                swal({
                    title: "Sukses!",
                    text: response.caption,
                    timer: 1500,
                    showConfirmButton: false,
                    type: 'success'
                });                 
                $('#aktivasisoal').DataTable().ajax.reload(null,false);
            }else {
                toastr.error(response.caption,'Error',{
                    timeOut: 2000,
                    "positionClass": "toast-top-center",
                    "progressBar": true
                });
            }
        });
        return false;
    }

    function hapus_aktif(id){
        swal({
          title: 'Apa kamu yakin ingin menghapus data ini?',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/aktivasisoal/hapus/"+id,
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });                 
                            $('#aktivasisoal').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
          allowOutsideClick: () => !swal.isLoading()
        });
    }

    function h_soalaktivasi(){
        swal({
          title: 'Apa kamu yakin ingin menghapus semua data?',
          text: 'Aksi ini akan menghapus semua data nilai keseluruhan',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/rekapnilai/hapus_all",
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });                 
                            $('#rekapnilaiavg').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
          allowOutsideClick: () => !swal.isLoading()
        });
    }

    //end aktivasi soal
    function hapus_laporan(){
         swal({
          title: 'Apa kamu yakin ingin menghapus semua data?',
          text: 'Aksi ini akan menghapus semua data laporan keseluruhan',
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Tidak',
          confirmButtonText: 'Ya',
          showLoaderOnConfirm: true,
          preConfirm : function(){
            return new Promise(function(resolve) {
                $.ajax({
                    type: "GET",
                    url: base_url+"administrator/lihat_laporan/hapus_all",
                    success: function(response) {
                        if (response.status == "ok") {
                            swal({
                                title: "Sukses!",
                                text: response.caption,
                                timer: 1500,
                                showConfirmButton: false,
                                type: 'success'
                            });                 
                            $('#lihat_laporan').DataTable().ajax.reload(null,false); 
                        } else {
                            console.log('gagal');
                        }
                    }
                });
            });
          },
          allowOutsideClick: () => !swal.isLoading()
        });
    }

    function detail_nilai(id){
        $("#m_nilai").modal('show');
        $.ajax({
            type : "GET",
            url : base_url+"administrator/rekapnilai/look_nilai/"+id,
            success : function(response){
                $('#data-nilai').html(response.html);
                $('#nama').html(response.nama);
                $('#nopeserta').html(response.no_peserta);
            }
        });
    }

    function modal_laporan(id){
        $("#m_laporan").modal('show');
        $.ajax({
            type : "GET",
            url : base_url+"administrator/lihat_laporan/laporan_data/"+id,
            success : function(response){
                $('#isilaporan').html(response.data);
            }
        });
        return false;
    }

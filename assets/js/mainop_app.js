$(document).ready(function(){
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

    $('#see_ubah_pass')
        .mouseup(function(){
            $('#pass_baru').attr('type','password');
        })
        .mousedown(function(){
            $('#pass_baru').attr('type','text');
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

    $('.external').on('click', function (e) {
        e.preventDefault();
        window.open($(this).attr("href"));
    });

	var url = get_url(parseInt(uri_js));
    var url2 = get_url((parseInt(uri_js)+1));
    var url3 = get_url((parseInt(uri_js)+2));

    if(url == "dashboard"){
        updateData();
        setInterval(function(){updateData()},3000);
    }

    if(url == "daftar_peserta"){
    	Datatabel("datatable",base_url+"operatorv1/daftar_peserta/data_rekap_rata2",[]);
    	$(document).on('change','#periode',function(){
            var periode = $(this).val();
            $('#datatable').DataTable().destroy();
            if(periode != ''){
                Datatabel("datatable",base_url+"operatorv1/daftar_peserta/data_rekap_rata2",[],periode);
            }
            else{
                Datatabel("datatable",base_url+"operatorv1/daftar_peserta/data_rekap_rata2",[]);
            }
        });
    	$('.periode').select2({
        	width: '75%'
    	});
        $('#refresh').on('click',function(){
            $('#datatable').DataTable().ajax.reload(null,false);
        });
    }
});

    function get_pass(){
        $('#m_ubahpassword').modal('show');
        $.ajax({
            type : "GET",
            url : base_url+"operatorv1/rubah_password",
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
            url : base_url+"operatorv1/rubah_password/simpan",
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
    
    function updateData(){
        $.getJSON(base_url+"operatorv1/dashboard/progress",function(data){
            $('#banyak_soal').html(data.angka);
            $('#kategori-uji').html(data.kategori);
        });
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
            "ordering": false,
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

    function logout(){
        var modal_html = '<div id="m_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade"><div role="document" class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 id="exampleModalLabel" class="modal-title">Konfirmasi Logout</h5><button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button></div><div class="modal-body"><p>Keluar dari sistem ini ?</p></div><div class="modal-footer"><button type="button" data-dismiss="modal" class="btn btn-success"><i class="fa fa-close"></i>&nbsp;&nbsp;Tutup</button><a href="#" class="btn btn-danger" id="delete_link"><i class="fa fa-check-square-o"></i>&nbsp;&nbsp;Keluar</a ></div></div></div></div>';
        $("#modal-logout").html(modal_html);
        $("#m_logout").modal('show');
        $("#delete_link").attr('href',base_url+"operatorv1/logout");
    }
$(document).ready(function(){
	var url = get_url(parseInt(uri_js));
    var url2 = get_url((parseInt(uri_js)+1));
    var url3 = get_url((parseInt(uri_js)+2));
    
    if(url == 'persiapan_ujian'){
    	timer();
    }

    if(localStorage.getItem("gagal")){
        swal({
            title: "Error",
            text: localStorage.getItem("gagal"),
            timer: 3500,
            showConfirmButton: false,
            type: 'error'
        });
        localStorage.clear();
    }

    if(localStorage.getItem("sukses")){
        swal({
            title: "Info",
            text: localStorage.getItem("sukses"),
            timer: 4000,
            showConfirmButton: false,
            type: 'success'
        });
        localStorage.clear();
    }
});
	function timer(){
		var idtes = $("#id_tes").val(); 
		var tgl_mulai = $("#tgl_mulai").val();
		var waktu_selesai = new Date(tgl_mulai);
    
	    var tgl_terlambat = $("#tgl_terlambat").val();
		var waktu_terlambat = new Date(tgl_terlambat);

	    $("#tombol").show();
	    $("#tombol").countdown(
	        {
	        	until: waktu_selesai, 
	        	format: 'HMS', 
	        	compact: true, 
	        	alwaysExpire: true,
	        	onExpiry: function() {
	        		
	        		$("#tombol").removeClass('btn-info').addClass('btn-success');
	        		$("#tombol").attr('onclick','return konf_data('+idtes+')');
				    $("#tombol").html('<i class="material-icons" style="vertical-align:middle;">done</i>&nbsp;&nbsp;Mulai');

	     			
				    $("#tgl_terlambat").countdown(
				        {
				        	until: waktu_terlambat, 
				        	format: 'HMS', 
				        	compact: true, 
				        	alwaysExpire: true,
				        	onExpiry: function() {
				        		$("#tombol").removeClass('btn-success').addClass('btn-danger');
				        		$("#tombol").removeAttr('onclick');
				        		$("#tombol").html('Akses Sudah Ditutup');
				        	}
				        }
				    );
	        	}
	        }
	    );
	}

	function logout(){
		$('#m_logout').modal('show');
		$('#tbl-logout').attr('href',base_url+"peserta/logout");
	}

	function show_modal(){
		$('#m_token').modal('show');
	}

	function get_url(segmen) {
        var url1 = window.location.protocol;
        var url2 = window.location.host;
        var url3 = window.location.pathname;
        var pathArray = window.location.pathname.split('/');
        return pathArray[segmen];
    }

    function konf_data(id_tes){
        $.ajax({
            type : "GET",
            url : base_url+"peserta/konfirmasi_data/"+id_tes,   
			success:function(response){
	            if(response.status == "ok"){
	                window.location.assign(base_url+"peserta/soal_ujian/"+response.id); 
	            }
	            else{
	                toastr.error(response.msg,'Error',{
	                    timeOut: 2000,
	                    "positionClass": "toast-top-center",
	                    "progressBar": true
	                });
	            }
	        }
        });
        return false;
    }
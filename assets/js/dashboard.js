/*global $, document, LINECHARTEXMPLE*/
$(document).ready(function () {
//jalankan fungsinya
    var table = $('#dashboardtable').DataTable({
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
            "columnDefs": [{ "orderable": false, "targets": 0 }],
            processing: true,
            serverSide: true,
            "ajax":{
                "url" : base_url+"administrator/dashboard/data", // json datasource
                "type": "POST"  
            }
    });
    
    UpdateData();
    setInterval(function(){UpdateData()},3000);
});

    function UpdateData(){
        $.getJSON(base_url+"administrator/dashboard/progress",function(data){
            $('#data-login').html(data.logged_in);
            $('#data-pendaftar').html(data.semua);
            $('.progress').html(data.persentase);
            $('.new-visites').html(data.newvisit);
        });
    }



    // $.ajax({
    //     url: base_url+"administrator/dashboard/data_grafik",
    //     method: "GET",
    //     success: function(data) {
    //         if(data.pilih_prodi == "kosong"){
    //             $('#data-kosong').html('<div class="alert alert-info">Data masih ada kosong</div>');
    //         }
    //         else{

    //         $('#data-kosong').remove();
    //         var labelprodi = [];
    //          var labeljumlah = [];

    //         for(var i in data) {
    //             labelprodi.push(data[i].pilih_prodi);
    //             labeljumlah.push(data[i].jumlah);
    //         }
 
    //         var chartdata = {
    //             labels: labelprodi,
    //             datasets : [
    //                 {
    //                     label: 'Pendaftar',
    //                     backgroundColor: 'rgba(153, 194, 255, 0.8)',
    //                     data: labeljumlah
    //                 }
    //             ],
    //         };

    //         var BARCHARTEXMPLE = $('#barChartExample');

    //         var barGraph = new Chart(BARCHARTEXMPLE, {
    //             type: 'horizontalBar',
    //             data: chartdata,
    //             options : {
    //                 scales: {
    //                     yAxes: [{
    //                         ticks: {
    //                             beginAtZero: true
    //                         }
    //                     }]
    //                 }
    //             }
    //         }); 

    //         function updateData(){
    //             $.getJSON(base_url+"administrator/dashboard/data_grafik",function(data){
    //                 var labeljumlahupdate = [];
    //                 var labelprodiupdate = [];
    //                     for(var i in data) {
    //                         labeljumlahupdate.push(data[i].jumlah);
    //                         labelprodiupdate.push(data[i].pilih_prodi);
    //                     }
    //                    barGraph.data.datasets[0].data = labeljumlahupdate;
    //                    barGraph.data.labels = labelprodiupdate;
    //                    barGraph.update();
    //             }); 
    //         }

    //          setInterval(function(){updateData()},3000);
    //         } 
    //     },
    //     error: function(data) {
    //         console.log(data);
    //     },
    // });

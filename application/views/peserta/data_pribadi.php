<div class="section section-basic" style="margin-top: 30px;">
     <div class="container">
      <div class="row">
       <div class="col-md-12 text-right">
         <div class="title" id="datetime"></div>  
       </div>
       <div class="card card-nav-tabs">
         <div class="card-header card-header-info">
          <div class="nav-tabs-navigation">
           <div class="nav-tabs-wrapper">
             <ul class="nav nav-tabs" data-tabs="tabs">
              <li class="nav-item">
               <div class="nav-link soal">Data Peserta</div>
              </li>
             </ul>
           </div>
          </div>
         </div> 
         <div class="card-body ">
           <div class="tab-content">
            <div class="tab-pane active" id="hasilujian">
             <div class="container">
              <table class="table table-bordered">
                <tbody>
                 <tr><td width="35%" style="font-weight: bold;">Nama</td><td width="65%"><?php echo $peserta['nama']?></td>
                 </tr>
                 <tr><td style="font-weight: bold;">No. Peserta</td><td><?php echo $peserta['no_peserta']?></td>
                 </tr>
                 <tr><td style="font-weight: bold;">No. Kursi</td><td><?php echo $peserta['no_kursi']?></td>
                 </tr>
                 <tr><td style="font-weight: bold;">Kode Prodi</td><td><?php echo $peserta['kode_prodi']?></td>
                 </tr>
                 <tr><td style="font-weight: bold;">Prodi Pilihan</td><td><?php echo $peserta['pilih_prodi']?></td>
                 </tr>
                 <tr><td style="font-weight: bold;">Tanggal Lahir</td><td><?php echo tanggal_indo($peserta['tgl_lahir'])?></td>
                 </tr>
                </tbody>    
               </table>
              </div>                
            </div>
           </div>
         </div>
       </div>
      </div>
     </div>
    </div>
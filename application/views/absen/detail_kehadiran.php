<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Kehadiran</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail Kehadiran</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-lg-12 mb-4">
			<!-- Simple Tables -->
			<div class="card">
				
				<div class="card-header d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-primary">Kehadiran <span id="txtid"><?=juser($id);?></span></h6>
					<div class="input-group input-group-sm w-25">
						<select name="id_user" id="id_user" class="form-control custom-select" onchange="detail_kehadiran();" >
							<?php 
								if(!empty($user)){
									foreach($user as $row){
										$selected = '';
										if($row->id_user==$id){
											$selected = 'selected';
										}
									?>
									<option value="<?=$row->id_user;?>" onclick="getElementById('txtid').innerHTML='<?=$row->nama_lengkap;?>'" <?=$selected;?>><?=$row->nama_lengkap;?></option>';
									<?php }
								}
							?>
						</select>
						<div class="input-group-prepend">
							<button class="btn btn-info btn-sm" id="cetak_laporan"><i class="fa fa-file-pdf-o"></i> Print</button>
						</div>
						<input type="text" id="tanggal" value="<?=$periode;?>" class="form-control date-laporan" placeholder="mm/yyyy" onchange="detail_kehadiran();"/>
						<div class="input-group-append">
							<button class="btn btn-primary url_doc" data-url="pendapatan" type="button" data-toggle="tooltip" data-original-title="Dok Laporan pendapatan" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
					</div>
				</div>
				<div class="card-body table-responsive pt-0">
					<table class="table align-items-center table-flush">
						<thead class="thead-light">
							<tr>
								<th class="">HARI KE</th>
								<th class="text-left">TANGGAL</th>
								<th class="text-left">JAM MASUK</th>
								<th class="text-left">JAM PULANG</th>
								<th class="text-left">LAMA KERJA</th>
							</tr>
						</thead>
						<tbody id="load-kehadiran">
							<?php 
								if(!empty($detail)){
									$no =1;
									foreach($detail AS $val){
										$masuk = '00:00';
										if(!empty($val->masuk)){
											$masuk = times($val->masuk);
										}
										
										$pulang = '00:00';
										if(!empty($val->pulang)){
											$pulang = times($val->pulang);
										}
										$_masuk = new DateTime($val->masuk);
										$_pulang = new DateTime($val->pulang);
										$diff = $_pulang->diff( $_masuk );
										$lama_kerja_jam = ($diff->format( '%H' ))- 1;  //dikurangi istirahat
										$lama_kerja_menit = $diff->format( '%I' ); 
										$lama_kerja = $lama_kerja_jam . ":" . $lama_kerja_menit;
									?>
									<tr>
										<td><?=$no;?>.</td>
										<td><?=dtime($val->tgl);?></td>
										<td><?=$masuk;?></td>
										<td><?=$pulang;?></td>
										<td><?=$lama_kerja;?></td>
									</tr>
								<?php $no++; }}else{ echo '<tr><td colspan="4">Belum ada data</td></tr>';} ?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>	
</div>	
<script>
	$("#cetak_laporan").click(function(e) {
		e.preventDefault();
		$( "#target" ).submit();
	});
	
	var date2 = new Date();
	$('.date-laporan').datepicker({        
        format: 'mm/yyyy', 
		"endDate": date2,
        autoclose: true,     
        startView: "months", 
		minViewMode: "months", 
	});  
	
	function detail_kehadiran(){
		var id_user = $("#id_user").val();
		var tanggal = $("#tanggal").val();
		$("#startdate").val(tanggal);
		var urlnya = base_url+"absen/ajaxDetail/";
		$.ajax({
			type: 'POST',
			url: urlnya,
			data:{id_user:id_user,tanggal:tanggal},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(html){
				$('#load-kehadiran').html(html);
				$('body').loading('stop');
				
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	}
</script>
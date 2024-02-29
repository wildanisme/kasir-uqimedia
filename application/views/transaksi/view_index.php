<script src="<?= base_url('assets/'); ?>js/glightbox.min.js"></script>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Laporan Transaksi</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Laporan Transaksi</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="<?=base_url();?>transaksi/cetak_pdf" method="post" id="cetak-transaksi" target="_blank">
				<div class="card">
					<div class="card-header pb-0">
						<div class="input-group input-group-sm">
							<div class="input-group-prepend">
								<span class="input-group-text">PERIODE</span>
							</div>
							<select name="jenis" id="jenis" class="form-control form-control-sm custom-select" onchange="search_transaksi()">
								<option value="1">PERHARI</option>
								<option value="2">PERBULAN</option>
							</select>
							<div class="input-group-prepend">
								<span class="input-group-text">KASIR</span>
							</div>
							<select name="user_trx" id="user_trx" class="form-control form-control-sm custom-select w-7" onchange="search_transaksi()">
								
								<?php  
									if($level=='admin' OR $level=='owner'){
										echo '<option value="0">Semua</option>';
										foreach ($pilihan AS $values){
												echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
										}
										}else{
										foreach ($pilihan AS $values){
											if($this->session->idu==$values['id_user']){
												echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
											}
										}
									}
									
								?>
							</select>
							<div class="input-group-prepend hide-1">
								<span class="input-group-text">TANGGAL</span>
							</div>
							<input type="text" onchange="search_transaksi()" value="<?=$tanggal;?>" class="form-control form-control-sm hide-1" name="tanggal" id="tanggal">
							<div class="input-group-prepend hide-2">
								<span class="input-group-text">BULAN</span>
								</div>
							<input type="text" onchange="search_transaksi()"  class="form-control form-control-sm w-5 date-harian hide-2"  value="<?=$periode;?>" name="periode" id="periode" autocomplete="off">
							
							<div class="input-group-append">
								<button type="button" data-info="harian" class="btn btn-success btn-sm harian" data-id="0"><i class="fa fa-search"></i> Lihat</button>
								<button type="button" data-info="harian" class="btn btn-danger btn-sm cetak_pdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
								<button class="btn btn-primary url_doc" data-url="transaksi" type="button" data-toggle="tooltip" data-original-title="Dok Uang masuk" data-placement="left"><i class="fa fa-info-circle"></i></button>
							</div>
						</div>
					</div>
					
					<div class="card-body table-responsive">
						<div class="card-block">
							<div class="post-list pt-0" id="laporan_harian">
								<div class="table-responsive-sm">
									
								</div>
							</div>
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form><!-- /.form -->
		</div>
	</div>
</div>

<style>
	
	.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
	padding: 2px;
	
	}
	.card .table td, .card .table th {
	padding-right: 5px;
	padding-left: 5px;
	}
	.small {
	height: 30px;
	padding: 2px 10px;
	}
	button, input, select, textarea {
	font-family: inherit;
	font-size: inherit;
	line-height: inherit;
	}
</style>

<script>
	$(document).on('click','.cetak_pdf',function(e){
		e.preventDefault();
		$("#cetak-transaksi").submit();
	});
	
	$('.date-harian').datepicker({        
        format: 'M yyyy',
        autoclose: true,     
        startView: "months", 
		minViewMode: "months",
	});  
	
	$('#tanggal').datepicker({        
		format: 'dd/mm/yyyy',
		autoclose: true,     
		todayHighlight: true,   
		todayBtn: 'linked',
	}); 
	
	$(document).on('change', '#jenis', function() {
		var id = $(this).val();
		if(id == 2){
			$(".hide-1").hide();
			$(".hide-2").show();
			}else{
			$(".hide-1").show();
			$(".hide-2").hide();
		}
	});
	
	$(document).on('click', '.clear', function() {
		$("#jenis").val(1);
		$(".hide-1").show();
		$(".hide-2").hide();
	});
	
	
	window.onload = function(){
		$(".hide-2").hide();
		search_transaksi()
	};
	
	function search_transaksi(){
		$(".harian").click();
	}
	
	$(document).on('click','.harian',function(e){
		e.preventDefault();
		
		var jenis = $("#jenis").val();
		var tanggal = $("#tanggal").val();
		var periode = $("#periode").val();
		var user_trx = $("#user_trx").val();
		
		var url_data = base_url + 'transaksi/load_data';
		$.ajax({
			url: url_data,
			data: {jenis:jenis,tanggal:tanggal,periode:periode,user:user_trx},
			method: 'POST',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				let text = data;
				let result = text.replace(/^\s+|\s+$/gm,'')
				if(result=='Data belum ada'){
					$("#data_uang_masuk").html(data);
					$("#cetak_u_masuk").hide();
					}else{
					$("#laporan_harian").html(data);	
					// $("#cetak_u_masuk").show();
				}
				
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Inport data error',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	
</script>															
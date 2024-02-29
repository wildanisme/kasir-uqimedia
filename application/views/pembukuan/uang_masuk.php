 
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Uang Masuk</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Uang Masuk</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SETOR</span>
						</div>
						<select name="setor" id="setor" class="form-control form-control-sm custom-select w-7" onchange="search_Uangmasuk()">
							<?php if ($this->session->level == 'kasir'){ ?>
								<option value="N">BELUM</option>
								<option value="Y">SUDAH</option>
								<?php }else{ ?>
								<option value="N">BELUM</option>
								<option value="Y" selected>SUDAH</option>
							<?php } ?>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">JENIS</span>
						</div>
						<select name="jenis" id="jenis_bayar" class="form-control form-control-sm custom-select w-7" onchange="search_Uangmasuk()">
							<option value="0">Semua</option>
							<?php  
								foreach ($jenis_bayar->result_array() AS $row){									
									echo '<option value="'.$row['id'].'">'.$row['nama_bayar'].'</option>';
								}
							?>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">KASIR</span>
						</div>
						<select name="user" id="user" class="form-control form-control-sm custom-select w-7" onchange="search_Uangmasuk()">
							<option value="0">Semua</option>
							<?php  
								foreach ($pilihan AS $values){
									if($this->session->idu==$values['id_user'] AND $level!='admin'){
										echo '<option value="'.$values['id_user'].'" selected>'.$values['nama_lengkap'].'</option>';
										}else{
										echo '<option value="'.$values['id_user'].'">'.$values['nama_lengkap'].'</option>';
									}
								}
							?>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">TANGGAL</span>
						</div>
						<div id="date-omset">
							<div class="input-daterange input-group">
								<input type="text" onchange="search_Uangmasuk()" value="<?=$dari;?>" class="form-control form-control-sm" style="width:40px;" name="dari" id="dari">
								
								<input type="text" onchange="search_Uangmasuk()" value="<?=$sampai;?>" class="form-control form-control-sm" name="sampai" id="sampai">
							</div>
						</div>
						<div class="input-group-append">
							<button type="button" data-toggle="tooltip" class="btn btn-danger btn-sm clear" id="clear" data-original-title="Clear"><i class="fa fa-times fa-1x"></i> Clear</button>
							<button type="button" data-info="harian" class="btn btn-success btn-sm harian" data-id="0"><i class="fa fa-search"></i> Lihat</button>
							<button class="btn btn-primary url_doc" data-url="uang_masuk" type="button" data-toggle="tooltip" data-original-title="Dok Uang masuk" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
					</div>
				</div>
				
				<div class="card-body table-responsive">
					<div class="card-block">
						<div class="post-list pt-0" id="data_uang_masuk">
							<div class="table-responsive-sm">
								
							</div>
						</div>
					</div><!-- /.card-body -->
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</div>

<form id="form_cetak" action="<?=base_url();?>pembukuan/cetak_uang_masuk" method="post" target="_blank">
	<input type="hidden" name="dari" id="tgl_dari" value="<?=$dari;?>">
	<input type="hidden" name="sampai" id="tgl_sampai" value="<?=$sampai;?>">
	<input type="hidden" name="jenis_bayar" id="jenisbayar">
	<input type="hidden" name="setor" id="setor">
	<input type="hidden" name="id_user" id="id_user" value="0">
</form>

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
<!-- Modal Scrollable -->
<div class="modal fade" id="ModalVerifikasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" id="save-verifikasi" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Approve setoran</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type='hidden' name='id' id='id_setor'>
				<input type='hidden' name='type' id="type_edit" value="edit">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="total">Total Setoran</label>
							<input type="text" name="total" id="total_setor" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label for="total">Tanggal Approve</label>
							<input type="date" name="tanggal" id="tanggal_verivikasi" class="form-control" required>
						</div>
						
						<label>Approve </label>
						<div class="form-group d-flex flex-row">
							<select name="status" id="status" class="form-control custom-select" required>
								<option value="1" selected>Ya</option>
								<option value="0">Tidak</option>
							</select>
						</div>	
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_verifikasi">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Scrollable -->
<div class="modal fade" id="ModalSetor" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" id="save-setor" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Approve setoran</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type='hidden' name='id' id='id_setorkeu'>
				<input type='hidden' name='type' id="type_editkeu" value="edit">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="total">Total Setor</label>
							<input type="text" name="total" id="total_setorkeu" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label for="total">Tanggal Approve</label>
							<input type="date" name="tanggal" id="tanggal_verivikasikeu" class="form-control" required readonly>
						</div>
						<div class="form-group">
							<label for="total">Tanggal Setor</label>
							<input type="date" name="tanggal_setor" id="tanggal_setor" class="form-control" required>
						</div>
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_setor">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal Scrollable -->
<div class="modal fade" id="ModalOwner" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" id="save-owner" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Approve Setoran Keuangan</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type='hidden' name='id' id='id_setor_owner'>
				<input type='hidden' name='type' id="type_edit_owner" value="edit">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="total">Total Setoran</label>
							<input type="text" name="total" id="total_setor_owner" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label for="total">Tanggal Approve</label>
							<input type="date" name="tanggal" id="tanggal_verivikasi_owner" class="form-control" required>
						</div>
						
						<label>Approve </label>
						<div class="form-group d-flex flex-row">
							<select name="status" id="status" class="form-control custom-select" required>
								<option value="3" selected>Ya</option>
							</select>
						</div>	
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_owner">Simpan</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm-setor" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Setor</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menyetorkan uang, prosedur ini tidak dapat diubah.</p>
				<p>Cek dan print terlebih dahulu!</p>
				<p class="debug-url"></p>
				<input type="hidden" id="modalid_total_u">
				<input type="hidden" id="modalid_user">
				<input type="hidden" id="modalid_dari">
				<input type="hidden" id="modalid_sampai">
				<input type="hidden" id="modalid_invoice_setor">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger setorkan" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	$(document).on('click','.setor_btn',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		$('#ModalSetor').modal({backdrop: 'static', keyboard: false});
		
		$.ajax({
			url: base_url + 'pembukuan/setor',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$("#id_setorkeu").val(data.id);
				$("#total_setorkeu").val(data.total);
				$("#tanggal_verivikasikeu").val(data.tanggal);
				$("#type_editkeu").val('edit');
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	$(document).on('click','.verifikasi',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		$('#ModalVerifikasi').modal({backdrop: 'static', keyboard: false});
		
		$.ajax({
			url: base_url + 'pembukuan/verifikasi',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$("#id_setor").val(data.id);
				$("#total_setor").val(data.total);
				$("#tanggal_verivikasi").val(data.tanggal);
				$("#status").val(data.status);
				$("#type_edit").val('edit');
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	$(document).on('click','.approve_owner',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		$('#ModalOwner').modal({backdrop: 'static', keyboard: false});
		
		$.ajax({
			url: base_url + 'pembukuan/approve_owner',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$("#id_setor_owner").val(data.id);
				$("#total_setor_owner").val(data.total);
				$("#type_edit_owner").val('edit');
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	
	$(document).on('click','.save_owner',function(e){
		e.preventDefault();
		var id = $("#id_setor_owner").val();
		var type = $("#type_edit_owner").val();
		var total = $("#total_setor_owner").val();
		var tanggal = $("#tanggal_verivikasi_owner").val();
		
		$.ajax({
			url: base_url + 'pembukuan/save_owner',
			data: {id:id,type:type,total:total,tanggal:tanggal},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				// $('#save-verifikasi').loading({zIndex:1060});
			},
			success: function(data) {
				if(data.status==200){
					$('#ModalOwner').modal('hide');
					showNotif('bottom-right','Hapus data',data.msg,'success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#save-owner').loading('stop');
				$(".harian").click();
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('#save-owner').loading('stop');
			}
		});
	});
	$(document).on('click','.save_setor',function(e){
		e.preventDefault();
		var id = $("#id_setorkeu").val();
		var type = $("#type_editkeu").val();
		var total = $("#total_setorkeu").val();
		var tanggal = $("#tanggal_verivikasikeu").val();
		var tanggal_setor = $("#tanggal_setor").val();
		if(tanggal_setor==""){
			$("#tanggal_setor").focus();
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/setor_to_owner',
			data: {id:id,type:type,total:total,tanggal:tanggal,tanggal_setor:tanggal_setor},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				// $('#save-verifikasi').loading({zIndex:1060});
			},
			success: function(data) {
				if(data.status==200){
					$('#ModalSetor').modal('hide');
					showNotif('bottom-right','Hapus data',data.msg,'success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#save-setor').loading('stop');
				$(".harian").click();
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('#save-setor').loading('stop');
			}
		});
	});
	$(document).on('click','.save_verifikasi',function(e){
		e.preventDefault();
		var id = $("#id_setor").val();
		var type = $("#type_edit").val();
		var total = $("#total_setor").val();
		var tanggal = $("#tanggal_verivikasi").val();
		var status = $("#status").val();
		if(tanggal==""){
			$("#tanggal_verivikasi").focus();
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/save_verifikasi',
			data: {id:id,type:type,total:total,tanggal:tanggal,status:status},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				// $('#save-verifikasi').loading({zIndex:1060});
			},
			success: function(data) {
				if(data.status==200){
					$('#ModalVerifikasi').modal('hide');
					showNotif('bottom-right','Hapus data',data.msg,'success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#save-verifikasi').loading('stop');
				$(".harian").click();
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('#save-verifikasi').loading('stop');
			}
		});
	});
	
	var date2 = new Date();
	$('#date-omset .input-daterange').datepicker({        
		format: 'dd/mm/yyyy',        
		"endDate": date2,
		autoclose: true,     
		todayHighlight: true,   
		todayBtn: 'linked',
	}); 
	$(document).on('click', '.clear', function() {
		$("#jenis_bayar").val(0);
		$("#user").val(0);
		$(".harian").click();
	});
	
	
	window.onload = function(){search_Uangmasuk()};
	function search_Uangmasuk(){
		$(".harian").click();
	}
	$(document).on('click','.harian',function(e){
		e.preventDefault();
		$("#data_uang_masuk").html("");
		var info = $(this).attr('data-info');
		var setor = $("#setor").val();
		var jenis_bayar = $("#jenis_bayar").val();
		var user = $("#user").val();
		var dari = $("#dari").val();
		var sampai = $("#sampai").val();
		if(dari=="" || sampai==""){
			sweet('Peringatan!!!','Tanggal harus diisi','warning','warning');
			return;
		}
		$("#tgl_dari").val(dari);
		$("#tgl_sampai").val(sampai);
		$("#id_user").val(user);
		$("#jenisbayar").val(jenis_bayar);
		$("#setor").val(setor);
		
		var url_data = base_url + 'pembukuan/data_uang_masuk';
		$.ajax({
			url: url_data,
			data: {setor:setor,user:user,jenis_bayar:jenis_bayar,dari:dari,sampai:sampai,info:info},
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
					$("#data_uang_masuk").html(data);	
					$("#cetak_u_masuk").show();
				}
				var total_u = $("#total_u").val();
				if(total_u ==0){
					$("#cetak_u_masuk").hide();
				}
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Inport data error',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	$(document).on('click','#cetak_u_masuk',function(e){
		e.preventDefault();
		
		var total_u = $("#total_u").val();
		// console.log(total_u);return
		if(total_u==0){
			sweet('Peringatan!!!','Maaf total masih kosong','warning','warning');
			}else{
			$("#form_cetak").submit();
		}
	});
	
	$(document).on('click','.setor',function(e){
		var jml = $("#total_u").val();
		var user = $("#user").val();
		var dari = $("#dari").val();
		var sampai = $("#sampai").val();
		var invoice_setor = $("#invoice_setor").val();
		
		$("#modalid_total_u").val(jml);
		$("#modalid_user").val(user);
		$("#modalid_dari").val(dari);
		$("#modalid_sampai").val(sampai);
		$("#modalid_invoice_setor").val(invoice_setor);
		
		$("#confirm-setor").modal('show');
	});
	
	$(document).on('click','.setorkan',function(e){
		e.preventDefault();
		
		var jml    = $("#modalid_total_u").val();
		var user   = $("#modalid_user").val();
		var dari   = $("#modalid_dari").val();
		var sampai = $("#modalid_sampai").val();
		var invoice = $("#modalid_invoice_setor").val();
		
		if(jml==0){
			sweet('Peringatan!!!','Maaf belum ada data','warning','warning');
			return;
		}
		if(user==0){
			sweet('Peringatan!!!','Maaf pilih dulu kasirnya','warning','warning');
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/setor_uang_masuk',
			data: {user:user,total:jml,invoice:invoice,dari:dari,sampai:sampai},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$('body').loading('stop');
				if(data.status==200){
					search_Uangmasuk();
					sweet('Sukses!!!','Uang berhasil disetor','success','success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$("#confirm-setor").modal('hide');
				$("#modalid_total_u").val('');
				$("#modalid_user").val('');
				$("#modalid_dari").val('');
				$("#modalid_sampai").val('');
				$("#modalid_invoice_setor").val('');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Inport data error',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	$(document).on('click','.setor_keu',function(e){
		e.preventDefault();
		var info = $(this).attr('data-info');
		var jml = $("#total_u").val();
		var user = $("#user").val();
		var dari = $("#dari").val();
		var sampai = $("#sampai").val();
		if(jml==0){
			sweet('Peringatan!!!','Maaf belum ada data','warning','warning');
			return;
		}
		if(user==0){
			sweet('Peringatan!!!','Maaf pilih dulu kasirnya','warning','warning');
			return;
		}
		$.ajax({
			url: base_url + 'pembukuan/setor_to_owner',
			data: {user:user,total:jml,info:info,dari:dari,sampai:sampai},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$('body').loading('stop');
				if(data.status==200){
					search_Uangmasuk();
					sweet('Sukses!!!','Uang berhasil disetor','success','success');
					}else{
					sweet('Peringatan!!!','Maaf rekapan harus per kasir','warning','warning');
				}
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Inport data error',error,'error');
				$('body').loading('stop');
			}
		});
	});
</script>															
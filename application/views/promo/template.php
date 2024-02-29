<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Template promo</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Template promo</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">List Data</h6>
						<button type="button" name="tambah" class="btn btn-success edit_data" data-id="0">Tambah</button>
					</div>
					
					<div class="card-body table-responsive">
						<div class="card-block data-template">
							
						</div><!-- /.card-body -->
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="ModalTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document" id="loading-status">
		<div class="modal-content flat">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Form Add</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="form-template" method="post">
					<input type='hidden' name='id' id='id_template' value='0'>
					<input type='hidden' name='type' id="type_template">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group-row">
								<label for="title">Title</label>
								<input type="text" name="title" id="title_template" class="form-control form-control-sm" required>
							</div>
							
							<div class="form-group-row">
								<label for="inisial">Deskripsi</label>
								<textarea class="form-control form-control-sm fcs" rows="5" id="deskripsi_template" name="deskripsi" required></textarea>
							</div>
							<div class="form-group row mt-2">
								<div class="col-md-6">
									<label for="jenis_pesan">Jenis Pesan</label>
									<select name="jenis_pesan" id="jenis_pesan" class="form-control form-control-sm custom-select" required>
										<option value="0" selected>Pesan Text</option>
										<option value="1">Pesan Text & Image</option>
									</select>
								</div>
								<div class="col-md-6">
									<label for="publish">Aktif</label>
									<select name="publish" id="publish" class="form-control form-control-sm custom-select" required>
										<option value="Y" selected>Ya</option>
										<option value="N">Tidak</option>
									</select>
								</div>
							</div>
							
							<div class="form-group form-media image_promo">
								<label>Media upload</label>
								<div class="input-group input-group-sm">
									<input type="text" id="input_media" name="media" class="form-control form-control-sm">
									<span class="btn btn-info btn-sm btn-file"> 
										<span class="text-white"><a href="javascript:void(0)" class="text-white" onclick="mediamodal()">Select file</a></span> 
									</span> 
								</div>
								<span class="help-block text-muted"><small>Pilih media yang akan dikirim.</small></span>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a href="javascript:void(0);"  data-toggle="modal" data-target="#template-shortcut"  class="btn btn-info btn-sm mr-auto flat" data-url="transaksi" data-toggle="tooltip" data-original-title="Shortcut" data-placement="top">
					<span class="icon text-white-50">
						<i class="fa fa-info-circle fa-fw fa-lg"></i>
					</span>	
				</a>
				<button type="button" name="submit" class="btn btn-info save_data">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="template-shortcut" tabindex="-1"
aria-labelledby="modal-shortcut" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content flat">
			<div class="modal-header">
				<h5 class="modal-title">SHORT TAG</h5>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
			<div class="modal-body">
				<ul class="pl-3">
					<li><small>{web}        : ALAMAT WEBSITE</small></li>
					<li><small>{selamat}    : SELAMAT PAGI | SIANG | SORE | MALAM</small></li>
					<li><small>{perusahaan} : NAMA PERUSAHAAN</small></li>
					<li><small>{hp}         : NO HP KANTOR</small></li>
					<li><small>{email}      : EMAIL KANTOR</small></li>
					<li><small>{alamat}     : ALAMAT KANTOR</small></li>
					<li><small>{panggilan}  : NAMA PANGGILAN Bpk/Ibu/Mas/Mba</small></li>
					<li><small>{nama}       : NAMA PELANGGAN</small></li>
				</ul>
			</div>
			
		</div>
	</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm-delete" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus satu url, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
				<input type="hidden" id="data-hapusid">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	
	
	
	$(document).ready(function() {
		data_template();
		$('.image_promo').hide();
	});
	function data_template(){
		$.ajax({
			url: base_url + "promo/data_template",
			dataType: 'html',
			beforeSend: function(){
				$("body").loading({zIndex:1060});
			},
			success: function(data) {
				$(".data-template").html(data);
				$('body').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('body').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
	}
	
	$(document).on('click','.edit_data',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		// alert(id);
		if(id==0){
            $("#type_template").val('add');
			}else{
            $("#type_template").val('edit');
			$("#exampleModalScrollableTitle").html('Form Edit');
		}
		$.ajax({
			url: base_url + 'promo/get_template',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$("body").loading({zIndex:1060});
			},
			success: function(data) {
				if(data.status==true){
					$('#ModalTemplate').modal({backdrop: 'static', keyboard: false});
					$("#id_template").val(data.id);
					$("#title_template").val(data.title);
					$("#publish").val(data.publish);
					$("#jenis_pesan").val(data.jenis_pesan);
					$("#deskripsi_template").val(decodeURI(data.deskripsi));
					$("input,textarea,select").attr('readonly',data.readonly);
					$(".save_data").attr('disabled', data.disabled);
					$("#exampleModalScrollableTitle").html(data.modal_title);
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('body').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('body').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
	});
	
	$(document).on('click','.save_data',function(e){
		e.preventDefault();
		
		var dataform = $("#form-template").serialize();
		
		$.ajax({
			url: base_url + 'promo/save_template',
			data: dataform,
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$("body").loading({zIndex:1060});
			},
			success: function(data) {
				console.log(data)
				if(data.status==200){
					data_template();
					sweet('Sukses!!!',data.msg,'success','success');
					$('#ModalTemplate').modal('hide');
					}else if(data.status==false){
					sweet('Peringatan!!!',data.msg,'warning','warning');
					}else{
					cfNotif(data['alert']);
				}
				$('body').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('body').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
	});
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapusid').val($(e.relatedTarget).data('id'));
	});
	
	$(document).on('click','.hapus',function(e){
		e.preventDefault();
		var id = $("#data-hapusid").val();
		$.ajax({
			url: base_url + 'promo/save_template',
			method: 'POST',
			dataType:'json',
			data:{id:id,type:"hapus"},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				if(data.status==200){
					$('#confirm-delete').modal('hide');
					sweet_time(500,'Status!!!',data.msg);
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				data_template();
				$('body').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('body').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
	});
	
	$("#jenis_pesan").change(function() {
		var id = $(this).val();
		if(id==0){
			return;
		}
		$.ajax({
			url: base_url + 'promo/cek_paket',
			method: 'POST',
			dataType:'json',
			data:{id:id},
			beforeSend: function(){
				$('#loading-status').loading({zIndex:1060});
			},
			success: function(data) {
				
				if(data.package=='Super' || data.package=='Advanced' || data.package=='Ultra'){
					$('.image_promo').show();
					$("#jenis_pesan").val(id);
					}else{
					$("#jenis_pesan").val(0);
					$('.image_promo').hide();
					sweet('Peringatan!!!','Hanya berlaku untuk Paket Super, Advanced & Ultra','warning','warning');
				}
				
				$('#loading-status').loading('stop');
			},
			error : function(res, status, httpMessage) {
				$('#loading-status').loading('stop');
				console.log(res.status)
				if(res.status==401){
					sweet_login(httpMessage,'warning',base_url);
					}else{
					sweet("Peringatan!!!", httpMessage, "warning", "warning");
				}			
			}
		});
		
	});
</script>
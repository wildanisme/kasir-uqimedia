<style>.card .table td, .card .table th {padding-right: 1rem;padding-left: 1rem;}</style>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Pengaturan printer</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Pengaturan printer</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">List Data Printer</h6>
					</div>
					
					<?php echo $this->session->flashdata('message'); ?>
					<div class="card-body table-responsive">
						<div class="card-block dataPrinter">
							
						</div><!-- /.card-body -->
						<code>Catatan : A5 Landscape Max item 12/page | A4 Potrait Max item 33/page invoice</code>
					</div><!-- /.card-body -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="ModalPrinter" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content flat">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Pengaturan printer</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<input type='hidden' name='print_id' id='print_id' value='0'>
				<input type='hidden' name='type' id="type">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-1">
							<label for="jenis">Jenis printer</label>
							<input type="text" name="jenis" id="jenis" class="form-control form-control-sm rounded-0" required>
						</div>
						<div class="form-group mb-1">
							<label for="shared">Shared name</label>
							<input type="text" name="shared" id="shared" class="form-control form-control-sm rounded-0" required>
						</div>
						<div class="row mb-1">
							<div class="form-group col-md-6 mb-1">
								<label>Ukuran Kertas </label>
								<select name="ukuran" id="ukuran" class="form-control  form-control-sm custom-select rounded-0" required>
									<option value="">Pilih</option>
									<option value="A5">A5</option>
									<option value="A4">A4</option>
									<option value="58">58 mm</option>
									<option value="85">85 mm</option>
									<option value="14">14 cm</option>
									<option value="24">24 cm</option>
								</select>
							</div>	
							<div class="form-group col-md-6 mb-1">
								<label for="font_size">Ukuran Font</label>
								<input type="number" name="font_size" id="font_size" class="form-control form-control-sm rounded-0" min="7" required>
							</div>
						</div>
						<div class="form-group mb-1">
							<label>Posisi Kertas </label>
							<select name="posisi" id="posisi" class="form-control  form-control-sm custom-select rounded-0" required>
								<option value="">Pilih</option>
								<option value="potrait">Potrait</option>
								<option value="landscape">Landscape</option>
							</select>
						</div>	
						<div class="form-group mb-1">
							<label for="item">Max Item</label>
							<input type="number" name="item" id="item" class="form-control form-control-sm rounded-0" required>
						</div>
						<div class="row mb-1">
							<div class="form-group col-md-6 mb-1">
								<label>Aktif </label>
								<div class="form-group mb-1">
									<select name="aktif" id="aktif" class="form-control  form-control-sm custom-select rounded-0" required>
										<option value="">Pilih</option>
										<option value="1">Ya</option>
										<option value="0">Tidak</option>
									</select>
								</div>	
							</div>	
							<div class="form-group col-md-6 mb-1">
								<label>Show Footer</label>
								<div class="form-group mb-1">
									<select name="show_footer" id="show_footer" class="form-control  form-control-sm custom-select rounded-0" required>
										<option value="0">Ya</option>
										<option value="1">Tidak</option>
									</select>
								</div>	
							</div>	
						</div>	
					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_printer rounded-0">Simpan</button>
				<button type="button" class="btn btn-danger rounded-0" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function() {
	printer();
});
function printer(){
	$.ajax({
		url: base_url + "main/data_printer",
		dataType: 'html',
		beforeSend: function(){
			$("body").loading({zIndex:1060});
		},
		success: function(data) {
			$(".dataPrinter").html(data);
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


$("#jenis").keyup(function(){
	$("#jenis").removeClass("is-invalid").addClass("is-valid");
});
$("#shared").keyup(function(){
	$("#shared").removeClass("is-invalid").addClass("is-valid");
});
$("#aktif").change(function(){
	$("#aktif").removeClass("is-invalid").addClass("is-valid");
});

$("#ukuran").change(function(){
	var str = $(this).val();
	if(str=='A5'){
		$('#item').val(12);
	}
	if(str=='A4'){
		$('#item').val(24);
	}
	if(str=='58'){
		$('#item').val(100);
	}
	if(str=='85'){
		$('#item').val(100);
	}
});

$(document).on('click','.edit_printer',function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');
	// alert(id);
	if(id==0){
		$("#type").val('add');
		}else{
		$("#type").val('edit');
	}
	$('#ModalPrinter').modal({backdrop: 'static', keyboard: false});
	$.ajax({
		url: base_url + 'main/edit_printer',
		data: {id:id},
		method: 'POST',
		dataType:'json',
		beforeSend: function(){
			$("body").loading({zIndex:1060});
		},
		success: function(data) {
			$("#print_id").val(data.id);
			$("#jenis").val(data.jenis);
			$("#shared").val(data.shared);
			$("#ukuran").val(data.ukuran);
			$("#font_size").val(data.font_size);
			$("#posisi").val(data.posisi);
			$("#item").val(data.item);
			$("#aktif").val(data.aktif);
			$("#show_footer").val(data.show_footer);
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

$(document).on('click','.save_printer',function(e){
	e.preventDefault();
	var id = $("#print_id").val();
	var type = $("#type").val();
	var judul = $("#jenis").val();
	var shared = $("#shared").val();
	var ukuran = $("#ukuran").val();
	var font_size = $("#font_size").val();
	var posisi = $("#posisi").val();
	var item = $("#item").val();
	var aktif = $("#aktif").val();
	var show_footer = $("#show_footer").val();
	if(judul==''){
		$("#jenis").addClass('is-invalid');
		$("#jenis").focus();
		// sweet('Peringatan!!!','Nama bahan masih kosong','warning','warning');
		return;
	}
	if(shared==''){
		$("#shared").addClass('is-invalid');
		$("#shared").focus();
		// sweet('Peringatan!!!','Harga bahan masih kosong','warning','warning');
		return;
	}
	if(aktif==''){
		$("#aktif").addClass('is-invalid');
		$("#aktif").focus();
		// sweet('Peringatan!!!','Status masih kosong','warning','warning');
		return;
	}
	$.ajax({
		url: base_url + 'main/save_printer',
		data: {id:id,type:type,judul:judul,shared:shared,ukuran:ukuran,font_size:font_size,posisi:posisi,item:item,aktif:aktif,show_footer:show_footer},
		method: 'POST',
		dataType:'json',
		beforeSend: function(){
			$("body").loading({zIndex:1060});
		},
		success: function(data) {
			if(data.status==200){
				printer();
				sweet('Sukses!!!',data.msg,'success','success');
				$('#ModalPrinter').modal('hide');
				}else{
				sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
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
$(document).on('click','.change_status',function(e){
	e.preventDefault();
	var id = $(this).attr('data-id');
	var tipe = $(this).attr('data-tipe');
	var aktif = $(this).attr('data-pub');
	$.ajax({
		url: base_url + 'main/save_printer',
		data: {id:id,type:tipe,aktif:aktif},
		method: 'POST',
		dataType:'json',
		beforeSend: function(){
			$("body").loading({zIndex:1060});
		},
		success: function(data) {
			if(data.status==200){
				printer();
				sweet('Sukses!!!',data.msg,'success','success');
				}else{
				sweet('Peringatan!!!','Data gagal disimpan','warning','warning');
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
</script>
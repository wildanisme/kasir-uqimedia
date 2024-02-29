<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">List Pekerjaan</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">list pekerjaan</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header pb-2">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control form-control-sm custom-select w-30px" onchange="search_Operator()">
							<option value="ASC">ASC</option>
							<option value="DESC" selected>DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control form-control-sm custom-select w-30px" onchange="search_Operator()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">STATUS</span>
						</div>
						<select id="status" name="status" class="form-control form-control-sm custom-select w-30px" onchange="search_Operator()">
							<option value="semua">SEMUA</option>
							<option value="0">BARU</option>
							<option value="1">DESAIN</option>
							<option value="2">PROSES</option>
							<option value="3">SELESAI</option>
							<option value="4">DIAMBIL</option>
							<option value="5">DIKIRIM</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">OPERATOR</span>
						</div>
						<select name="user" id="user" class="form-control form-control-sm custom-select w-30px" onchange="search_Operator()">
							<option value="0">SEMUA</option>
							<?php  
								foreach ($pilihan AS $values){
									echo '<option value="'.$values['id_user'].'">'.strtoupper($values['nama_lengkap']).'</option>';
								}
							?>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">TANGGAL</span>
						</div>
						<div id="date-omset">
							<div class="input-daterange input-group">
								<input type="text" onchange="search_Operator()"  class="form-control form-control-sm w-100px" name="dari" id="dari" value="<?=$dari;?>">
								<input type="text" onchange="search_Operator()"  class="form-control form-control-sm w-100px" name="sampai" id="sampai" value="<?=$sampai;?>">
							</div>
						</div>
						<div class="input-group-append">
							<button type="button" data-toggle="tooltip" class="btn btn-danger btn-sm clear" id="clearCari" data-original-title="Clear" onclick="clearSearch('<?=$dari;?>')"><i class="fa fa-times fa-1x"></i> Clear</button>
							<button type="button" data-info="harian" class="btn btn-success btn-sm" data-id="0" onclick="search_Operator()"><i class="fa fa-search"></i> Lihat</button>
							<button type="button"  class="btn btn-info btn-sm print_rincian flat" id="print_pekerjaan" data-toggle="tooltip" data-original-title="Print PDF"><i class="fa fa-file-pdf-o fa-1x"></i> Print</button>
							<button class="btn btn-primary url_doc" data-url="lap_rincian" type="button" data-toggle="tooltip" data-original-title="Dok Operator" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
					</div>
				</div>
				
				<div class="card-body table-responsive">
					<div class="card-block">
						<!--div id="data_omset"></div-->
						<div class="post-list pt-0" id="dataListOmset">
						</div>
					</div><!-- /.card-body -->
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</div>
<div class="modal fade" id="OpenModalOperator" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content flat">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabelPengguna">Update Status</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body pb-0 mt-0 pt-1">
				<div class="input-group mb-3 flat">
					<div class="input-group-prepend flat">
						<span class="input-group-text flat" id="basic-addon1">No. Order</span>
					</div>
					<input type="text" id="noorder" name="noorder" class="form-control flat" readonly>
					<input type="hidden" id="no_order" name="no_order" class="form-control" readonly>
				</div>
				<div class="form-group">
					<select name="status_baru" class="form-control custom-select flat" id="status_baru">
						<option value="0">Pilih status</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button"  id="btn-baru" class="btn btn-success flat simpan_baru">Simpan</button>
				<button type="button" class="btn btn-danger flat" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal left fade" id="OpenModalWa" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content flat">
			<div class="modal-header">
				<h4 class="modal-title" id="WaLabel">Kirim Invoice</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<div class="load-data-wa"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success kirim_pesan" type="button"><i class="fa fa-send"></i>Kirim</button> 
				<button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button> 
			</div>
		</div>
	</div>
</div>
<div class="modal fade modal-fullscreen-xl" id="surat_jalan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="simpan_surat" action="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Buat Surat Jalan</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="load-modal"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success simpan_surat">Simpan & Cetak Surat</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade modal-fullscreen-xl" id="buat_spk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" id="simpan_spk" action="">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">BUAT SPK</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="load-modal-spk"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success simpan_spk">Simpan & Cetak SPK</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
				</div>
			</form>
		</div>
	</div>
</div>
<form method="POST" action="<?=base_url();?>laporan/cetak_laporan_operator" id="target_print" target="_blank">
	<input type="hidden" name="startdate" id="startdate" readonly  />
	<input type="hidden" name="enddate" id="enddate" readonly />
	<input type="hidden" name="status" id="status_print" readonly />
	<input type="hidden" name="operator" id="idoperator" readonly />
</form>
<style>
	.custom-select {
    display: inline-block;
    width: 100%;
	height: 40px;
	padding: 5px 1.75rem 5px .75rem;
	
	}
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
	$(document).on('click','.buat_surat',function(e){
		e.preventDefault();
		var dataID = $(this).attr('data-id');
		var user = $("#user").val();
		// alert(info);
		$.ajax({
			'url': base_url + 'laporan/load_modal',
			'method': 'POST',
			data :{id:dataID,user:user},
			success: function(data) {
				if(data=='error'){
					sweet('Peringatan!!!','Maaf Data telah direkap & tidak bisa di edit','warning','warning');
					}else{
					$("#surat_jalan").modal('show');
					$(".load-modal").html(data);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
			}
		})
	});
	
	$(document).on('click','.simpan_surat',function(e){
		e.preventDefault();
		
		if($('#tgl_kirim').val()=='')
		{
			showNotif('bottom-right','Form input','Tanggal Harus diisi','warning');
			$('#tgl_kirim').focus();
			return;
		}
		if($('#pengirim').val()=='')
		{
			showNotif('bottom-right','Form input','Pengirim Harus dipilih','warning');
			$('#pengirim').focus();
			return;
		}
		if($('#nopol').val()=='')
		{
			showNotif('bottom-right','Form input','No. Polisi Harus diisi','warning');
			$('#nopol').focus();
			return;
		}
		
		if($('#alamat').val()=='')
		{
			showNotif('bottom-right','Form input','Alamat Harus diisi','warning');
			$('#alamat').focus();
			return;
		}
		
		var formData = $("#simpan_surat").serialize();
		$.ajax({
			type: "POST",
			url: base_url+"laporan/simpan_surat",
			dataType: 'json',
			data: formData,
			beforeSend: function () {
				$('body').loading();
			},
			success: handle_sukses
			,error: function(xhr, status, error) {
				showNotif('bottom-right','Peringatan',xhr.responseText,'error');
				$('body').loading('stop');
			}
		});
	});
	
	function handle_sukses(data)
	{
		
		$('body').loading('stop');
		if(data.status==200){
			var url_pdf = base_url + 'laporan/cetak_surat/'+data.id;
			// console.log(url_pdf)
			window.open(url_pdf, '_blank');
			showNotif('bottom-right','Buat surat jalan',data.msg,'success');
			$("#surat_jalan").modal('hide');
			}else{
			showNotif('bottom-right','Buat surat jalan',data.msg,'error');
		}
		
	}
	
	$(document).on('click','.buat_spk',function(e){
		e.preventDefault();
		var dataID = $(this).attr('data-id');
		
		$.ajax({
			'url': base_url + 'laporan/load_modal_spk',
			'method': 'POST',
			data :{id:dataID},
			success: function(data) {
				$("#buat_spk").modal('show');
				if(data=='error'){
					sweet('Peringatan!!!','Maaf Data telah direkap & tidak bisa di edit','warning','warning');
					}else{
					$(".load-modal-spk").html(data);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
			}
		})
	});
	
 
	$(document).on('click','.simpan_spk',function(e){
		e.preventDefault();
		
		var formData = $("#simpan_spk").serialize();
		$.ajax({
			type: "POST",
			url: base_url+"laporan/simpan_spk",
			dataType: 'json',
			data: formData,
			beforeSend: function () {
				$('body').loading();
			},
			success: handle_spk
			,error: function(xhr, status, error) {
				showNotif('bottom-right','Peringatan',xhr.responseText,'error');
				$('body').loading('stop');
			}
		});
	});
	
	function handle_spk(data)
	{
		
		$('body').loading('stop');
		if(data.status==200){
			var url_pdf = base_url + 'operator/print_spk/'+data.id;
			// console.log(url_pdf)
			window.open(url_pdf, '_blank');
			showNotif('bottom-right','Buat surat jalan',data.msg,'success');
			$("#buat_spk").modal('hide');
			search_Operator();
			}else{
			showNotif('bottom-right','Buat surat jalan',data.msg,'error');
		}
		
	}
	 
	$(".kirim_wa").click(function(e) {
		e.preventDefault();
		var id = $(this).attr('data-id');
		var nomor = $(this).attr('data-nomor');
		var trx = $(this).attr('data-trx');
		var tgl = $(this).attr('data-tgl');
		// console.log(id);
		$('#WaLabel').html('Kirim '+trx);  
		$('#OpenModalWa').modal({backdrop: 'static', keyboard: false})  
		$.ajax({
			url: base_url + 'whatsapp/get_form_wa',
			data: {id:id,nomor:nomor,tgl:tgl},
			method: 'POST',
			dataType:'html',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				$(".load-data-wa").html(data);
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
	});
	
	$(".kirim_pesan").click(function(e) {
		var dataform = $("#form-wa").serialize();
		$.ajax({
            type: "POST",
            url: base_url+"whatsapp/kirim_pesan",
            dataType: 'json',
            data: dataform,
			cache: false,
            beforeSend: function () {
                $('body').loading();
			},
            success: handleKirim
			,error: function(xhr, status, error) {
                showNotif('top-right','Simpan data',error,'error');
                $('body').loading('stop');
			}
		});
		
	});
	function handleKirim(data) {
		
		$('#OpenModalWa').modal('hide'); 
		if(data.status==true){
			showNotif('bottom-right','Simpan data',data.msg.detail,'success');
			}else{
			var number = data.target; 
			var message = encodeURIComponent(data.msg);
			var url_wa = getLinkWhastapp(number,message)
			window.open(url_wa, '_blank');
		}
	}
	
	function getLinkWhastapp(number, message) {
		var url = 'https://wa.me/' 
		+ number 
		+ '?text='
		+ message
		return url
	}
	function open_popup(id)
	{
		
		var w = 880;
		var h = 570;
		var l = Math.floor((screen.width-w)/2);
		var t = Math.floor((screen.height-h)/2);
		if(thermal===1){
			$.post(base_url+"operator/print_invoice_html/"+id,{id: id},
			function(data, status){
				if(status=='success'){
					// alert("Data: " + data + "\nStatus: " + status);
				}
			});
			}else{
			var url_cetak = base_url +'operator/print_spk_html/'+id;
			window.open(url_cetak, 'Cetak Invoice', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
		}
	}
	
	var date2 = new Date();
	$('#date-omset .input-daterange').datepicker({        
        format: 'dd/mm/yyyy',        
		"endDate": date2,
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
	}); 
	
	search_Operator();
	function search_Operator(page_num){
		page_num = page_num?page_num:0;
		var user = $('#user').val();
		var dari = $('#dari').val();
		var sampai = $('#sampai').val();
		var sortBy = $('#sortBy').val();
		var limits = $('#limits').val();
		var status = $('#status').val();
		$('#startdate').val(dari);
		$('#enddate').val(sampai);
		$('#status_print').val(status);
		$('#idoperator').val(user);
		var urlnya = base_url+"laporan/ajaxspk/"+page_num
		$.ajax({
			type: 'POST',
			url: urlnya,
			data:{page:page_num,user:user,dari:dari,sampai:sampai,sortBy:sortBy,limits:limits,status:status},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(html){
				$('#dataListOmset').html(html);
				$('body').loading('stop');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
				$('body').loading('stop');
			}
		});
	}
	
	$(document).on('click','.edit_baru',function(e){
		var id = $(this).attr('data-id');
		var status = $(this).attr('data-status');
		if(status==4 || status==5){
			return;
		}
		// console.log(id)
		$.ajax({
			url: base_url + 'laporan/get_laporan',
			data: {id:id},
			method: 'POST',
			dataType:'json',
			beforeSend: function () {
                $('body').loading();
				$('#OpenModalOperator').modal('show');
				$("#status_baru").append("<option value='loading'>loading</option>");
				$("#status_baru").empty();
			},
			success: function(data) {
				$('#noorder').val(data.nomor_order);
				$('#no_order').val(data.idorder);
				$("#status_baru option[value='loading']").remove();
				if(data.status==0)
				{
					console.log(data.status);
					$("#status_baru").append("<option value='1'>Desain</option>");
					}else if(data.status==1){
					$("#status_baru").append("<option value='2'>Proses</option>");
					}else if(data.status==2){
					$("#status_baru").append("<option value='3'>Selesai</option>");
					}else if(data.status==3){
					option = "<option value='4'>Pengambilan</option>";
					option += "<option value='5'>Dikirim</option>";
					$("#status_baru").append(option);
				}
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	$(document).on('click','.simpan_baru',function(e){
		var noorder = $('#noorder').val();
		var id = $('#no_order').val();
		var status_baru = $('#status_baru').val();
		if(status_baru==0){
			showNotif('bottom-right','Alert','Pilih status','warning');
			$('#status_baru').focus()
			return;
		}
		// console.log(id)
		$.ajax({
			url: base_url + 'laporan/simpan_laporan',
			data: {type:'proses',id:id,status:status_baru},
			method: 'POST',
			dataType:'json',
			beforeSend: function () {
                $('body').loading();
				$('#OpenModalOperator').modal('show');
			},
			success: function(data) {
				if(data.status==200){
					showNotif('bottom-right',data.title,data.msg,'success');
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#OpenModalOperator').modal('hide');
				search_Operator();
				
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	function clearSearch(tgl){
		$('#dari').val(tgl);
		$('#status').val('semua');
		$('#user').val(0);
		search_Operator();
	}
	
	$("#print_pekerjaan").click(function(e) {
		e.preventDefault();
		$( "#target_print" ).submit();
	});
</script>				
<style>.card .table td, .card .table th {padding-right: 1rem;padding-left: 1rem;}</style>
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Device</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Device</li>
		</ol>
	</div>
	
    <div class="row">
        <div class="col-md-12">
            <div class="card">
				<div class="card-header  d-flex flex-row align-items-center justify-content-between">
					<h6 class="m-0 font-weight-bold text-warning">List Data</h6>
					<button type="button" name="tambah" class="btn btn-success add_device" data-id="0">Tambah</button>
				</div>
                <div class="card-body">
                    <div class="loading-overlay" style="display:none"><div class="overlay-content">Loading.....</div></div>
					<table class="table table-bordered table-striped table-mailcard" id="data_Table">
						<thead>
							<tr>
								<th>Device</th>
								<th>Device_Status</th>
								<th>Expired</th>
								<th>Quota</th>
								<th>Paket</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody id="posts_content">
							
						</tbody>
					</table>
					
				</div><!-- /.card-body -->
			</div><!-- /.card -->
		</div>
	</div>
</div>

<div class="modal fade" id="Openqr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabelDevice">Scan Device</h4>
				<!--button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button-->
			</div>
			<div class="modal-body pb-0 mt-0 pt-1">
				<div class="load-qr text-center p-2"></div>
                <div class="text-center">
					<img src="" id="thumbnail" alt="" />
				</div>
			</div>
			<!--div class="modal-footer">
				<button type="button" class="btn bg-red" data-dismiss="modal">Close</button>
			</div-->
		</div>
	</div>
</div>

<div class="modal fade" id="OpenqrLogout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabelLogout">Connected</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body pb-0 mt-0 pt-1">
				<div class="load-qr text-center p-2"></div>
                <div class="text-center">
					<img src="" id="thumbnail" alt="" />
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn bg-red" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="addDevice" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
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
					<input type='hidden' name='id' id='id_device' value='0'>
					<input type='hidden' name='type' id="type_device">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group-row">
								<label for="token_api">Token WA-API <a href="javascript:void(0)" class="register">DAFTAR</a></label>
								<input type="text" name="token_api" id="token_api" class="form-control form-control-sm flat" required>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" name="submit" class="btn btn-info save_data">Simpan</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
	
	search_device();
    function search_device(){
        
        $.ajax({
            type: 'POST',
            url: base_url+'whatsapp/data_device/',
            beforeSend: function(){
                $('body').loading();
			},
            success: function(html){
                $('#posts_content').html(html);
                $('body').loading('stop');
			}
		});
	}
	$('#Openqr').on('hidden.bs.modal', function () {
		search_device();
	})
	
	function cek_status(token)
	{
		$.ajax({
			url: base_url + 'whatsapp/cek_status_device',
			method: 'POST',
			data:{token:token},
			dataType: "json",
			success: function(data) {
				// console.log(data);
				if(data.device_status=='connect'){
					showNotif('bottom-right','Device','Conected','success');
					}else{
					showNotif('bottom-right','Device','Not Conected','error');
				}
				search_device();
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
		
	}
	
    $(document).on('click','.scan_qr',function(e){
		e.preventDefault();
		var token = $(this).attr('token-id');
		
		$.ajax({
			method: 'POST',
			url: base_url + 'whatsapp/scan_qr',
			data:{token:token},
			dataType: "json",
			beforeSend: function () {
                $('body').loading();
				$('.load-qr').html('');
			},
			success: function(data) {
				// console.log(data);
				if(data.status==true){
					$('#Openqr').modal({backdrop: 'static', keyboard: false})  
					$('#myModalLabelDevice').html('Disconnect');
					$('.load-qr').html('Scan Device');
					$("#thumbnail").attr("src", "data:image/png;base64,"+data.url);
					// myVar = setTimeout(function(){ scan_qr() }, 8000);
					setTimeout(function(){
						$('#Openqr').modal('hide')
					}, 10000);
					}else{
					$('#Openqr').modal('show');
					$('#myModalLabelDevice').html('Connected');
					var detail = '<div class="reason">'+data.reason+'</div><button type="button" class="btn btn-danger logout_device">Logout</button>';
					$('.load-qr').html(detail);
					cek_status(token);
				}
				$('body').loading('stop');
				
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
    $(document).on('click','.logout_qr',function(e){
		e.preventDefault();
		var token = $(this).attr('token-id');
		$.ajax({
			method: 'POST',
			url: base_url + 'whatsapp/scan_qr',
			data:{token:token},
			dataType: "json",
			beforeSend: function () {
                $('body').loading();
				$('.load-qr').html('');
			},
			success: function(data) {
				 
				$('#OpenqrLogout').modal({backdrop: 'static', keyboard: false})  
				
				if(data.status==true){
					$('#myModalLabelDevice').html('Disconnect');
					$('.load-qr').html('Scan Device');
					$("#thumbnail").attr("src", "data:image/png;base64,"+data.url);
					// myVar = setTimeout(function(){ scan_qr() }, 8000);
					setTimeout(function(){
						$('#OpenqrLogout').modal('hide')
					}, 10000);
					}else{
					$('#myModalLabelDevice').html('Connected');
					var detail = '<div class="reason">'+data.reason+'</div><button type="button" class="btn btn-danger logout_device" data-id="'+data.token+'">Logout Device</button>';
					$('.load-qr').html(detail);
					// myVar = setTimeout(function(){ scan_qr() }, 8000);
				}
				$('body').loading('stop');
				
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
    $(document).on('click','.logout_device',function(e){
		e.preventDefault();
		var token = $(this).attr('data-id');
		 
		$.ajax({
			method: 'POST',
			url: base_url + 'whatsapp/logout_device',
			data:{token:token},
			dataType: "json",
			beforeSend: function () {
                $('body').loading();
			},
			success: function(data) {
				var msg = data.msg;
				// console.log(msg);
				if(data.status==true){
					if(msg.detail=='device disconnected successfully'){
						$('#OpenqrLogout').modal('hide');
						showNotif('bottom-right','Device Status',data.detail,'error');
						search_device();
					}
					if(msg.detail=='device disconnected'){
						$('#OpenqrLogout').modal('hide');
						showNotif('bottom-right','Device Status',data.detail,'error');
						search_device();
					}
					}else{
					showNotif('bottom-right','Device Status',data.msg,'error');
				}
				
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
    $(document).on('click','.add_device',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		$.ajax({
			url: base_url + 'whatsapp/add_device',
			method: 'POST',
			data:{tipe:'get',id:id},
			dataType: "json",
			beforeSend: function () {
                $('body').loading();
			},
			success: function(data) {
				$('body').loading('stop');
				if(data.id==0 && data.status==false)
				{
					$("#type_device").val('add');
					$('#addDevice').modal('show');
					return;
				}
				
				if(data.id==0 && data.status==200)
				{
					showNotif('bottom-right','Device Status',data.msg,'error');
					search_device();
					}else{
					$("#type_device").val('edit');
					$("#exampleModalScrollableTitle").html('Form Edit');
				}
				
				if(data.status==200 && data.id > 0){
					$('#addDevice').modal('show');
					$('#id_device').val(data.id);
					$('#token_api').val(data.token);
					}else{
					showNotif('bottom-right','Device Status',data.msg,'error');
				}
				
				
				},error: function(xhr, status, error) {
				showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
			}
		});
	});
	
	$(document).on('click','.save_data',function(e){
		e.preventDefault();
		var type_device = $("#type_device").val();
		var id = $("#id_device").val();
		var token = $("#token_api").val();
		
		if(token==''){
            $("#token_api").focus();
			return;
		}
		
		$.ajax({
			url: base_url + 'whatsapp/add_device',
			method: 'POST',
			data:{tipe:type_device,id:id,token:token},
			dataType: "json",
			beforeSend: function () {
                $('body').loading();
			},
			success: function(data) {
				
				if(data.status==200){
					showNotif('bottom-right','Update Device',data.msg,'success');
					$('#addDevice').modal('hide');
					$('#token_api').val('');
					search_device();
					}else{
					showNotif('bottom-right','Device Status',data.msg,'error');
				}
				
				$('body').loading('stop');
				},error: function(xhr, status, error) {
                showNotif('bottom-right','Update',error,'error');
				$('body').loading('stop');
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
			url: base_url + 'whatsapp/add_device',
			method: 'POST',
			dataType:'json',
			data:{id:id,tipe:"hapus"},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				if(data.status==200){
					sweet_time(500,'Status!!!',data.msg);
					} else if (arr.status == 401) {
					sweet_time(2500, "Peringatan!!!", arr.msg);
					}else{
					sweet('Peringatan!!!',data.msg,'warning','warning');
				}
				$('#confirm-delete').modal('hide');
				search_device();
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
	
    $(document).on('click','.register',function(e){
		window.open('https://pospercetakan.my.id/harga', '_blank');
	});
	
	
</script>        
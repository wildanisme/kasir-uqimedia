<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Backup Database</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Backup</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			<form action="#" method="post">
				<div class="card">
					<div class="card-header  d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-warning">List File Database </h6>
						<span id="nestable-menu" class="float-right">
							<button type="button" class="btn btn-success btn-sm backup" data-toggle="tooltip" title="Backup DB"><i class="fa fa-database"></i> Klik Untuk Backup</button>
						</span>
					</div>
					<?php 
						$map = directory_map('./backup_db/', FALSE, TRUE); 
					?>
					<div class="card-body table-responsive">
						<div class="card-block">
							<table class="table align-items-center table-flush table-hover" id="dataTableHover">
								<thead>
									<tr>
										<th>Nama File</th>
										<th>Tgl. Backup</th>
										<th style="width:15%!important">Size</th>
										<th class="text-right">Status | Hapus</th>
									</tr>
								</thead>
								
							</table>
						</div><!-- /.card -->
					</div><!-- /.card -->
				</div><!-- /.card -->
			</form>
		</div>
	</div>
</div>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade" id="confirm-delete" role="dialog" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
				<button aria-hidden="true" class="close" data-dismiss="modal" type="button">&times;</button>
			</div>
			<div class="modal-body">
				<p>Anda akan menghapus file database backup, prosedur ini tidak dapat diubah.</p>
				<p>Apakah Anda ingin melanjutkan?</p>
				<p class="debug-url"></p>
				<input type="hidden" id="data-hapus">
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button> 
				<button class="btn btn-danger hapus" type="button">YA</button> 
			</div>
		</div>
	</div>
</div>
<script>
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapus').val($(e.relatedTarget).data('file'));
	});
	
	$(document).ready(function() {
		$('body').tooltip({selector: '[data-toggle="tooltip"]'});
		var dataTable1 = $('#dataTableHover').DataTable({   
			"ajax":{  
				url:base_url + 'Backupdata/list_data',
				type:"POST"             
			},
			"order": [[ 0, 'desc' ]],
			"columnDefs": [
			{ "targets": [2,3], "orderable": false },
			{ "className": "text-right", "targets": [ 3 ] }
			]
			// dom: 'Bfrtip',
			// buttons: [
            // 'copy', 'csv', 'excel', 'pdf', 'print', 'colvis'
			// ]
		});
		
		$(document).on('click', '.backup', function() {
			$.ajax({
				'url': base_url + 'Backupdata/backupdb',
				'method': 'POST',
				'dataType':'json',
				beforeSend: function(){	 
					$('body').loading();
				},
				success: function(data) {
					$('body').loading('stop');
					if(data.status==200){
						sweet('Backup File!!!',data.msg,'success','success');
						}else{
						sweet('Peringatan!!!',data.msg,'warning','warning');
					}
					dataTable1.ajax.reload();  
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
			})
		});
		$(document).on('click', '.unzipdb', function() {
			var file = $(this).attr('data-file');
			// alert(file);
			$.ajax({
				'url': base_url + 'Backupdata/unzipdb',
				'method': 'POST',
				'data': {file:file},
				'dataType':'json',
				beforeSend: function(){	 
					$('body').loading();
				},
				success: function(data) {
					$('body').loading('stop');
					if(data.status==200){
						sweet('Extract DB!!!',data.msg,'success','success');
						}else{
						sweet('Peringatan!!!',data.msg,'warning','warning');
					}
					dataTable1.ajax.reload();  
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
			})
		});
		
		$(document).on('click', '.downloaddb', function() {
			var file = $(this).attr('data-file');
			// alert(file);
			$.ajax({
				'url': base_url + 'Backupdata/download_db',
				'method': 'POST',
				'data': {file:file},
				'dataType': 'binary',
				'xhrFields': {
					'responseType': 'blob'
				},
				beforeSend: function(){	 
					$('body').loading();
				},
				success: function(data) {
					var link = document.createElement('a'),
                    filename = file;
					link.href = URL.createObjectURL(data);
					link.download = filename;
					link.click();
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
			})
		});
		
		$(document).on('click', '.restoredb', function() {
			var file = $(this).attr('data-file');
			// alert(file);
			$.ajax({
				'url': base_url + 'Backupdata/restoredb',
				'method': 'POST',
				'data': {file:file},
				'dataType':'json',
				beforeSend: function () {
					$('body').loading();
				},
				success: function(data) {
					$(".loadings").hide();
					if(data.status==200){
						sweet('Restore DB!!!',data.msg,'success','success');
						}else{
						sweet('Restore DB!!!',data.msg,'warning','warning');
					}
					// dataTable1.ajax.reload();  
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
		$(document).on('click', '.hapus', function(e) {
			e.preventDefault();
			var file = $("#data-hapus").val();
			$.ajax({
				'url': base_url + 'Backupdata/hapusdb',
				'method': 'POST',
				'data':{file:file},
				'dataType':'json',
				beforeSend: function(){	 
					$('body').loading();
				},
				success: function(data) {
					$('body').loading('stop');
					if(data.status==200){
						sweet('Hapus File!!!',data.msg,'success','success');
						dataTable1.ajax.reload();  
						}else{
						sweet('Hapus File!!!','File gagal dihapus','warning','warning');
					}
					$('#confirm-delete').modal('hide');
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
			})
		});
	});
	
	
</script>
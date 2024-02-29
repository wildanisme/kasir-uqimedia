<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Report promo</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Report promo</li>
		</ol>
	</div>
	<div class="row">
		<div class="col-md-12">
			
			<div class="card">
				<div class="card-header pb-0">
					<div class="input-group input-group-sm">
						<div class="input-group-prepend">
							<span class="input-group-text">SORT</span>
						</div>
						<select id="sortBy" class="form-control custom-select w-5" onchange="search_LaporanGrup()">
							<option value="ASC">ASC</option>
							<option value="DESC" selected>DESC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select" onchange="search_LaporanGrup()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
						</select>
						<input type="text" id="keywords" class="form-control" placeholder="Cari data" onkeyup="search_LaporanGrup();"/>
					</div>
				</div>
				
				<div class="card-body table-responsive data-report">
					<div class="card-block" id="data_report">
						
					</div><!-- /.card-body -->
				</div><!-- /.card-body -->
			</div><!-- /.card -->
			
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
				<input type="hidden" id="data-konsumen">
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
		search_LaporanGrup();
	});
	
	function search_LaporanGrup(page_num){
		page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        var limits = $('#limits').val();
		
		$.ajax({
			type: 'POST',
			url: base_url + "promo/ajaxReport/"+page_num,
			data:{page:page_num,keywords:keywords,sortBy:sortBy,limits:limits},
			dataType: 'html',
			beforeSend: function(){
				$("body").loading();
			},
			success: function(data) {
				$("#data_report").html(data);
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
	
	
	$('#confirm-delete').on('show.bs.modal', function(e) {
		$('#data-hapusid').val($(e.relatedTarget).data('id'));
		$('#data-konsumen').val($(e.relatedTarget).data('konsumen'));
	});
	
	$(document).on('click','.hapus',function(e){
		e.preventDefault();
		var id = $("#data-hapusid").val();
		var konsumen = $("#data-konsumen").val();
		$.ajax({
			url: base_url + 'promo/hapus_report',
			method: 'POST',
			dataType:'json',
			data:{id:id,konsumen:konsumen},
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
				search_LaporanGrup();
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
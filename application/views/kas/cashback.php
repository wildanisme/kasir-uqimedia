<style>.card .table td, .card .table th {padding-right: 1rem;padding-left: 1rem;}</style>
<div class="container-fluid" id="container-wrapper">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Cashback<span id="test"></span></h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Cashback</li>
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
						<select id="sortBy" class="form-control custom-select w-5px" onchange="FilterCashback()" style="width:10px!important;padding-right:0!important">
							<option value="DESC">DESC</option>
							<option value="ASC">ASC</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">LIMIT</span>
						</div>
						<select id="limits" name="limits" class="form-control custom-select w-5px" onchange="FilterCashback()">
							<option value="10">10</option>
							<option value="20">20</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="500">500</option>
						</select>
						<div class="input-group-prepend">
							<span class="input-group-text">Jenis</span>
						</div>
						<select id="jenis" name="jenis" class="form-control custom-select w-5px" onchange="FilterCashback()">
							<option value="0">List Cashback</option>
							<option value="1">List Transaksi</option>
						</select>
						
						<div class="btn-group" role="group">
							<button class="btn btn-success btn-sm" onclick="FilterCashback();"><i class="fa fa-search"></i> TAMPILKAN</button>
							<button class="btn btn-primary btn-sm url_doc" data-url="log" type="button" data-toggle="tooltip" data-original-title="Dok Log Transaksi" data-placement="left"><i class="fa fa-info-circle"></i></button>
						</div>
					</div>
				</div>
				<div class="post-list" id="dataCashback">
				</div>
			</div>
		</div>
	</div>
</div>
<div id="ModalWithdraw" class="modal left fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content flat">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalScrollableTitle">Withdraw</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="myFormWithdraw">
					<input type='hidden' name='id_konsumen_withdraw' id='id_konsumen_withdraw' value='0'>
					<input type='hidden' name='id_invoice_withdraw' id='id_invoice_withdraw' value='0'>
					<input type='hidden' name='type' id="type">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group mb-1">
								<label for="dari_kas">Dari Kas</label>
								<select name="dari_kas" id="dari_kas" class="form-control form-control-sm " required>
									
								</select>
							</div>
							<div class="form-group mb-1 rekening_dari" style="display:none">
								<label for="rekening_dari">Rekening/Merchant</label>
								<select name="rekening_dari" id="rekening_dari" class="form-control form-control-sm" required>
								</select>
							</div>
							<div class="form-group mb-1">
								<label for="tujuan">Tujuan</label>
								<select name="tujuan" id="tujuan" class="form-control form-control-sm" required>
									<option value="">Pilih</option>
									<option value="1">Ya</option>
									<option value="0">Tidak</option>
								</select>
							</div>
							<div class="form-group mb-1 rekening" style="display:none">
								<label for="rekening">Rekening/Merchant</label>
								<select name="rekening" id="rekening" class="form-control form-control-sm" required>
								</select>
							</div>
							<div class="form-group mb-1">
								<label for="saldo">Saldo Kas</label>
								<div class="input-group mb-3">
									<input type="text" name="saldo" id="saldo" value="0" class="form-control form-control-sm" readonly >
									<div class="input-group-append">
										<button class="btn btn-outline-info btn-sm cek_saldo" type="button">Cek</button>
										</div>
								</div>
								
							</div>
							<div class="form-group mb-1">
								<label for="jumlah">Jumlah</label>
								<input type="text" name="jumlah_withdraw" id="jumlah_withdraw" class="form-control form-control-sm input" onkeyup="formatNumber(this);" required>
							</div>
						</div>
						
					</div>
				</form>
                <div class="modal-footer">
                    <button type="button" name="submit" class="btn btn-info save_withdraw">Proses</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
	.cell-1 {
	border-collapse: separate;
	border-spacing: 0 4em;
	background: #ffffff;
	border-bottom: 5px solid transparent;
	background-clip: padding-box;
	cursor: pointer
	}
	
	
	.table-elipse {
	cursor: pointer
	}
	
	.row-child {
	background-color: #dbdbea;
	}
</style>
<script>
	$(document).on('click','.add_widthdraw',function(e){
		e.preventDefault();
		var id = $(this).attr('data-id');
		var noin = $(this).attr('data-noin');
		var jumlah = $(this).attr('data-jumlah');
		console.log(id)
		$('#ModalWithdraw').modal({backdrop: 'static', keyboard: false});
		$("#id_konsumen_withdraw").val(id);
		$("#id_invoice_withdraw").val(noin);
		$("#jumlah_withdraw").val(jumlah);
		$("#tujuan").attr('disabled',true);
		$("#saldo").val(formatMoney(0, 0, "Rp."));
		if(id==0){
			$("#type").val('add');
			return
			}else{
			$("#type").val('edit');
		}
	});
	
	$(document).on('click','.cek_saldo',function(e){
		e.preventDefault();
		var idkas = $("#dari_kas").val();
		var rekening = $("#rekening_dari").val();
		$.ajax({
			url: base_url + "kas/cek_saldo",
			type: 'POST',
			data: {rekening:rekening,idkas:idkas},
			dataType: 'json',
			beforeSend: function () {
				$('body').loading();
			},
			success: function (response) {
				if(response.status==200 && response.saldo!=null){
					$("#saldo").val(formatMoney(response.saldo, 0, "Rp."));
					}else{
					$("#saldo").val(formatMoney(0, 0, "Rp."));
				}
				$('body').loading('stop');
			}
		});
	});
	
	$("#dari_kas").filter(function () {
		$.ajax({
			url: base_url + "kas/jenis_kas_mutasi",
			type: 'POST',
			dataType: 'json',
			beforeSend: function () {
				$("#dari_kas").append("<option value='loading'>loading</option>");
				$("#dari_kas").empty();
				$("#dari_kas").attr('disabled',false);
				$("#tujuan").attr('disabled',true);
			},
			success: function (response) {
				$("#dari_kas option[value='loading']").remove();
				$("#dari_kas").append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					$("#dari_kas").append("<option value='" + id + "'>" + name + "</option>");
				}
			}
		});
	});
	
	$("#dari_kas").change(function () {
		var id_tujuan = $("#dari_kas").val();
		$(".rekening").css('display','none');
		if(id_tujuan==0){
			$("#tujuan").empty();
			$("#tujuan").append("<option value=''>Pilih</option>");
			$("#tujuan").attr('disabled',true);
			return
		}
		if(id_tujuan==110){
			$("#tujuan").attr('disabled',true);
			$(".rekening_dari").css('display','block');
			load_rekening(id_tujuan);
			
			}else{
			$(".rekening_dari").css('display','none');
			$("#tujuan").attr('disabled',false);
			$.ajax({
				url: base_url + "kas/tujuan_kas_withdraw",
				type: 'POST',
				data: {id:id_tujuan},
				dataType: 'json',
				beforeSend: function () {
					$("#tujuan").append("<option value='loading'>loading</option>");
					$("#tujuan").empty();
				},
				success: function (response) {
					$("#tujuan option[value='loading']").remove();
					// $("#tujuan").append("<option value=''>Pilih</option>");
					var len = response.length;
					for (var i = 0; i < len; i++) {
						var id = response[i]['id'];
						var name = response[i]['name'];
						$("#tujuan").append("<option value='" + id + "'>" + name + "</option>");
					}
					// console.log(id);
				}
			});
		}
		
	});
	
	
	$("#tujuan").change(function () {
		var id_tujuan = $("#tujuan").val();
		var dari = $("#rekening_dari").val();
		if(id_tujuan==110){
			$(".rekening").css('display','block');
			}else{
			$(".rekening").css('display','none');
		}
		
		$.ajax({
			url: base_url + "kas/rekening",
			type: 'POST',
			data: {id:id_tujuan,dari:dari},
			dataType: 'json',
			beforeSend: function () {
				$("#rekening").append("<option value='loading'>loading</option>");
				$("#rekening").empty();
			},
			success: function (response) {
				$("#rekening option[value='loading']").remove();
				$("#rekening").append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					$("#rekening").append("<option value='" + id + "'>" + name + "</option>");
				}
				// console.log(id);
			}
		});
	});
	
	function load_tujuan(id_tujuan){
		$.ajax({
			url: base_url + "kas/tujuan_kas_withdraw",
			type: 'POST',
			data: {id:id_tujuan},
			dataType: 'json',
			beforeSend: function () {
				$("#tujuan").append("<option value='loading'>loading</option>");
				$("#tujuan").empty();
			},
			success: function (response) {
				$("#tujuan option[value='loading']").remove();
				// $("#tujuan").append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					$("#tujuan").append("<option value='" + id + "'>" + name + "</option>");
				}
				// console.log(id);
			}
		});
	}
	function load_rekening(id){
		$.ajax({
			url: base_url + "kas/rekening",
			type: 'POST',
			data: {id:id},
			dataType: 'json',
			beforeSend: function () {
				$("#rekening_dari").append("<option value='loading'>loading</option>");
				$("#rekening_dari").empty();
			},
			success: function (response) {
				$("#rekening_dari option[value='loading']").remove();
				$("#rekening_dari").append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					$("#rekening_dari").append("<option value='" + id + "'>" + name + "</option>");
				}
			}
		});
	}
	
	$("#rekening_dari").change(function () {
		var id = $("#rekening_dari").val();
		$("#tujuan").attr('disabled',false);
		$.ajax({
			url: base_url + "kas/tujuan_kas_withdraw",
			type: 'POST',
			data: {id:id},
			dataType: 'json',
			beforeSend: function () {
				$("#tujuan").append("<option value='loading'>loading</option>");
				$("#tujuan").empty();
			},
			success: function (response) {
				$("#tujuan option[value='loading']").remove();
				// $("#tujuan").append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					$("#tujuan").append("<option value='" + id + "'>" + name + "</option>");
				}
				// console.log(id);
			}
		});
	});
	var jumlah = document.getElementById('jumlah_withdraw');
	jumlah.addEventListener('keyup', function(e)
    {
        jumlah.value = formatRupiah(this.value, 'Rp. ');
        jml_bayar = angka(this.value);
        saldo = angka($("#saldo").val());
        if(parseInt(jml_bayar) > parseInt(saldo)){
            sweet_time(2000,'Status!!!','saldo tidak mencukupi');
            $("#jumlah_withdraw").val(formatMoney(0, 0, "Rp."));
		}
        
	});	
	FilterCashback();
	function FilterCashback(page_num){
		page_num = page_num?page_num:0;
		var sortBy = $('#sortBy').val();
		var limits = $('#limits').val();
		
		$.ajax({
			type: 'POST',
			url: base_url+'kas/ajaxCashback/'+page_num,
			data:{page:page_num,sortBy:sortBy,limits:limits},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(html){
				$('#dataCashback').html(html);
				$('body').loading('stop');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
				$('body').loading('stop');
			}
		});
		
	}
	$(document).on('click','.save_withdraw',function(e){
		$('#myFormWithdraw').submit();
	});
	$('#myFormWithdraw').submit(function(e){
		e.preventDefault();
		
		var tujuan = $("#tujuan").val();
		var jumlah = angka($("#jumlah_withdraw").val());
		var saldo = angka($("#saldo").val());
		
		if(tujuan==''){
			$("#tujuan").addClass('is-invalid');
			$("#tujuan").focus();
			return;
		}
		if(parseInt(saldo)==0){
			sweet_time(2000,'Status!!!','saldo tidak mencukupi');
			return;
		}
		if(parseInt(jumlah) > parseInt(saldo)){
			sweet_time(2000,'Status!!!','saldo tidak mencukupi');
			return;
		}
		
		if(jumlah=='' || parseInt(jumlah) <= 0 ){
			$("#jumlah_withdraw").addClass('is-invalid');
			$("#jumlah_withdraw").focus();
			return;
		}
		// return
		$.ajax({
			url: base_url + "kas/simpan_withdraw",
			type: 'POST',
			data: $(this).serialize(),
			dataType: 'json',
			beforeSend: function () {
				$('body').loading();
			},
			success: function (response) {
				if(response.status==200){
					sweet_time(2000,'Status!!!',response.msg);
					}else{
					sweet_time(2000,'Status!!!',response.msg);
				}
				$("#jumlah_withdraw").val(0);
				FilterCashback();
				$('#ModalWithdraw').modal('hide');
				$('body').loading('stop')
			}
		});
	});
	
</script>																																					
<style>.card .table td, .card .table th {padding-right: 1rem;padding-left: 1rem;}</style>
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Kirim Promo</h1>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="./">Home</a></li>
			<li class="breadcrumb-item active" aria-current="page">Kirim Promo</li>
		</ol>
	</div>
	
	<div class="row">
		<div class="col-md-7">
			<div class="card loading-promo">
				<div class="card-header pb-0">
					<h4 class="card-title">Panel kirim promo</h4>
				</div>
				<div class="card-body pt-0">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="device_promo">Device</label>
								<div class="input-group input-group-sm">
									<select name="device" id="device_promo" class="custom-select form-control form-control-sm flat"  data-source-promo="<?= base_url('promo/load_device'); ?>" data-valueKey="id" data-displayKey="name" required>
									</select>
									<div class="input-group-prepend">
										<button class="btn btn-secondary" type="button" id="cek_status">CEK STATUS</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<select name="label" class="custom-select form-control form-control-sm flat" id="label" disabled>
									<option value="">Pilih Label</option>
									<option value="1">Kirim Kesemua</option>
									<?php foreach($label AS $row){ ?>
										<option value="<?=$row->panggilan;?>"><?=$row->panggilan;?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<div class="input-group input-group-sm flat">
									<div class="input-group-prepend">
										<span class="input-group-text flat" for="delay">Delay</span>
									</div>
									<select name="delay" class="custom-select form-control form-control-sm flat" id="delay" disabled>
										<option value="02">2 Detik</option>
										<option value="03">3 Detik</option>
										<option value="04">4 Detik</option>
										<option value="05">5 Detik</option>
										<option value="06">6 Detik</option>
										<option value="07">7 Detik</option>
										<option value="08">8 Detik</option>
										<option value="09">9 Detik</option>
										<option value="10">10 Detik</option>
									</select>
								</div>
								
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<div class="input-group input-group-sm">
									<div class="input-group-prepend">
										<span class="input-group-text flat" for="max">Max. Kirim</span>
									</div>
									<input type="number" class="form-control flat"  min="1" name="max" id="max_kirim" value="100" disabled>
								</div>
							</div>
						</div>
						<div class="col-md-6">				
							<div class="form-group">
								<label>Format Pesan</label>
								<select name="format_pesan" class="form-control custom-select form-control-sm flat" id="format_pesan" disabled>
									<option value="0">Langsung</option>
									<option value="1">Schedule</option>
								</select>
							</div>
						</div>
						<div class="col-md-6">				
							<div class="form-group">
								<label for="text_promo">Pilih Konten Promo</label>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend input-sm flat">
										<button class="btn btn-outline-secondary btn-sm lihat flat" id="lihat" type="button" disabled>Display</button>
									</div>
									<select name="text_promo" class="form-control custom-select form-control-sm flat" id="text_promo" disabled>
										<option value="0">Pilih Konten Promo</option>
										<?php foreach($promo AS $row){ ?>
											<option value="<?=$row->id;?>"><?=$row->title;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12 schedule">
							<div class="form-group">
								<label for="schedule">Schedule</label>
								<div class="input-group input-group-sm">
									<div class="input-group-prepend"  data-toggle="tooltip" data-placement="top" title="Format AM/PM ke 24 Jam">
										<button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#ModalFormat">Format AM/PM</button>
									</div>
									<input type="datetime-local" class="form-control" id="schedule" name="schedule">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<button class="btn btn-warning btn-sm reset" id="reset"><i class="la flaticon-message"></i> Reset</button> <button class="btn btn-primary btn-sm kirim" id="kirim" disabled><i class="la flaticon-message"></i> Start</button>
							<button class="btn btn-danger  btn-sm stop" id="stop" disabled><i class="la flaticon-error"></i> Stop</button>
							<button class="btn btn-success btn-sm ">Terkirim <b class="berhasil">0</b></button>
							<button class="btn btn-warning btn-sm ">Gagal <b class="gagal">0</b></button>
							<button class="btn btn-info btn-sm ">Total dikirim <b class="total">0</b></button>
							<button class="btn btn-info btn-sm ">Kontak <b class="total_kontak">0</b></button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		
		<div class="col-md-5">
			<div class="card">
				<div class="card-header pb-0">
					<h4 class="card-title">Kirim Promo Status</h4>
					<p class="card-category">Status dikirim / gagal</p>
				</div>
				<div class="card-body pt-0">
					<div class="row">
						<div class="col-md-12 mx-auto">
							<div class="code-window">
								<div class="dots">
									<div class="red"></div>
									<div class="orange"></div>
									<div class="green"></div>
								</div>
								<pre class="language-javascript line-numbers terminal" style="min-height:125px;"><code class="language-javascript"><ul id="menu" class="logs m-0 p-1"></ul></code></pre>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if(is_demo() == 'N'){ ?>
			<div class="col-md-12 mt-2">
				<div class="card">
					<div class="card-header pb-0">
						<h4 class="card-title">Catatan</h4>
					</div>
					<div class="card-body pt-0">
						<p>Modul ini tidak termasuk dalam pembelian</p>
						<p>Info lebih lanjut hubungi pengembang</p>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalFormat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">24-Hour Clock Time Conversion Table</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-striped table-bordered">
					<tr>
						<td class="boxcontent">1 AM</td>
						<td class="boxcontent">01:00</td>
					</tr>
					<tr>
						<td class="boxcontent">2 AM</td>
						<td class="boxcontent">02:00</td>
					</tr>
					<tr>
						<td class="boxcontent">3 AM</td>
						<td class="boxcontent">03:00</td>
					</tr>
					<tr>
						<td class="boxcontent">4 AM</td>
						<td class="boxcontent">04:00</td>
					</tr>
					<tr>
						<td class="boxcontent">5 AM</td>
						<td class="boxcontent">05:00</td>
					</tr>
					<tr>
						<td class="boxcontent">6 AM</td>
						<td class="boxcontent">06:00</td>
					</tr>
					<tr>
						<td class="boxcontent">7 AM</td>
						<td class="boxcontent">07:00</td>
					</tr>
					<tr>
						<td class="boxcontent">8 AM</td>
						<td class="boxcontent">08:00</td>
					</tr>
					<tr>
						<td class="boxcontent">9 AM</td>
						<td class="boxcontent">09:00</td>
					</tr>
					<tr>
						<td class="boxcontent">10 AM</td>
						<td class="boxcontent">10:00</td>
					</tr>
					<tr>
						<td class="boxcontent">11 AM</td>
						<td class="boxcontent">11:00</td>
					</tr>
					<tr>
						<td class="boxcontent">12 PM</td>
						<td class="boxcontent">12:00</td>
					</tr>
					<tr>
						<td class="boxcontent">1 PM</td>
						<td class="boxcontent">13:00</td>
					</tr>
					<tr>
						<td class="boxcontent">2 PM</td>
						<td class="boxcontent">14:00</td>
					</tr>
					<tr>
						<td class="boxcontent">3 PM</td>
						<td class="boxcontent">15:00</td>
					</tr>
					<tr>
						<td class="boxcontent">4 PM</td>
						<td class="boxcontent">16:00</td>
					</tr>
					<tr>
						<td class="boxcontent">5 PM</td>
						<td class="boxcontent">17:00</td>
					</tr>
					<tr>
						<td class="boxcontent">6 PM</td>
						<td class="boxcontent">18:00</td>
					</tr>
					<tr>
						<td class="boxcontent">7 PM</td>
						<td class="boxcontent">19:00</td>
					</tr>
					<tr>
						<td class="boxcontent">8 PM</td>
						<td class="boxcontent">20:00</td>
					</tr>
					<tr>
						<td class="boxcontent">9 PM</td>
						<td class="boxcontent">21:00</td>
					</tr>
					<tr>
						<td class="boxcontent">10 PM</td>
						<td class="boxcontent">22:00</td>
					</tr>
					<tr>
						<td class="boxcontent">11 PM</td>
						<td class="boxcontent">23:00</td>
					</tr>
					<tr>
						<td class="boxcontent">12 AM</td>
						<td class="boxcontent">00:00</td>
					</tr>
				</tbody></table>
		</div>
	</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-display" tabindex="-1" role="dialog" aria-labelledby="titleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="titleModalLabel">Contoh Promo</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<textarea class="tampil-body form-control" readonly></textarea>
			</div>
		</div>
	</div>
</div>

<style>
    #select2-multiple-container{
    width: 100% !important;
    padding: 0;
	border:1px;
    }
	
	li#gagal {list-style-type: " \0024";}
	li#berhasil {list-style-type: " \0024";}
	li#nol {list-style-type: " \0024";}
	
	/*Code Window*/
	.code-window {
	border-radius: .45rem;
	background-color: #000;
	padding: 1rem;
	box-shadow: 0 8px 24px 0 rgba(0, 0, 0, 0.1); }
	.code-window .dots {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: row;
	flex-direction: row;
    -ms-flex-align: center;
	align-items: center;
    -ms-flex-pack: start;
	justify-content: flex-start; }
    .code-window .dots div {
	margin-right: .5rem;
	width: .75rem;
	height: .75rem;
	border-radius: 50%;
	background-color: #e9ecef; }
	.code-window .dots div.red {
	background-color: #ff1744; }
	.code-window .dots div.orange {
	background-color: #f6c343; }
	.code-window .dots div.green {
	background-color: #5cc72a; }
	
	pre[class*="language-"].line-numbers {
	position: relative;
	padding:5px;
	}
	code[class*="language-"],
	pre[class*="language-"] {
	background: none;
	font-family: Consolas, Monaco, 'Andale Mono', 'Ubuntu Mono', monospace;
	text-align: left;
	white-space: pre;
	word-spacing: normal;
	word-break: normal;
	word-wrap: normal;
	line-height: 1.5;
	-moz-tab-size: 4;
	tab-size: 4;
	-webkit-hyphens: none;
	-ms-hyphens: none;
	hyphens: none; }
	
	
	:not(pre) > code[class*="language-"],
	pre[class*="language-"] {
	background: #000; }
	
	/* Inline code */
	:not(pre) > code[class*="language-"] {
	padding: .1em;
	border-radius: .3em;
	white-space: normal; }
</style>

<script> 
	
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	});
	
	let setHeight = (input) => {
		
		input.style.overflow = 'hidden';
		input.style.height = 0;
		
		input.style.height = `${ input.scrollHeight + 2 }px`;		
	};
	
	$('.modal').on('shown.bs.modal', function () {
		$(this).find('textarea').each(function () {
			setHeight(this);
		});
	})
	
	$(".language-javascript").css("--color", "#f5c708");
	$('.schedule').hide();
	var myVar;
	$('#kirim').click(function() {
		var format_pesan = $("#format_pesan").val();
		var time_delay = $("#delay").val();
		
		if(format_pesan==1)
		{
			var delay = parseInt(time_delay) * parseInt(1000);
			}else{
			delay = 100;
		}
		
		
		var berhasil = 0;
		var gagal = 0;
		var total = 0;
		no=1;
		
		var promo = $("#text_promo").val();
		
		var schedule = $("#schedule").val();
		
		var label = $("#label").val();
		var max = $("#max_kirim").val();
		if(label==''){
			alert("Label belum dipilih");
			return;
		}
		
		if(format_pesan==1 && schedule==''){
			alert("Schedule masih kosong");
			return;
		}
		
		if(promo==0){
			alert("Konten promo belum dipilih");
			return;
		}
		if(max==''){
			alert("max belum di isi");
			return;
		}
		berhasil = $("#menu").find("li#berhasil").length;
		gagal = $("#menu").find("li#gagal").length;
		total = berhasil + gagal;
		var no = no +total;
		$('.total').html(total);
		$('#kirim').prop('disabled', true);
		$('#stop').prop('disabled', false);
		var total_kirim = $('.total').html();
		console.log(total_kirim);
		if(parseInt(total_kirim) == parseInt(max)){
			$('#kirim').attr('disabled',true);
			$('#stop').click();
			console.log("stop");
			return;
		}
		$.ajax({
			type: "POST",
			url: base_url +"promo/cek_nomor",
			dataType:"json",
			data: {type:'cari',promo:promo,label:label},
			success: function (response) {
				if(response.status==true){
					setTimeout(function() {
						panggil_wa(response.number,response.message,response.title,response.id);
					}, delay);
					}else if(response.status==false){
					$('#stop').click();
					$('.logs').append($('<li id="nol">').text('Nomor tidak ditemukan')); 
					var totalnya = $('.total').html() - $("#menu").find("li#nol").length;
					}else{
					$('.logs').append($('<li>').text('Nomor tidak ditemukan')); 
					$('#stop').click();
				}
				// You will get response from your PHP page (what you echo or print)
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#stop').click();
				console.log(textStatus, errorThrown);
			}
		});
		
	});
	
	$('#reset').click(function() {
		$('#kirim').prop('disabled', true);
		$('#stop').prop('disabled', true);
		$('#label').val('');
		$('#berhasil').html('');
		$('.berhasil').html('0');
		$('.gagal').html('0');
		$('.total').html('0');
		$('.total_kontak').html('0');
		$("#menu").find("li#berhasil").html('');
		$("#menu").find("li#gagal").html('');
		
	});
	$('#stop').click(function() {
		$('#kirim').prop('disabled', false);
		$('#stop').prop('disabled', true);
		$('#label').val('');
		$('#text_promo').val(0);
		// StopFunction();
		$('.total').html(0);
		myStopFunction();
		
	});
	
	function myStopFunction() {
		clearTimeout(myVar);
		$(".terminal").css("--color", "#8c0023");
		
	}
	
	function panggil_wa(number,pesan,judul,id){
		var promo = $("#text_promo").val();
		var total = $('.total').text();
		var max = $('#max_kirim').val();
		var schedule = $("#schedule").val();
		var time_delay = $("#delay").val();
		var format_pesan = $("#format_pesan").val();
		var device_promo = $("#device_promo").val();
		
		if(format_pesan==1)
		{
			var delay = parseInt(time_delay) * parseInt(1000);
			}else{
			delay = 1000;
		}
		
		$.ajax({
			url: base_url + 'promo/kirim_pesan',
			type: "POST",
			dataType:"json",
			data: {jenis:'text',number:number,message:pesan,delay:time_delay,promo:promo,schedule:schedule,format_pesan:format_pesan,device:device_promo},
			async:true,
			crossDomain:true,
			success: function (response) {
				if(response.status==true){
					terkirim(number,pesan,id);
					$('.logs').append($('<li id="berhasil">').text(" "+judul +" dikirim ke >"+ number));
					myVar = setTimeout(function(){ $('#kirim').click(); }, delay);
				} 
				if(response.status==false){
					$('.logs').append($('<li id="gagal">').text("Koneksi buruk")); 
					myVar = setTimeout(function(){ $('#kirim').click(); }, delay);
					gagal(number);
				} 
				var nomor = $("#menu").find("li#berhasil").length; 
				$('.berhasil').html(nomor); 
			},
			error: function (error) {
				if(error.status==500){
					$('.logs').append($('<li id="nol">').text(' Gagal terhubung ke server coba lagi')); 
					$('#stop').click();
					var totalnya = $('.total').html() - $("#menu").find("li#nol").length;
					
					}else if(error.status==503){
					$('.logs').append($('<li id="nol">').text(' Gagal terhubung ke server coba lagi')); 
					$('#stop').click();
					var totalnya = $('.total').html() - $("#menu").find("li#nol").length;
					
					}else if(error.status==422){
					
					$('.logs').append($('<li id="nol">').text(number +" > Bukan WA"));
					myVar = setTimeout(function(){ $('#kirim').click(); }, delay);
					gagal(number);
					$('#stop').click();
					}else{
					$('.logs').append($('<li id="nol">').text(' Gagal terhubung scan QR dulu')); 
					$('#stop').click();
					var totalnya = $('.total').html() - $("#menu").find("li#nol").length;
					
				}
				
				var nomor = $("#menu").find("li#gagal").length;
				$('.gagal').html(nomor);
				
			}
			
			<!-- error: function(jqXHR, textStatus, errorThrown) { -->
			<!-- console.log(textStatus, errorThrown); -->
			<!-- } -->
		});
	}
	
	function terkirim(number,pesan,id){
		$.ajax({
			url: base_url +"promo/pesan_terkirim",
			dataType:"json",
			type: "POST",
			data: {type:'terkirim',number:number,pesan:pesan,id:id},
			success: function (response) {
				console.log(response);
			}
			
		});
		
	}
	function gagal(number){
		$.ajax({
			url: base_url +"promo/pesan_gagal",
			dataType:"json",
			type: "POST",
			data: {type:'gagal',number:number},
			success: function (response) {
				$('.logs').append($('<li>').text('Promo gagal dikirim ke > '+number)); 
				console.log(response.msg);
				
			}
			// error: function(jqXHR, textStatus, errorThrown) {
			// console.log(textStatus, errorThrown);
			// }
		});
	}
	
	//pesan
	$("#label").change(function() {
		var id = $(this).val();
		var max_kirim = $('#max_kirim').val();
		$(".kirim").attr('disabled',true);
		$(".stop").attr('disabled',false);
		$.ajax({
			url: base_url + 'promo/cek_label',
			method: 'POST',
			dataType:'json',
			data:{id:id},
			beforeSend: function(){
				$('.loading-promo').loading({zIndex:1060});
			},
			success: function(data) {
				if(data.total > 0){
					$(".kirim").attr('disabled',false);
					// $(".stop").attr('disabled',false);
					$("#max_kirim").attr('disabled',false);
					$("#max_kirim").val(data.total);
					}else{
					$("#max_kirim").val(0);
					$("#max_kirim").attr('disabled',true);
				}
				
				$(".total_kontak").text(data.total);
				$('.loading-promo').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('.loading-promo').loading('stop');
			}
		});
		
	});
	
	//format pesan
	$("#format_pesan").change(function() {
		var id = $(this).val();
		if(id==0){
			$('.schedule').hide();
			$(".terminal").css('height', "125px");
			}else{
			$('.schedule').show();
			$(".terminal").css('height', "210px");
		}
	});
	
	//format pesan
	$("#text_promo").change(function() {
		var id = $(this).val();
		
		if(id >0){
			$('#lihat').attr('data-id', id); // sets 
			$('#lihat').removeClass('btn-outline-secondary').addClass('btn-warning'); // sets 
			$('#lihat').attr('disabled', false); // sets 
			}else{
			$('#lihat').attr('disabled', true); // sets 
			$('#lihat').removeClass('btn-warning').addClass('btn-outline-secondary'); // sets 
			$('#lihat').attr('data-id', ''); // sets 
		}
	});
	
	
	$('.lihat').click(function() {
		$("#modal-display").modal('show');
		
		var id = $(this).attr("data-id");
		
		if(id==''){
			return;
		}
		
		$.ajax({
			type: "POST",
			url: base_url +"promo/cek_contoh",
			dataType:"json",
			data: {id:id},
			success: function (response) {
				if(response.status==true){
					$('#titleModalLabel').html(response.title);
					$('.tampil-body').val(response.message);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				$('#stop').click();
				console.log(textStatus, errorThrown);
			}
		});
	});
	
	$("#device_promo").filter(function() {
		
		$("select[data-source-promo]").each(function() {
			var element = $(this);
			element.append('<option value="">Pilih Device</option>');
			$.ajax({
				url : element.attr("data-source-promo")
				}).then(function(buildInTemplates) {
				buildInTemplates.map(function(match) {
					var url = $("<option>");
					url.val(match[element.attr("data-valueKey")]).text(match[element.attr("data-displayKey")]);
					element.append(url);
				});
			});
		});
	});
	//pesan
	$("#device_promo").change(function() {
		var id = $(this).val();
		if(id==''){
			$("#device_promo").focus();
			$('#cek_status').removeClass('btn-success');
			$('#cek_status').removeClass('btn-warning');
			$('#cek_status').addClass('btn-secondary');
			$('#cek_status').html('CEK STATUS');
			return;
		}
		$.ajax({
			url: base_url + 'promo/cek_status',
			method: 'POST',
			dataType:'json',
			data:{token:id},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				if(data.device_status=='connect'){
					$('#cek_status').html('CONNECTED').removeClass('btn-secondary').addClass('btn-success');
					$('#label').prop('disabled', false);
					$('#delay').prop('disabled', false);
					$('#format_pesan').prop('disabled', false);
					$('#text_promo').prop('disabled', false);
					}else{
					$('#cek_status').html('DISCONNECTED').removeClass('btn-success').addClass('btn-warning');
					$('#label').prop('disabled', true);
					$('#delay').prop('disabled', true);
					$('#format_pesan').prop('disabled', true);
					$('#text_promo').prop('disabled', true);
					$('#kirim').prop('disabled', true);
					$('#stop').prop('disabled', true);
					$('#reset').prop('disabled', true);
				}
				$('body').loading('stop');
			},
			error: function(xhr, status, error) {
				var err = xhr.responseText ;
				sweet('Server!!!',err,'error','danger');
				$('body').loading('stop');
			}
		});
		
	});
	
	</script>        																																																		
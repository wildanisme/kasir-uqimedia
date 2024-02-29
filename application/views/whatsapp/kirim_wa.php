<form id="form-wa" method="post">
	<div class="form-group mb-1">
		<label for="device">Device</label>
		<div class="input-group input-group-sm">
			<select name="device" id="device" class="custom-select form-control form-control-sm"  data-source="<?= base_url('whatsapp/load_device'); ?>" data-valueKey="id" data-displayKey="name" required>
			</select>
			<div class="input-group-prepend">
				<button class="btn btn-secondary" type="button" id="cek_status">STATUS</button>
			</div>
		</div>
	</div>
	
	<div class="form-group mb-1">
		<label for="nomor_tujuan">Nomor Tujuan</label>
		<input type="text" class="form-control form-control-sm fcs" id="nomor_tujuan" name="nomor_tujuan" value="<?=$nomor;?>" readonly required>
	</div>
	<div class="form-group mb-1">
		<label for="nomor_order">Nomor Order</label>
		<input type="hidden" class="form-control" id="id" name="id" value="<?=$id;?>">
		
		<input type="hidden" class="form-control" id="tgl_order" name="tgl_order" value="<?=$tgl;?>">
		<input type="hidden" class="form-control" id="user" name="user" value="<?=$user;?>">
		<input type="text" class="form-control form-control-sm fcs" id="nomor_order" name="nomor_order" value="<?=$id_invoice;?>" readonly required>
	</div>
	<div class="form-group mb-1">
		<label for="jenis_pesan">Jenis Pesan</label>
		<select name="jenis_pesan" id="jenis_pesan" class="custom-select form-control form-control-sm" required>
			<option value="" selected>Pilih Jenis Pesan</option>
			<?php foreach($jenis AS $val){
				echo '<option value="'.$val->id.'">'.$val->title.'</option>';
			}
			?>
		</select>
		
	</div>
	<div class="form-group mb-1 isi_pesan" style="display:none">
		<label for="isi_pesan">Pesan</label>
		<textarea class="form-control form-control-sm fcs" rows="6" id="isi_pesan" name="isi_pesan" required></textarea>
	</div>
</form>		
<script>
	
	$("#jenis_pesan").on("change", function() {
		var id = $(this).val();
		if(id !=''){
			$('.isi_pesan').show();
			}else{
			$('.isi_pesan').hide();
		}
		var idorder = $('#id').val();
		var nomor_order = $('#nomor_order').val();
		var tgl = $('#tgl_order').val();
		var user = $('#user').val();
		$.ajax({
			url: base_url + 'whatsapp/get_pesan',
			data: {status:id,idorder:idorder,nomor_order:nomor_order,tgl:tgl,user:user},
			method: 'POST',
			dataType:'json',
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				if(data.status==false){
					$('#jenis_pesan').val('');
					$('#isi_pesan').val('');
					$('.isi_pesan').hide();
					sweet('Peringatan!!!',data.msg,'error','danger');
					}else{
					$("#isi_pesan").val(decodeURIComponent(data.msg));
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
	$("#device").filter(function() {
		$("select[data-source]").each(function() {
			var element = $(this);
			element.append('<option value="">Pilih Device</option>');
			$.ajax({
				url : element.attr("data-source")
				}).then(function(buildInTemplates) {
				buildInTemplates.map(function(match) {
					var url = $("<option>");
					url.val(match[element.attr("data-valueKey")]).text(match[element.attr("data-displayKey")]);
					element.append(url);
				});
			});
		});
	});
	
	//cek device
	$("#device").change(function() {
		var id = $(this).val();
		if(id==''){
			$('#cek_status').removeClass('btn-success');
			$('#cek_status').removeClass('btn-warning');
			$('#cek_status').addClass('btn-secondary');
			$('#cek_status').html('STATUS');
			// $('#jenis_pesan').prop('disabled', true);
			// $('#kirim_pesan').prop('disabled', true);
			return;
		}
		$.ajax({
			url: base_url + 'whatsapp/cek_status',
			method: 'POST',
			dataType:'json',
			data:{token:id},
			beforeSend: function(){
				$('body').loading();
			},
			success: function(data) {
				if(data.device_status=='connect'){
					$('#cek_status').html('CONNECTED').removeClass('btn-secondary').addClass('btn-success');
					// $('#kirim_pesan').prop('disabled', false);
					// $('#jenis_pesan').prop('disabled', false);
					}else{
					$('#cek_status').html('DISCONNECTED').removeClass('btn-success').addClass('btn-warning');
					// $('#kirim_pesan').prop('disabled', true);
					// $('#jenis_pesan').prop('disabled', true);
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
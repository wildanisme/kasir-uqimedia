<div class="row">
	<div class="col-md-12">
		<!-- Custom Tabs -->
		<div class="card">    
			<div class="card-body table-responsive">
				<table class="style-1" id="tablein">
					<thead>
						<tr>
							<th style="width:5% !important" class="text-center">No</th>
							<th class="text-center">Tanggal</th>
							<th class="text-center">Masuk</th>
							<th class="text-center">Masuk Real</th>
							<th class="text-center">Pulang</th>
							<th class="text-center">Pulang Real</th>
							<th class="text-center w-5 pr-1 pl-1">Lembur</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$tema = info();
							if(!empty($kehadiran)){
								$no=0;$i=1;
								foreach($kehadiran AS $row){
									
									$masuk = $row['masuk'];	
									if($masuk == ""){
										$masuk = "";
										}else{
										$masuk = tgl_ambil($row['masuk']) ." " . jam_koreksi($row['masuk']);
									}									
									
									$real_masuk = $row['real_masuk'];	
									if($real_masuk == ""){
										$realmasuk = "";
										}else{
										$realmasuk = tgl_ambil($row['real_masuk']) ." " . jam_koreksi($row['real_masuk']);	
									}		
									
									$pulang = $row['pulang'];	
									if($pulang == ""){
										$pulang = "";
										}else{
										$pulang = koreksi_tgl($row['pulang']);	
									}									
									
									$real_pulang = $row['real_pulang'];	
									if($real_pulang == ""){
										$realpulang = "";	
										}else{
										$realpulang = tgl_ambil($row['real_pulang']) ." " . jam_koreksi($row['real_pulang']);	
									}			
									// 13:56 Monday, June 05, 2017								
									$lembur = $row['lembur'];	
									if($lembur == 1){
										$checked = 'checked';
										}else{
										$checked = '';
									}
									 
								?>
								<tr>
									<input type="hidden" id="id<?=$no;?>" value="<?php echo $row['ID'];?>" >
									<td > 
										<?=$i;?>
									</td > 
									<td > 
										<input type="text" class="tanggal" data-id="<?php echo $row['ID'];?>" style="text-align:center;width:100px" id="tgl<?=$no;?>"  value="<?php echo tgl_ambil($row['tgl']);?>" >
									</td>											
									
									<td > 
										<input type="text" class="tgl_masuk" data-id="<?=$row['ID'];?>" style="text-align:center;width:170px" id="masuk<?=$no;?>"  value="<?php echo $masuk;?>" >
									</td>											
									
									<td > 
										<input type="text" style="text-align:center; background:#0001;width:170px" id="real_masuk<?=$no;?>"   value="<?php echo $realmasuk;?>" readonly="readonly">
									</td>
									
									<td>
										<input class="tgl_pulang" data-id="<?=$row['ID'];?>" style="text-align:center;width:170px" type="text" id="pulang<?=$no;?>"   value="<?php echo $pulang;?>" >
									</td>											
									<td>
										<input type="text" style="text-align:center; background:#0001;width:170px" id="real_pulang<?=$no;?>"  value="<?php echo $realpulang;?>" readonly="readonly">
									</td>
									<!--13:56 Monday, June 05, 2017-->
									<td>
										<div class="custom-control custom-switch">
											<input type="checkbox" name="lembur" data-id="<?=$row['ID'];?>" class="custom-control-input lembur" id="lembur<?=$no;?>" <?=$checked;?>>
											<label class="custom-control-label" for="lembur<?=$no;?>"></label>
										</div>
										
									</td>
								</tr>
								<?php  
									$i++;$no++;
								}
								}else{
								echo '<tr class="odd gradeX">
								<td colspan="9">Belum ada data</td>
								</tr>';
							} ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->  
		</div><!-- /.panel-box -->  
	</div><!-- /.panel -->  
</div><!-- /.col -->
<style>
	.style-1 th{background-color:#00664c;height:30px;border: solid 1px #dcdcdc;color:#fff}
	.style-1 td, th {
	border: 1px solid #ccc;
	text-align: center;
	height:25;
	}
	.style-1 input[type="text"] {
	padding: 0 ;
	border: 1px solid #DCDCDC;
	transition: box-shadow 0.3s ease 0s, border 0.3s ease 0s;
	}
	.style-1 input[type="text"]:focus,
	.style-1 input[type="text"].focus {
	border: solid 1px #707070;
	box-shadow: 0 0 5px 1px #969696;
	}
	
</style>
<script>
	
	var b = $("#tablein > tbody").children().length;	
	// console.log(b)
	for (var a = 0; a < b; a++) {
		$('#tgl'+a).daterangepicker({
			locale: {
				format: 'DD/MM/YYYY'
			},
			"timePicker": false,
			"singleDatePicker": true,
			"timePicker24Hour": false,
			}, function(start, end,label) {
			// console.log(a);
			// sav(a);
		});
		
		$('#masuk'+a).daterangepicker({
			locale: {
				format: 'DD/MM/YYYY HH:mm'
			},
			"timePicker": true,
			"singleDatePicker": true,
			"timePicker24Hour": true,
			}, function(start, end, label) {
			// console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		});
		
		$('#pulang'+a).daterangepicker({
			locale: {
				format: 'DD/MM/YYYY HH:mm'
			},
			"timePicker": true,
			"singleDatePicker": true,
			"timePicker24Hour": true,
			}, function(start, end, label) {
			// console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
		});
	}
	$('.tanggal').on('apply.daterangepicker', function(ev, picker) {
		var id = $(this).attr('data-id');
		var tgl = $(this).val();
		
		$.ajax({
			url: base_url+"post/save_koreksi",
			type: 'POST',
			data: {type:'tanggal',id:id,tgl:tgl},
			success: function(data) {
				if (data.status==200) {
					$('.koreksi').click()
				}
			}
		});
	});
	
	$('.tgl_masuk').on('apply.daterangepicker', function(ev, picker) {
		var id = $(this).attr('data-id');
		var tgl = $(this).val();
		
		$.ajax({
			url: base_url+"post/save_koreksi",
			type: 'POST',
			data: {type:'tgl_masuk',id:id,tgl:tgl},
			success: function(data) {
				if (data.status==200) {
					$('.koreksi').click()
				}
			}
		});
	});
	
	$('.tgl_pulang').on('apply.daterangepicker', function(ev, picker) {
		var id = $(this).attr('data-id');
		var tgl = $(this).val();
		
		$.ajax({
			url: base_url+"post/save_koreksi",
			type: 'POST',
			data: {type:'tgl_pulang',id:id,tgl:tgl},
			success: function(data) {
				if (data.status==200) {
					$('.koreksi').click()
				}
			}
		});
	});
	
	$(".lembur").change(function(e){
		var id = $(this).attr('data-id');
		if($(this).prop("checked") == true){
			lembur = 1;
			}else{
			lembur = 0;
		}
		$.ajax({
			url: base_url+"post/save_koreksi",
			type: 'POST',
			data: {type:'lembur',id:id,lembur:lembur},
			success: function(data) {
				if (data.status==200) {
					$('.koreksi').click()
				}
			}
		});
	});
</script>	
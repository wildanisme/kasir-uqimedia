<div class="table-responsive border-0">
	<table class="table card-table table-vcenter text-nowrap datatable ">
		<tbody>
			<tr class="border-0">
				<td class="border-0" style="width:10%">Nama Barang</td>
				<td class="border-0">: <strong><?=$row['title']?></strong></td>
				
				<td class="border-0" style="width:20%"><select name="divisi" id="divisi" class="form-control form-control-sm custom-select">
					<option value="0">Pilih pengguna</option>
					<?php
						foreach($divisi AS $row){
							echo "<option value=$row[id_user]>$row[nama_lengkap]</option>"; 
						}
					?>
				</select></td>
			</tr>
		</tbody>
	</table>
</div>

<input type="hidden" name="idmaster" id="idmaster" value="<?=$idmaster;?>">
<div class="clearfix"></div>
<div class="table-responsive">
	<table class="table card-table table-vcenter text-nowrap datatable" id="data">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Masuk <span class="label label-success"><span class="fa fa-plus"></span></span></th>
				<th>Keluar <span class="label label-danger"><span class="fa fa-minus"></span></span></th>
				<th>Keterangan</th>
				<th>Mutasi</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$mutasi = 0;
				foreach($item_mutasi as $tgl=>$data){
					$tgll = date("Y-m-d H:i:s",$tgl);
					$terima = "";
					if(isset($data['terima'])){
						$terima = $data['terima'];
						$mutasi += $terima;
					}
					$kirim = "";
					if(isset($data['kirim'])){
						$kirim = $data['kirim'];
						$mutasi -= $kirim;
					}
					$ket = isset($data['ket']) ? $data['ket'] : "";
					
					
					echo "
					<tr>
					<td><i class='ti ti-calendar'></i> ".indo_date($tgll,"half")."</td>
					<td>$terima</td>
					<td>$kirim</td>
					<td><em>$ket</em></td>
					<td>$mutasi</td>
					</tr>
					";
				}
			?>
			<tr>
				<td colspan=4 align="right"><strong>Stok Saat Ini</strong></td>
				<td><strong><?=$mutasi?> pcs</strong></td>
			</tr>
		</tbody>
	</table>
	 
</div>
<script>
	 
	jQuery(document).ready(function ($) {
 
	$('#data tbody').paginathing({
			perPage: 7,
			insertAfter: '#data',
			pageNumbers: false,
			ulClass: 'pagination flex-wrap justify-content-center'
		});
	});
</script>
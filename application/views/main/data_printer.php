<style>.card .table td, .card .table th {padding-right: 1rem;padding-left: 1rem;}</style>
<table class="table table-bordered table-striped table-mailcard" id="data_Table">
	<thead>
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Jenis printer</th>
			<th>Nama shared printer</th>
			<th>Ukuran Kertas</th>
			<th>Posisi</th>
			<th>Max Item</th>
			<th style="width:15%;text-align:center">Default | Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($record as $row){
				if ($row['pub'] == 1){ 
					$aktif ='<i class="fa fa-check-circle text-white change_status" data-id="'.$row['id'].'"  data-tipe="on" data-id="'.$row['pub'].'" title="Aktif"></i> ON'; 
					$info = 'warning';
					$tipe = 'on';
					$pub = $row['pub'];
					}else{ 
					$aktif = '<i class="fa fa-minus-circle text-white change_status" data-id="'.$row['id'].'"  data-tipe="off" data-id="'.$row['pub'].'" title="Nonaktif"></i> OFF'; 
					$info = 'danger';
					$tipe = 'off';
					$pub = $row['pub'];
				}
				$edit_btn = "<a class='btn btn-info btn-sm text-white edit_printer' title='Edit Data' data-id='{$row['id']}' href='#'><i class='fa fa-edit'></i> Edit</a>";
				echo "<tr><td>$no</td>
				<td><a class='btn-sm edit_printer text-success' title='Edit Data' data-id='$row[id]' href='#'>$row[name]</a></td>
				<td>$row[shared_name]</td>
				<td>$row[ukuran_kertas]</td>
				<td>$row[posisi]</td>
				<td>$row[max_item]</td>
				<td class='text-center'><div class='btn-group btn-group-sm' role='group'>
				<button type='button' class='btn btn-{$info} btn-sm change_status' data-id='{$row['id']}' data-tipe='{$tipe}' data-pub='{$pub}'><span class='icon text-white'>{$aktif}</span></button>$edit_btn
				</div></td>
				</tr>";
				$no++;
			}
		?>
	</tbody>
</table>
<script>
	var uTable;
	$(document).ready(function() {
		uTable = $('#dataPrinter').DataTable();
	});
</script>
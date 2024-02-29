<table class="table table-bordered table-striped table-mailcard" id="caraBayar">
	<thead>
		<tr>
			<th style="width:1% !important;">No</th>
			<th>Title</th>
			<th style="width:15%;text-align:center">Aktif | Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no = 1;
			foreach ($record as $row){
				if ($row['publish'] == 'Y'){ 
					$aktif ='<i class="fa fa-check-circle text-white" title="Aktif"></i> Y'; 
					$info = 'info';
					}else{ $aktif = '<i class="fa fa-minus-circle text-white" title="Nonaktif"></i> N'; 
					$info = 'danger';
				}
				$edit_btn = "<a class='btn btn-info btn-sm text-white edit_data' title='Edit Data' data-id='{$row['id']}' href='#'><i class='fa fa-edit'></i> Edit</a>";
				echo "<tr><td>$no</td>
				<td>{$row['nama_bayar']}</td>
				<td class='text-center'><div class='btn-group btn-group-sm' role='group'>
				<button type='button' class='btn btn-{$info} btn-sm ' data-id='{$row['id']}'><span class='icon text-white'>{$aktif}</span></button>$edit_btn
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
uTable = $('#caraBayar').DataTable();
});
</script>
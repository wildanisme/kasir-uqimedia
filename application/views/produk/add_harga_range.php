<tr class="table-row" id="table-row-<?php echo $id; ?>" data-id="<?php echo $satuan; ?>">
    <td><?= $a; ?></td>
	<td class="align-middle" onChange="getData(<?=$no;?>,<?=$id;?>)" >
		<select name="load_satuan_range_edit" id="load_satuan_range_<?=$no;?>" class="form-control form-control-sm" data-valueKey="id" data-displayKey="name" required>
		</select>
	</td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'jumlah_minimal','<?php echo $id; ?>')"
	onClick="editRow(this);"><?php echo $jumlah_minimal; ?></td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'jumlah_maksimal','<?php echo $id; ?>')"
	onClick="editRow(this);"><?php echo $jumlah_maksimal; ?></td>
    <td contenteditable="true" onBlur="saveToDatabase(this,'harga_jual','<?php echo $id; ?>')" onClick="editRow(this);">
	<?php echo $harga_jual; ?></td>
    <td><button class="btn btn-danger btn-sm" onclick="deleteRecord(<?php echo $id; ?>);"><i class="fa fa-remove"></i>
	Hapus</button></td>
</tr>
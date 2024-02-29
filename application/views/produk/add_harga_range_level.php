<tr class="table-row" id="table-row-level-<?php echo $id; ?>" data-satuan="<?php echo $satuan; ?>">
	<td><?= $a; ?></td>
	<td onChange="getData(<?= $no; ?>,'<?php echo $id; ?>')">
		<select name="load_satuan_range_edit" id="load_satuan_range_level_<?= $no; ?>"
		class="form-control form-control-sm" data-valueKey="id" data-displayKey="name" required>
		</select>
	</td>
	<td onChange="getLevel(<?= $no; ?>,'<?php echo $id; ?>')">
		<select name="load_level_edit" id="load_level_range_<?= $no; ?>" class="form-control form-control-sm"
		data-valueKey="id" data-displayKey="name" required>
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
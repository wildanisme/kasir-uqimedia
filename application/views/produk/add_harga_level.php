<tr class="table-row" id="table-level-<?php echo $id; ?>" data-id="<?php echo $satuan; ?>">
	<td><?= $no; ?></td>
	<td onChange="getData(<?= $a; ?>,'<?php echo $id; ?>')">
		<select name="load_satuan_edit" id="satuan_level_<?= $a; ?>" class="form-control form-control-sm"
		data-valueKey="id" data-displayKey="name" required>
		</select>
	</td>
	<td onChange="getLevel(<?= $a; ?>,'<?php echo $id; ?>')">
		<select name="load_level_edit" id="load_level_<?= $a; ?>" class="form-control form-control-sm"
		data-valueKey="id" data-displayKey="name" required>
		</select>
	</td>
	<td contenteditable="true" onBlur="saveToDatabase(this,'harga_jual','<?php echo $id; ?>')" onClick="editRow(this);">
	<?php echo $harga_jual; ?></td>
	<td><button class="btn btn-danger btn-sm" onclick="deleteRecord(<?php echo $id; ?>);"><i class="fa fa-remove"></i>
	Hapus</button></td>
</tr>
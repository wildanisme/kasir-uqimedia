<style>
	.tbl-qa{width: 98%;font-size:0.9em;background-color: #f5f5f5;}
	.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;}
	.tbl-qa .table-row td {background-color: #bfcfffn;}
	.ajax-action-links {color: #09F; margin: 10px 0px;cursor:pointer;}
	.ajax-action-button {border:#094 1px solid;color: #09F; margin: 10px 0px;cursor:pointer;display: inline-block;padding: 10px 20px;}
	.edited td {padding:5px!important;background:#f7f7f7}
</style>

<div class="table-wrapper">
	
	<table class="table table-bordered tbl-qa" id="table_satuan">
		<thead>
			<tr>
				<th class="align-middle text-center w-5">No.</th>
				<th class="align-middle w-15">Satuan</th>
				<th class="align-middle">Harga Beli</th>
				<th class="align-middle">Harga Jual</th>
				<th class="align-middle text-left w-18"><button class="btn btn-info btn-sm flat" id="add-satuan" onClick="createNew();"><i class="fa fa-plus"></i> Tambah</button></th>
			</tr>
		 
			<tr>
				<td class="align-middle text-center">#</td>
				<td class="align-middle text-left">
					<select class="form-control form-control-sm flat" disabled>
						<option><?=get_satuan($bahan->id_satuan);?></option>
					</select>
				</td>
				<td class="align-middle"><?=rp($bahan->harga_modal);?></td>
				<td class="align-middle" ><?=rp($bahan->harga_jual);?></td>
				<td class="align-middle">Default</td>
			</tr>
		</thead>
		<tbody id="table-satuan">
			
			<?php 
				$a = 0;
				$no = 1;
				foreach($result AS $row) {
					$id=$row->id; 
					$satuan=$row->id_satuan; 
					$harga_pokok=$row->harga_pokok; 
					$harga_jual=$row->harga_jual; 
					
				?>
				<tr class="table-row" id="table-satuan-<?php echo $id; ?>" data-id="<?php echo $satuan; ?>" data-row="<?php echo $a; ?>">
					<td class="align-middle text-center"><?=$no;?></td>
					<td class="align-middle text-center" onChange="getData(<?=$a;?>,<?=$id;?>)" >
						<select name="load_satuan_edit" id="load_satuan_<?=$a;?>" class="form-control form-control-sm flat" data-valueKey="id" data-displayKey="name" required>
						</select>
					</td>
					<td class="align-middle" contenteditable="true" onBlur="saveToDatabase(this,'harga_pokok','<?php echo $id; ?>')" onClick="editRow(this);"><?php echo $harga_pokok; ?></td>
					<td class="align-middle" contenteditable="true" onBlur="saveToDatabase(this,'harga_jual','<?php echo $id; ?>')" onClick="editRow(this);"><?php echo $harga_jual; ?></td>
					<td class="align-middle"><button class="btn btn-danger btn-sm flat" onclick="deleteRecord(<?php echo $id; ?>);"><i class="fa fa-remove"></i> Hapus</button></td>
				</tr>
			<?php $a++;$no++;} ?>     
		</tbody>
	</table>
	
	<input type="hidden" id="id_bahan" value="<?=$id_bahan;?>">
</div>

<script type="text/javascript">
	var satuan_add = "<?=$bahan->id_satuan;?>";
	var harga_modal = "<?=$bahan->harga_modal;?>";
	function createNew() {
		$("#add-satuan").hide();
		no = $('#table_satuan > tbody tr').length+1;
		i = $('#table_satuan > tbody tr').length;
		var data = '<tr class="table-row" id="new_row_satuan">' +
		'<td class="align-middle text-center">'+no+'</td><td><select name="load_satuan_add" id="load_satuan_'+i+'" class="form-control form-control-sm flat" data-valueKey="id" data-displayKey="name" required></select></td>'
		data +='<td class="align-middle" contenteditable="true" id="txt_harga_jual" onBlur="addToHiddenField(this,\'harga_beli\')" onClick="editRow(this);">'+harga_modal+'</td>';
		data +='<td class="align-middle" contenteditable="true" id="txt_harga_jual" onBlur="addToHiddenField(this,\'harga_jual\')" onClick="editRow(this);"></td>';
		data +='<td class="align-middle"><div class="input-group input-group-sm flat">';
		data +='<div class="input-group-append" id="confirmAdd">';
		data +='<button onClick="addToDatabase('+i+')" class="btn btn-success flat" type="button"><i class="fa fa-save"></i> Simpan</button>';
		data +='<button onclick="cancelAdd();" class="btn btn-warning flat" type="button" ><i class="fa fa-remove"></i> Batal</button><input type="hidden" id="id_satuan" /> <input type="hidden"  id="harga_pokok" /><input type="hidden" id="harga_jual" />';
		data +='</div></div></td>';
		data +='</tr>';
		$("#table-satuan").append(data);
		satuan_load(i,satuan_add)
	}
	
	function cancelAdd() {
		$("#add-satuan").show();
		$("#new_row_satuan").remove();
	}
	function editRow(editableObj) {
		$(editableObj).css("background","#FFF");
	}
	
	function addToDatabase(i) {
		var satuan = $("#load_satuan_"+i).val();
		var harga_pokok = angka($("#harga_pokok").val());
		var harga_jual = angka($("#harga_jual").val());
		var id_bahan = $("#id_bahan").val();
		if(satuan==''){
			return;
		}
		var no = i+1;
		$("#confirmAdd").html('<img src="'+base_url+'assets/img/ajax-loader.gif" />');
		$.ajax({
			url: base_url+"produk/add_satuan_harga",
			type: "POST",
			data:{id:id_bahan,satuan:satuan,harga_pokok:harga_pokok,harga_jual:harga_jual,no:no,row:i},
			success: function(data){
				$("#new_row_satuan").remove();
				$("#add-satuan").show();		  
				$("#table-satuan").append(data);
				satuan_load(i,satuan);
			}
		});
	}
	function addToHiddenField(addColumn,hiddenField) {
		var columnValue = $(addColumn).text();
		$("#"+hiddenField).val(columnValue);
	}
	function getData(a,id) {
		// console.log(id);
		var id_satuan = $("#load_satuan_"+a).val();
		saveToDatabase(id_satuan,'id_satuan',id)
	}
	function saveToDatabase(editableObj,column,id) {
		$(editableObj).css("background","#FFF url("+base_url+"assets/img/ajax-loader.gif) no-repeat right");
		if($.isNumeric(editableObj)){
			var editval = editableObj;
			}else{
			var editval = $(editableObj).text();
		}
		$.ajax({
			url: base_url+"produk/edit_harga_satuan",
			type: "POST",
			data:'column='+column+'&editval='+editval+'&id='+id,
			success: function(data){
				if(!$.isNumeric(editableObj)){
					$(editableObj).css("background","#F5F5F5");
				}
			}
		});
	}
	
	function deleteRecord(id) {
		if(confirm("Are you sure you want to delete this row?")) {
			$.ajax({
				url: base_url+"produk/delete_harga_satuan",
				type: "POST",
				data:'id='+id,
				success: function(data){
					$("#table-satuan-"+id).remove();
				}
			});
		}
	}
	
	document.querySelectorAll('#table_satuan > tbody tr').forEach(trObj => {
		var tableValue = trObj.id;
		
		var result = tableValue.split('-');
		var data = 	$('#'+tableValue).attr('data-row');
		var idsatuan = 	$('#'+tableValue).attr('data-id');
		satuan_load(data,idsatuan);
		// console.log(idsatuan)
		// console.log(result[2])
	});
	
	function satuan_load(tipe,idjenis){
		
		$.ajax({
			url: base_url + "produk/load_satuan_range",
			type: 'POST',
			data: {id:idjenis},
			dataType: 'json',
			beforeSend: function () {
				$("#load_satuan_"+tipe).append("<option value='loading'>loading</option>");
				$("#load_satuan_"+tipe).empty();
			},
			success: function (response) {
				// $("#jenis_lembaga_"+jenis+" option[value='loading']").remove();
				$("#load_satuan_"+tipe).append("<option value=''>Pilih</option>");
				var len = response.length;
				for (var i = 0; i < len; i++) {
					var id = response[i]['id'];
					var name = response[i]['name'];
					if(id==idjenis){
						$("#load_satuan_"+tipe).append("<option value='" + id + "' selected>" + name + "</option>");
						}else{
						$("#load_satuan_"+tipe).append("<option value='" + id + "'>" + name + "</option>");
					}
					
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				sweet('Peringatan!!!',thrownError,'warning','warning');
			}
		});
	}
</script>


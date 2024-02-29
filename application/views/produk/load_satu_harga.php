<h5>SATU HARGA</h5>
<div class="form-group row mb-1">
	<label for="load_satuan" class="col-sm-3 col-form-label">Satuan Dasar</label>
	<div class="col-sm-6">
		<select name="load_satuan" id="satuan_load" class="custom-select form-control input-sm flat"  onchange="save_satu_harga()" required>
			<?php foreach($satuan AS $val):
				if($val->id == $bahan->id_satuan){
					$selected = 'selected';
					}else{
					$selected = '';
				}
			?>
			<option value="<?=$val->id;?>" <?=$selected;?>><?=$val->satuan;?></option>
			<?php endforeach; ?>
		</select>
	</div>
</div>
<div class="form-group row mb-1">
	<label for="harga_beli" class="col-sm-3 col-form-label">Harga Beli</label>
	<div class="col-sm-6">
		<input type="text" name="harga_beli" id="harga_beli" value="<?=!empty($row->harga_beli) ? rp($row->harga_beli) : rp($bahan->harga_modal);?>" class="form-control input-sm flat" onchange="hitung()" onkeyup='formatNumber(this)' required>
	</div>
</div>
<div class="form-group row mb-1">
	<label for="harga_pokok" class="col-sm-3 col-form-label">Harga Pokok</label>
	<div class="col-sm-6">
		<input type="text" name="harga_pokok" id="harga_pokok" value="<?=!empty($row->harga_pokok) ? rp($row->harga_pokok) : rp($bahan->harga);?>" class="form-control input-sm flat" onchange="hitung()" onkeyup='formatNumber(this)' required>
	</div>
</div>
<div class="form-group row mb-0">
	<label for="hpp" class="col-sm-3 col-form-label">Harga Pokok </label>
	<div class="col-sm-6">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<form name="add_name" id="add_name">
						<input type="hidden" id="id_bahan" name="id_bahan" value="<?=$id_bahan;?>" required />
						<table class="table table-bordered table-hover" id="dynamic_field">
							<tr>
								<th class="align-middle">Title</th>
								<th class="align-middle">Harga</th>
								<th><button type="button" name="add" id="add" class="btn btn-primary btn-sm flat"><i class="fa fa-plus"></i></button></th>
							</tr>
							 
								<?php 
									$total_hpp = 0; 
									if(!empty($detail_hpp)){
										$na = 0; 
										foreach($detail_hpp->data AS $key=>$val) {
											if($val->id==0){
												$readonly = 'disabled';
												}else{
												$readonly = '';
											}
											$total_hpp += $val->harga;
										?>
										<tr id='rowCountDetail<?=$na;?>' class="rowCountFinish" >
											<td>
												 
													<input class="form-control input-sm flat" type='text' id='title_<?=$na;?>' name="title[<?=$na;?>]" value="<?=$val->title;?>" required />
													<input type="hidden" id="id_detail_<?=$val->id;?>" name="id_detail[<?=$na;?>]" value="<?=$val->id;?>" required />
											 
											</td>
											<td>
												 
													<input class="form-control input-sm text-right flat text-right" type='text' id='harga_<?=$na;?>' name="harga[<?=$na;?>]" value="<?=rp($val->harga);?>" onkeyup="formatNumber(this);sum_harga()" required />
										 
											</td>
											<td><button type="button" name="remove" id="<?=$na;?>" class="btn btn-danger btn-sm flat btn_remove" <?=$readonly;?>>X</button></td> 
										</tr>
										<?php $na++; 
										}  }else{ ?>
										<tr>
											<td><input type="hidden" id="id_detail_0" name="id_detail[0]" value="0" /><input type="text" name="title[]" class="form-control input-sm flat" required /></td>
											<td><input type="text" name="harga[]" value="" id="harga_0" class="form-control input-sm text-right flat" onkeyup="formatNumber(this);sum_harga()" required /></td>
										</tr>
								<?php } ?>
						 
							<tfoot>
								<tr>
									<td class="align-middle">Total HPP</td>
									<td><input type="text" name="total_hpp"  id="total_hpp" value="<?=rp($total_hpp);?>" class="form-control input-sm flat text-right" readonly /></td>
									<td class="align-middle"><button type="submit" class="btn btn-success btn-sm flat" name="submit" id="submit_hpp"  title="Update"><i class="fa fa-refresh"></i></button></td>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="form-group row mb-1">
	<label for="persen" class="col-sm-3 col-form-label">Margin</label>
	<div class="col-sm-6">
		<div class="input-group input-group-sm flat">
			<input type="number" name="persen" id="persen" value="<?=!empty($row->persen) ? $row->persen : 0;?>" class="form-control input-sm flat" onchange="hitung()" min="0" required>
			<div class="input-group-append flat">
				<span class="input-group-text flat">%</span>
			</div>
		</div>
	</div>
	
</div>
<div class="form-group row">
	<label for="harga_jual" class="col-sm-3 col-form-label">Harga Jual</label>
	<div class="col-sm-6">
		<input type="text" name="harga_jual" id="harga_jual" value="<?=!empty($row->harga_jual) ? rp($row->harga_jual) : 0;?>"  class="form-control input-sm flat" onchange="save_satu_harga()" required readonly>
	</div>
</div>
<script>
	
	$(document).ready(function() {
		 
		$('input').click(function() {
			this.select();
		});
	});
	
	$(document).ready(function(){
		$("#add").click(function(){
			var i = $("#dynamic_field > tbody").children().length - 1;
			 var cols = '<tbody id="tbody'+i+'">';
			cols +='<tr id="rowCountDetail'+i+'"><td><input type="hidden" id="id_detail_'+i+'" name="id_detail['+i+']" value="'+i+'" /><input type="text" name="title['+i+']" id="title_'+i+'" class="form-control input-sm flat " required /></td><td><input type="text" name="harga['+i+']" id="harga_'+i+'" value=""  class="form-control input-sm text-right flat" onkeyup="formatNumber(this);sum_harga()"  required /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm flat btn_remove">X</button></td></tr>'; 
			cols += "</tbody>";
			$('#dynamic_field').append(cols);
			i++;
		});
		
		$(document).on('click', '.btn_remove', function(){  
			var button_id = $(this).attr("id");     
			$('#rowCountDetail'+button_id+'').remove();  
			$('#tbody'+button_id+'').remove();  
			sum_harga()
		});
		
		
		$("#add_name").submit(function(event) {
			
			var formdata = $("#add_name").serialize();
			// console.log(formdata);
			
			event.preventDefault()
			
			$.ajax({
				url   : base_url+"produk/update_hpp",
				type  :"POST",
				data  :formdata,
				cache :false,
				success:function(result){
					showNotif('bottom-right','Update Harga','sukses','success');
					hitung();
					save_satu_harga();
				}
			});
			
		});
	});
	
	function sum_harga() {
		// var str = $("#id_invoice").val();
		
		var harga_pokok = angka($("#harga_pokok").val());
		var persen = angka($("#persen").val());
		var b = $("#dynamic_field > tbody").children().length - 1;	
		var total_jual = 0;
		var jum_hpp = 0;
		var r = 0;
		var total_harga_hpp = [];
		for (; r < b; r++) {
			var harga = angka($("#harga_" + r).val());
			total_harga_hpp[r] = parseInt(harga);
			jum_hpp = jum_hpp + parseInt(total_harga_hpp[r]);
			
		}
		if(persen > 0){
			total_persen = (parseInt(jum_hpp) * parseInt(persen)) / 100;
			total_jual = parseInt(harga_pokok) + jum_hpp + total_persen;
			}else{
			total_jual = parseInt(harga_pokok) + jum_hpp;
		}
		$("#total_hpp").val(formatMoney(jum_hpp, 0, "Rp."));
		// $("#harga_jual").val(formatMoney(total_jual, 0, "Rp."));
		
	}
</script>								
<?php
	if($id==2){
		
	?>
	<div class="form-group row">
		<label class="col-md-4">Jumlah</label>
		<div class="col-md-8">
			<input type="text" class="form-control input-sm" name="start">
		</div>
	</div>
	<div class="input-group input-group-sm">
		<span class="input-group-text input-sm">P</span>
		<input type="text" class="form-control" name="start">
		<div class="input-group-prepend">
			<span class="input-group-text input-sm">X</span>
		</div>
		<input type="text" class="form-control" name="end">
		<span class="input-group-text input-sm">L</span>
	</div>
	<div class="form-group row mt-3">
		<label class="col-md-4">Pilih Ukuran Bahan</label>
		<div class="col-md-8">
			<select name="ukuran" id="ukuran" class="form-control custom-select input-sm" required>
				<option value="1">Art Paper 65x100 cm</option>
				<option value="2">P X L</option>
				<option value="3">P X L X T</option>
				<option value="0" selected>Tidak</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-4">Total Bahan</label>
		<div class="col-md-8">
			<input type="text" class="form-control input-sm" name="total_bahan" readonly>
		</div>
	</div>
	
	<div class="form-group row">
		<label class="col-md-4">Total Potongan</label>
		<div class="col-md-8">
			<input type="text" class="form-control input-sm" name="total_potongan" readonly>
		</div>
	</div>
	<button type="submit" class="btn btn-info btn-sm">Hitung Potongan</button>
	<?php } 
	if($id==3)
	{
	?>
	<div class="input-group input-group-sm">
		<span class="input-group-text input-sm">P</span>
		<input type="text" class="form-control" name="start">
		<div class="input-group-prepend">
			<span class="input-group-text">X</span>
		</div>
		<input type="text" class="form-control" name="end">
		<span class="input-group-text input-sm">L</span>
		<div class="input-group-prepend">
			<span class="input-group-text input-sm">X</span>
		</div>
		<input type="text" class="form-control" name="end">
		<span class="input-group-text input-sm">T</span>
	</div>
	<div class="form-group mt-2">
		<label>Pilih Ukuran Bahan</label>
		<select name="ukuran" id="ukuran" class="form-control custom-select" required>
			<option value="1">Art Paper 65x100 cm</option>
			<option value="2">P X L</option>
			<option value="3">P X L X T</option>
			<option value="0" selected>Tidak</option>
		</select>
	</div>
	<div class="form-group">
		<label>Total Bahan</label>
		<input type="text" class="form-control input-sm" name="end">
	</div>
	<div class="form-group">
		<label>Total Potongan</label>
		<input type="text" class="form-control input-sm" name="end">
	</div>
	<button type="submit" class="btn btn-info btn-sm">Hitung Potongan</button>
<?php } ?>
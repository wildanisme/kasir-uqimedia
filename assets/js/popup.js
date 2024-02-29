/** @type {string} */
var newURL = window.location.protocol + "//" + window.location.host + window.location.pathname + window.location.search;
/** @type {!Array<string>} */
var pathArray = newURL.split("/");
/** @type {number} */
var len = pathArray.length;
if (location.hostname === "localhost" || location.hostname === "127.0.0.1" || location.hostname === my_ip) {
	if (len > 5) {
		/** @type {string} */
		var url = window.location.protocol + "//" + window.location.host + "/" + pathArray[3] + "/" + pathArray[4] + "/" + pathArray[5];
		} else {
		/** @type {string} */
		url = window.location.protocol + "//" + window.location.host + "/" + pathArray[3] + "/" + pathArray[4];
	}
	} else {
	if (len > 4) {
		/** @type {string} */
		url = window.location.protocol + "//" + window.location.host + "/" + pathArray[3] + "/" + pathArray[4];
		} else {
		/** @type {string} */
		url = window.location.protocol + "//" + window.location.host + "/" + pathArray[3];
	}
}
$("li.nav-item a").filter(function() {
	return this.href == url;
}).parentsUntil(".sidebar > .nav-link collapsed").addClass("active");
$("li.nav-item a").filter(function() {
	return this.href == url;
}).closest(".collapse").addClass("show");
$(".collapse-item").filter(function() {
	return this.href == url;
	}).closest("a").siblings().removeClass("active").end().addClass("active").css({
	display : "block"
});

function load_jenis_batal(){
    $.ajax({
        url: base_url + "pembayaran/jenis_pembayaran",
        type: 'GET',
        dataType: 'json',
        beforeSend: function () {
            $("#id_byrbatal").append("<option value='loading'>loading</option>");
            $("#id_byrbatal").empty();
		},
        success: function (response) {
            $("#id_byrbatal option[value='loading']").remove();
            $("#id_byrbatal").append("<option value=''>Pilih</option>");
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#id_byrbatal").append("<option value='" + id + "'>" + name + "</option>");
			}
		}
	});
}

/** @type {(Element|null)} */
var dengan_rupiah = document.getElementById("uangm");
dengan_rupiah.addEventListener("keyup", function() {
	dengan_rupiah.value = formatRupiah(this.value, "Rp.");
});
var diskon_rupiah = document.getElementById("total_diskon");
diskon_rupiah.addEventListener("keyup", function() {
	diskon_rupiah.value = formatRupiah(this.value, "Rp.");
});
$("#sumber_kas_batal").attr("disabled",true);
$("#rekening_bayar").attr("disabled",true);
$("#saldo_kas_batal").val("Rp.0");
$("#id_byrbatal").filter(function() {
    $('select[data-source]').each(function() {
        var $select = $(this);
        $select.append('<option value="0">Pilih</option>');
        $.ajax({
            url: $select.attr('data-source'),
            }).then(function(options) {
            options.map(function(option) {
                var $option = $('<option>');
                $option.val(option[$select.attr('data-valueKey')]).text(option[$select.attr('data-displayKey')]);
                $select.append($option);
			});
		});
	});
});

$("#id_byrbatal" ).change(function() {
    var id = $("#id_byrbatal").val();
    $('#sumber_kas_batal').attr('disabled',false);
    $('.rekening').attr('disabled',true);
    $("#rekening_bayar").empty();
    if(id==2){
        $("#rekening_bayar").attr('required',true);
        $.ajax({
            url: base_url + "pembayaran/get_rekening",
            type: 'post',
            data: {type:'cari'},
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $(".rekening").attr("disabled", false);
                $("#rekening_bayar").append("<option value=''>Pilih rekening</option>");
                for (var i = 0; i < len; i++) {
                    var id = response[i]['id'];
                    var name = response[i]['name'];
                    $("#rekening_bayar").append("<option value='" + id + "'>" + name + "</option>");
				}
			},
            error: function (xhr, ajaxOptions, thrownError) {
                sweet('Peringatan!!!',thrownError,'warning','warning');
			}
		});
        }else if(id==1){
        $("#rekening_bayar").append("<option value=''>Pilih rekening</option>");
        }else{
        $("#rekening_bayar").attr('required',false);
        // $('.bayar_l').attr('disabled',true);
	}
});
$("#id_byrbatal" ).change(function() {
    var id = $("#id_byrbatal").val();
    $('.sumber_kas_batal').attr('disabled',true);
    $('.jatuh_tempo').attr('disabled',true);
    $("#sumber_kas_batal").empty();
    $.ajax({
        url: base_url + "pengeluaran/jenis_kas",
        type: 'post',
        data: {id:id,type:'cari'},
        dataType: 'json',
        success: function (response) {
            var len = response.length;
            $(".sumber_kas_batal").attr("disabled", false);
            $("#sumber_kas_batal").append("<option value=''>Pilih</option>");
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var name = response[i]['name'];
                $("#sumber_kas_batal").append("<option value='" + id + "'>" + name + "</option>");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			sweet('Peringatan!!!',thrownError,'warning','warning');
		}
	});
    if(id==3){
        $('.jatuh_tempo').attr('disabled',false);
	}
    
});

$("#jenis_lembaga_edit" ).change(function() {
    var id = $("#jenis_lembaga_edit").val();
    if(id > 1){
        $(".tampil_lembaga").show();
        $("#nama_perusahaan_edit").attr("required", false);
        $("#alamat_perusahaan_edit").attr("required", false);
        $("#no_telp_edit").attr("required", false);
        }else{
        $(".tampil_lembaga").hide();
        $("#nama_perusahaan_edit").attr("required", false);
        $("#alamat_perusahaan_edit").attr("required", false);
        $("#no_telp_edit").attr("required", false);
	}
});
$("#jenis_lembaga_add" ).change(function() {
    var id = $("#jenis_lembaga_add").val();
    if(id > 1){
        $(".tampil_add").show();
        $("#perusahaan_add").attr("required", true);
        $("#alamat_perusahaan_add").attr("required", true);
        $("#no_telp_add").attr("required", true);
        $("#perusahaan_add").attr("data-mfindex", 6);
        $("#alamat_perusahaan_add").attr("data-mfindex", 7);
        $("#no_telp_add").attr("data-mfindex", 8);
        $("#tampil_data").attr("data-mfindex", 9);
        $("#via_add").attr("data-mfindex", 10);
        $("#status_add").attr("data-mfindex", 11);
        $("#max_u_add").attr("data-mfindex", 11);
        }else{
        $(".tampil_add").hide();
        $("#perusahaan_add").attr("required", false);
        $("#alamat_perusahaan_add").attr("required", false);
        $("#no_telp_add").attr("required", false);
        $("#perusahaan_add").attr("data-mfindex", '');
        $("#alamat_perusahaan_add").attr("data-mfindex", '');
        $("#no_telp_add").attr("data-mfindex", '');
        $("#tampil_data").attr("data-mfindex", '');
        $("#via_add").attr("data-mfindex", 6);
        $("#status_add").attr("data-mfindex", 7);
        $("#max_u_add").attr("data-mfindex", 8);
	}
});

$("#rekening_bayar" ).change(function() {
	$("#sumber_kas_batal" ).change();
});
$("#sumber_kas_batal" ).change(function() {
    var id_via = $("#id_byrbatal").val();
    var id_rek = $("#rekening_bayar").val();
    var id = $("#sumber_kas_batal").val();
    $.ajax({
        url:  base_url+"kas/kas_batal",
        data:{id_via:id_via,id_rek:id_rek,id:id},
        dataType: "json",
        method: 'post',
        success: function (data) {
            $('#saldo_kas_batal').val(formatMoney(data,0,"Rp."));
		},
		error: function (xhr, ajaxOptions, thrownError) {
			sweet('Peringatan!!!',thrownError,'warning','warning');
		}
	});
});

$("#telepon_add").keyup(function(event){
    var tlpadd = $("#telepon_add").val();
    tlpstart = tlpadd.trim();
    $("#telepon_add").val(tlpstart);
    
});
$(document).on('click', '.tambah2', function() {
    var dataID = $(this).attr('data-id');
    $('.tampil_add').hide();
    load_jenis_lembaga('add',1);
    load_jenis_member('add',1);
    if(dataID == 0){
        $("#nama_add").val('');
        $("#panggilan_add").val('');
        $("#telepon_add").val('');
        $("#alamat_add").val('');
        $("#perusahaan_add").val('');
        $("#alamat_perusahaan_add").val('');
        $("#no_telp_add").val('');
        $("#status_add").val('0');
        $("#max_u_add").val('0');
        $("#via_add").val('build');
        $("#type_add").val('add_on_pelanggan');
	}
    // console.log(dataID);
    $('#modal-tambah-1').modal({backdrop: 'static', keyboard: false});
    
    setTimeout(function (){
        $('#telepon_add').focus();
	}, 1000);
});

function load_jenis_lembaga(jenis,idjenis){
    $('.tampil_lembaga').hide();
	$.ajax({
		url: base_url + "konsumen/jenis_lembaga",
		type: 'POST',
		dataType: 'json',
		beforeSend: function () {
			$("#jenis_lembaga_"+jenis).append("<option value='loading'>loading</option>");
			$("#jenis_lembaga_"+jenis).empty();
		},
		success: function (response) {
            // $("#jenis_lembaga_"+jenis+" option[value='loading']").remove();
            $("#jenis_lembaga_"+jenis).append("<option value=''>Pilih</option>");
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var name = response[i]['name'];
                if(id==idjenis){
                    $("#jenis_lembaga_"+jenis).append("<option value='" + id + "' selected>" + name + "</option>");
                    }else{
                    $("#jenis_lembaga_"+jenis).append("<option value='" + id + "'>" + name + "</option>");
				}
                
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			sweet('Peringatan!!!',thrownError,'warning','warning');
		}
	});
}
function load_jenis_member(jenis,idjenis){
	$.ajax({
		url: base_url + "konsumen/jenis_member",
		type: 'POST',
		data: {status:jenis},
		dataType: 'json',
		beforeSend: function () {
			$("#jenis_member_"+jenis).append("<option value='loading'>loading</option>");
			$("#jenis_member_"+jenis).empty();
		},
		success: function (response) {
			// console.log(response)
            $("#jenis_member_"+jenis).append("<option value=''>Pilih</option>");
            var len = response.length;
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var name = response[i]['name'];
                if(id==idjenis){
                    $("#jenis_member_"+jenis).append("<option value='" + id + "' selected>" + name + "</option>");
                    }else{
                    $("#jenis_member_"+jenis).append("<option value='" + id + "'>" + name + "</option>");
				}
                
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			sweet('Peringatan!!!',thrownError,'warning','warning');
		}
	});
}
var isTimeout;
var isLoaded;

function success() {
    if (isTimeout) {
        return;
	}
    
    $('#loading').hide();
    $('iframe').show();
    isLoaded = true;
};

setTimeout(function() {
    if (isLoaded) {
        return;
	}
    $('#loading').hide();
    $('iframe').hide();
    $('#error').show();
    $('#error').css('display','flex');
    isTimeout = true;
}, 100000);

$("#telepon_add").change(function() {
    var idinvoice = $("#idnya").val();
    idinvoice = idinvoice?idinvoice:0;
    var telp = $('#telepon_add').val();
    var type_add = $('#type_add').val();
    if (telp.length <= 9) {
        $("#dispu").html("<img src='" + base_url + "assets/img/ajax-loader.gif' data-toggle='tooltip' title='cek data'/>");
        } else {
        $.ajax({
            url: base_url + "konsumen/cek_telp",
            data: { telp: telp,type_add:type_add },
            type: "POST",
            dataType: "json",
            success: function(respon) {
                if (respon[0] == 'ada') {
                    if(idinvoice >0){
                        $("#dispu").html("<a href='#' class='btn btn-info btn-sm cariada' data-toggle='tooltip' data-placement='left' title='Pilih' data-idkon='" + respon.idnya + "' data-idin='" + idinvoice + "' data-idTelp='" + telp + "'><i class='fa fa-user-plus'></i></a><a href='#' class='btn btn-danger btn-sm clearada' data-toggle='tooltip' data-placement='left' title='Clear' onclick='resetForm()'><i class='fa fa-user-times'></i></a>");
                        }else{
                        $("#dispu").html("<a href='#' class='btn btn-danger btn-sm clearada' data-toggle='tooltip' data-placement='left' title='Clear' onclick='resetForm()'><i class='fa fa-user-times'></i></a>");
					}
                    $('#panggilan_add,#nama_add,#telepon_add,#alamat_add,#perusahaan_add,#jenis_lembaga_add,#jenis_member_add,#alamat_perusahaan_add,#no_telp_add,#tampil_data,#via_add,#save-cari,#status_add,#max_u_add').prop('disabled', true);
                    if(respon.jenis > 1){
                        $('.tampil_add').show();
                        }else{
                        $('.tampil_add').hide();
					}
                    $("#jenis_lembaga_add").val(respon.jenis);
                    $("#jenis_member_add").val(respon.jenis_member);
                    $("#panggilan_add").val(respon.panggilan);
                    $("#nama_add").val(respon.nama);
                    $("#alamat_add").val(respon.alamat);
                    $("#perusahaan_add").val(respon.perusahaan);
                    $("#alamat_perusahaan_add").val(respon.alamat);
                    $("#no_telp_add").val(respon.perusahaan);
                    $("#via_add").val(respon.reff);
                    $('#errore').hide();
                    } else if (respon.status == 400) {
                    sweet('Peringatan!!!',respon.msg,'warning','warning');
                    $('#dispu').hide();
                    $("#telepon_add").val('');
                    } else if (respon[0] == 'notelp') {
                    $("#errore").fadeIn(1000, function() {
                        $("#errore").html('<div class="alert alert-warning"> <span class="glyphicon glyphicon-info-sign"></span>No. telp harus berawalan 08/628/+628</div>');
					});
                    } else {
                    $("#telepon_add").val(respon.msg);
                    $("#dispu").html("<button type='button' class='btn btn-success btn-sm takada' data-toggle='tooltip' data-placement='left' title='No. belum ada'><i class='fa fa-user'></i></button>");
                    $('#panggilan_add,#nama_add,#telepon_add,#alamat_add,#perusahaan_add,#jenis_lembaga_add,#jenis_member_add,#alamat_perusahaan_add,#no_telp_add,#via,#save-cari,#status_add,#max_u_add').prop('disabled', false);
                    $('#errore').hide();
				}
                
			},
            error: function (xhr, ajaxOptions, thrownError) {
                sweet('Peringatan!!!',thrownError,'warning','warning');
			}
		});
        return false;
	}
});

function searchFilterKonsumen(page_num){
    page_num = page_num?page_num:0;
    var keywords = $('#keywords').val();
    var sortBy = $('#sortBy').val();
    var limits = $('#limits').val();
    var urlnya = base_url + "konsumen/ajaxKonsumen/"+page_num
    $.ajax({
        type: 'POST',
        url: urlnya,
        data:{page:page_num,keywords:keywords,sortBy:sortBy,limits:limits},
        beforeSend: function(){
            $('body').loading();
		},
        success: function(html){
            $('#dataListKonsumen').html(html);
            $('body').loading('stop');
		},
        error: function(xhr, status, error) {
            var err = xhr.responseText ;
            sweet('Server!!!',err,'error','danger');
            $('body').loading('stop');
		}
	});
}
$(document).on('click', '.edit_konsumen', function(e) {
    e.preventDefault();
    var dataID = $(this).attr('data-id');
    var jenis = $(this).attr('data-jenis');
    var member = $(this).attr('data-member');
	
    load_jenis_lembaga('edit',jenis);
    load_jenis_member('edit',member);
    $.ajax({
        'url': base_url + 'konsumen/cek_konsumen',
        'data': {id: dataID},
        'method': 'POST',
        dataType: 'json',
        beforeSend: function(){
            $('body').loading({zIndex:1070});
		},
        success: function(data) {
            if(data.status==200){
                if(level!='admin')
                {
                    $('.update_data').attr('disabled',true);
				}
                
                if(data.jenis>1){
                    $('.tampil_lembaga').show();
                    }else{
                    $('.tampil_lembaga').hide();
				}
                $('#modal-edit-konsumen').modal('show');
                $('#error_piutang').css('display','none');
                $("#id_edit").val(data.id);
                $("#panggilan_edit").val(data.panggilan);
                $("#telepon_edit").val(data.nohp);
                $("#nama_edit").val(data.nama);
                $("#alamat_edit").val(data.alamat1);
                $("#jenis_lembaga_edit").val(data.jenis);
                $("#nama_perusahaan_edit").val(data.perusahaan);
                $("#alamat_perusahaan_edit").val(data.alamat2);
                $("#no_telp_edit").val(data.no_telp);
                $("#via_edit").val(data.via);
                $("#tampil_edit").val(data.tampil);
                $("#status_edit").val(data.boleh);
                $("#max_u").val(data.max);
                $('body').loading('stop');
                }else if(data.status==401){
                sweet('Login Status!!!',data.msg,'error','danger');
                $('body').loading('stop');
			}
		},
        error: function(xhr, status, error) {
            var err = xhr.responseText ;
            sweet('Server!!!',err,'error','danger');
            $('body').loading('stop');
		}
	})
});
$("#status_add" ).change(function() {
    var id = $("#status_add").val();
    if(id == 1){
        $("#max_u_add").prop("readonly", true);
        $("#max_u_add").val(0);
        }else{
        $("#max_u_add").prop("readonly", false);
	}
});
$("#status" ).change(function() {
    var id = $("#status").val();
    if(id == 1){
        $("#max_u").prop("readonly", true);
        }else{
        $("#max_u").prop("readonly", false);
	}
});

$(document).on('click', '.batal_order', function(e) {
    e.preventDefault();
    
    var dataID = $(this).attr('data-id');
    var mod = $(this).data('modedit');
    
    $.ajax({
        'url': base_url + 'main/cek_order',
        'data': {id: dataID},
        'method': 'POST',
        dataType: 'json',
        success: function(data) {
            $("#no_order").val("");
            $("#keterangan").val("");
            if(data.status=='ok'){
                $('#modal-batal').modal('show');
                $("#no_order").val(data.id);
                $("#notrx").val(data.notrx);
                $("#keterangan").val(data.ket);
                $("#mod_batal").val(mod);
                $("#total_batal").val(formatMoney(data.total,0,"Rp."));
                load_jenis_batal();
                }else{
                sweet('Status!!!',data.msg,'warning','warning');
			}
		},
        error: function(xhr, status, error) {
            var err = xhr.responseText ;
            sweet('Server!!!',err,'error','danger');
		}
	})
});


$('#OpenCart-1').on('hide.bs.modal', function() {
    $("#print,#bayarin,#simpan").prop("disabled",false);
    $("#namanya").html('');
    hideCart();
    searchFilter();
    $.LoadingOverlay("hide");
    
});
$('#print-4').on('hide.bs.modal', function() {        
    searchFilter();
    $.LoadingOverlay("hide");
});
function resetForm() {
    $('#dispu').html('');
    $('#telepon_add').focus();
    $("#form-tambah").trigger("reset");
    $('#panggilan_add,#nama_add,#telepon_add,#alamat_add,#perusahaan_add,#jenis_lembaga_add,#alamat_perusahaan_add,#no_telp_add,#tampil_data,#via_add,#save-cari,#status_add,#max_u_add').prop('disabled', false);
}

$('body').on('hidden.bs.modal', '.modal', function() {
    $(this).removeData('bs.modal');
    $(this).find('form').trigger('reset');
    $.LoadingOverlay("hide");
});
$('#modal-batal').on('hidden.bs.modal', function (e) {
    e.preventDefault();
    $(this)
    .find("input,textarea,select")
    .val('')
    .end()
    .find("input[type=checkbox], input[type=radio]")
    .prop("checked", "")
    .end();
})

$("#form-batal").submit(function(e) {
    e.preventDefault();
    var total_batal = angka($("#total_batal").val());
    var saldo = angka($("#saldo_kas_batal").val());
	var sumber = $("#sumber_kas_batal").val();
    
    if(parseInt(saldo) < parseInt(total_batal)){
        sweet('Peringatan!!!','Saldo tidak mencukupi','warning','warning');
        return;
	}
	
    var dataform = $("#form-batal").serialize();
    $.ajax({
        url: base_url + "main/simpan_batal",
        type: "post",
        data: dataform,
        dataType: 'json',
		beforeSend: function(){
			$('body').loading({zIndex:1070});
		},
        success: function(arr) {
			$('body').loading('stop');
            if (arr.ok == "ok") {
                sweet('Update!!!',arr.msg,'success','success');
                }else{
                sweet('Peringatan!!!',arr.msg,'warning','warning');
			}
            searchFilter();
            $('#modal-batal').modal('hide');
            $('#OpenCart-1').modal('hide');
		},
        error: function(xhr, status, error) {
            var err = xhr.responseText ;
			$('body').loading('stop');
            sweet('Server!!!',err,'error','danger');
            $('#modal-batal').modal('hide');
            $('#OpenCart-1').modal('hide');
		}
	});
});

$("#form-edit-k").submit(function(e) {
    e.preventDefault();
    var dataform = $("#form-edit-k").serialize();
    $.ajax({
        url: base_url + "konsumen/update_konsumen",
        type: "post",
        data: dataform,
        dataType: 'json',
        beforeSend: function(){
            $('body').loading();
		},
        success: function(arr) {
            if (arr.status == 200) {
                sweet('Update!!!',arr.msg,'success','arr.ok');
                searchFilterKonsumen();
                }else{
                sweet('Peringatan!!!',arr.msg,'warning','warning');
			}
            $('#modal-edit-konsumen').modal('hide');
            $('body').loading('stop');
		},
        error: function(xhr, status, error) {
            var err = xhr.responseText ;
            sweet('Server!!!',err,'error','danger');
            $('#modal-edit-konsumen').modal('hide');
            $('body').loading('stop');
		}
	});
});

$(".select2-profil").select2();


// var start = moment();
var start = moment().startOf("month");
var end = moment();
/**
	* @param {!Object} start
	* @param {!Object} end
	* @return {undefined}
*/
function cb(start, end) {
	$("#reportrange span").html(start.format("DD/MM/YYYY") + " - " + end.format("DD/MM/YYYY"));
}
$("#reportrange").daterangepicker({
	startDate : start,
	endDate : end,
	ranges : {
		"Today" : [moment(), moment()],
		"Yesterday" : [moment().subtract(1, "days"), moment().subtract(1, "days")],
		"Last 7 Days" : [moment().subtract(6, "days"), moment()],
		"Last 30 Days" : [moment().subtract(29, "days"), moment()],
		"This Month" : [moment().startOf("month"), moment().endOf("month")],
		"Last Month" : [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
	}
}, cb);
cb(start, end);

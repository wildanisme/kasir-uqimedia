'use strict';
/** @type {(Element|null)} */
load_notif();
function load_notif() 
{
	
	$.ajax({
		type : "POST",
		url : base_url + "gudang/notifikasi_stok",
		cache : false,
		success : function(data) 
		{
			
			$(".stok-notif").html(data);
			
		}
	});
}

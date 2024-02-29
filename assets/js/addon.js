'use strict';
$(document).ready(function() {
    $(".hide-txt").hide();
    $(".tax-wrap input").focus(function() {
        $(".hide-txt").show("slow");
    });
    $(".tax-wrap input").blur(function() {
        if (!$(this).val()) {
            $(".hide-txt").hide("slow");
            } else {
            $(".hide-txt").show("slow");
        }
    });
    $(".input1").iconpicker(".input1");
    gload("hide");
});
/** @type {boolean} */
var click = false;
/**
    * @param {?} callback
    * @return {undefined}
*/
function callFunction(callback) {
    if (!click) {
        $("#kolapse").addClass("btn-info");
        $(".dd").nestable("expandAll");
        $("#kolapse").html('<i class="fa fa-minus"></i> Collapse');
        /** @type {boolean} */
        click = true;
        } else {
        $(".dd").nestable("collapseAll");
        $("#kolapse").removeClass("btn-info");
        $("#kolapse").addClass("btn-success");
        $("#kolapse").html('<i class="fa fa-plus"></i> Expand');
        /** @type {boolean} */
        click = false;
    }
}
$(document).ready(function() {
    $("#kolapse").html('<i class="fa fa-plus"></i> Expand');
    /**
        * @param {!Object} e
        * @return {undefined}
    */
    var updateOutput = function(e) {
        var list = e.length ? e : $(e.target);
        var output = list.data("output");
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable("serialize")));
            } else {
            output.val("JSON browser support required for this demo.");
        }
    };
    $("#nestable").nestable({
        group : 1
    }).on("change", updateOutput);
    updateOutput($("#nestable").data("output", $("#nestable-output")));
    $("#nestable").nestable({
        maxDepth : 10,
        collapsedClass : "dd-collapsed"
    }).nestable("collapseAll");
});
$(document).ready(function() {
    /**
        * @return {?}
    */
    function createFolder() {
        var existingDescription = $("#label").val();
        var resAIW = $("#aktif").val();
        var newTagTwo = $("#parentc").val();
        var eclass = $("#eclass").val();
        if (existingDescription == "") {
            notif("Nama menu harus diisi", "warning");
            $("#label").focus();
            } else {
            if (resAIW == "") {
                notif("Aktif harus dipilih", "warning");
                $("#aktif").focus();
                } else {
                if (newTagTwo == "") {
                    create();
                    return true;
                    } else {
                    if (existingDescription == "") {
                        notif("CLASS ICON harus di isi", "warning");
                        $("#eclass").focus();
                        return false;
                        } else {
                        create();
                        return true;
                    }
                }
            }
        }
    }
    /**
        * @return {?}
    */
    function create() {
        /** @type {!Array} */
        var level = [];
        $(".get_value").each(function() {
            if ($(this).is(":checked")) {
                level.push($(this).val());
            }
        });
        /** @type {string} */
        level = level.toString();
        var data = {
            type : $("#type").val(),
            label : $("#label").val(),
            link : $("#link").val(),
            eclass : $("#eclass").val(),
            parentc : $("#parentc").val(),
            aktif : $("#aktif").val(),
            submenu : $("#submenu").val(),
            target : $("#target").val(),
            level : level,
            id : $("#id").val()
        };
        $.ajax({
            type : "GET",
            url : base_url + "main/save_menu",
            data : data,
            beforeSend : function() {
                gload("show");
                $("#submits").html("Proses...");
            },
            dataType : "json",
            cache : false,
            success : function(data) {
                console.log(data.aktif)
                if (data.aktif == "Y") {
                    $("#reload_"+ data.id).removeClass('text-danger');
                    $("#label_show"+ data.id).removeClass('text-danger');
                    $("#link_show"+ data.id).removeClass('text-danger');
                    $("#eclass_show"+ data.id).removeClass('text-danger');
                    }else{
                    $("#reload_"+ data.id).addClass("text-danger");
                    $("#label_show"+ data.id).addClass("text-danger");
                    $("#link_show"+ data.id).addClass("text-danger");
                    $("#eclass_show"+ data.id).addClass("text-danger");
                }
                if (data.type == "add") {
                    if (data.ok == "ok") {
                        $("#menu-id").append(data.menu);
                        $("#submits").html("Submit");
                        $("#accordionSidebar").load(location.href + " #accordionSidebar");
                        $("#reload_"+ data.id).addClass("text-danger");
                        notif(data.msg, "info");
                        } else {
                        notif("Data GAGAL di simpan", "danger");
                        $("#submits").html("Submit");
                    }
                    } else {
                    
                    
                    if (data.type == "edit") {
                        $("#submits").html("Submit");
                        $("#label_show" + data.id).html(data.label);
                        $("#link_show" + data.id).html(data.link);
                        $("#eclass_show" + data.id).html(data.eclass);
                        notif(data.msg, "success");
                        $("#showicon").removeClass(data.eclass);
                        $("#showicon").addClass("fa-bars");
                        $("#accordionSidebar").load(location.href + " #accordionSidebar");
                        
                    }
                }
                $("#label").val("");
                $("#link").val("");
                $("#eclass").val("");
                $("#parentc").val("");
                $("#aktif").val("");
                $("#target").val("_self");
                $("#submenu").val("N");
                $("#id").val("");
                $(".get_value").prop("checked", false);
                gload("hide");
            },
            error : function(res, status, e) {
                gload("hide");
                alert(e);
            }
        });
        return false;
    }
    $("#save").prop("disabled", true);
    $("#submit-form").validate({
        rules : {
            link : {
                required : true
            }
        },
        submitHandler : createFolder
    });
    $(".dd").on("change", function() {
        $("#save").prop("disabled", this.value == "" ? true : false);
    });
    $("#save").click(function() {
        var notifData = {
            type : $("#type").val(),
            data : $("#nestable-output").val()
        };
        $.ajax({
            type : "GET",
            url : base_url + "main/crud",
            data : notifData,
            cache : false,
            beforeSend : function() {
                gload("show");
            },
            success : function(retu_data) {
                gload("hide");
                $("#save").prop("disabled", true);
                $("#showicon").removeClass(eclass);
                $("#showicon").addClass("fa-bars");
                $(".hide-txt").hide("slow");
                $("#accordionSidebar").load(location.href + " #accordionSidebar");
                // $("#menu-id").load(location.href + " #menu-id");
                notif("Data di update", "success");
            },
            error : function(deleted_model, err, op) {
                gload("hide");
            }
        });
    });
    $(document).on("click", ".edit-button", function() {
        var id = $(this).attr("id");
        $(".get_value").prop("checked", false);
        $.ajax({
            type : "GET",
            url : base_url + "main/crud",
            dataType : "json",
            data : {
                id : id,
                type : "get"
            },
            cache : false,
            beforeSend : function() {
                gload("show");
            },
            success : function(action) {
                const cArr = action.level.split(",").length;
                if (cArr > 1) {
                    var idArr = action.level.split(",");
                    } else {
                    /** @type {!Array} */
                    idArr = [action.level];
                }
                const pipelets = idArr;
                pipelets.forEach(function(domRootID, index) {
                    $("#idlevel" + domRootID).prop("checked", true);
                });
                $("#submits").html("Update");
                $("#showicon").addClass(action.eclass);
                $("#showicon").removeClass("fa-bars");
                $("#id").val(action.id);
                $("#label").val(action.label).focus();
                $("#link").val(action.link);
                $("#eclass").val(action.eclass);
                $("#parentc").val(action.parentc);
                $("#aktif").val(action.aktif);
                $("#target").val(action.target);
                $("#submenu").val(action.submenu);
                if ($("#parentc").val() != "") {
                    $(".hide-txt").show("slow");
                    } else {
                    $(".hide-txt").hide("slow");
                }
                gload("hide");
            },
            error : function(deleted_model, err, op) {
                gload("hide");
            }
        });
    });
    $(document).on("click", "#reset", function() {
        $(".get_value").prop("checked", false);
        var READONLY_CLS = $("#eclass").val();
        $("#label").val("");
        $("#link").val("");
        $("#eclass").val("");
        $("#parentc").val("");
        $("#showicon").removeClass(READONLY_CLS);
        $("#showicon").addClass("fa-bars");
        $("#aktif").val("");
        $("#target").val("_self");
        $("#submenu").val("N");
        $("#id").val("");
        $(".hide-txt").hide("slow");
    });
});
/**
    * @return {undefined}
*/
function show_selected() {
    /** @type {(Element|null)} */
    var videoSelect = document.getElementById("icon");
    var highlowselect = videoSelect[videoSelect.selectedIndex].value;
    document.getElementById("eclass").value = highlowselect;
    $("#showicon").addClass(highlowselect);
    $("#myModal").modal("hide");
}
$("#myModalDel").on("show", function() {
    var salesTeam = $(this).data("id");
    var removeBtn = $(this).find(".danger");
});
$(".confirm-delete").on("click", function(event) {
    event.preventDefault();
    var pack_id = $(this).data("id");
    $("#myModalDel").data("id", pack_id).modal("show");
});
$(document).on("click", "#btnYes", function() {
    var id = $("#myModalDel").data("id");
    $.ajax({
        type : "GET",
        url : base_url + "main/crud",
        data : {
            type : "hapus",
            id : id
        },
        cache : false,
        dataType : "json",
        beforeSend : function() {
            gload("show");
        },
        success : function(data) {
            if (data[0] == "ok") {
                notif("Data di hapus", "info");
                $("li[data-id='" + id + "']").remove();
                } else {
                notif("Data gagal di hapus", "danger");
            }
            $("#myModalDel").modal("hide");
            gload("hide");
        },
        error : function(deleted_model, err, op) {
            gload("hide");
        }
    });
});

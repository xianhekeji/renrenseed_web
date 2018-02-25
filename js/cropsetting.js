/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    provinces = "";
    $("#au_memo").autocomplete({
        source: "../Action/searchMemo.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            var provinces = $("#t_memo").val();
            provinces = provinces + ui.item.label + ";";
            $("#t_memo").empty();
            $("#t_memo").append(provinces);
            $("#au_memo").val("");
        }
    });
    $("#au_province_name").autocomplete({
        source: "../Action/searchProvince.php",
        minLength: 1,
        autoFocus: false
    });
    $("#cropname").autocomplete({
        source: "../Action/searchCrop.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            // event 是当前事件对象
            ss = ui.item.label.split(";");
            $.post("../Action/searchCropById.php", {"CropId": ss[0]}, function (data) {
                //这里你可以处理获取的数据。我使用是json 格式。你也可以使用其它格式。或者为空，让它自己判断得了  
                $("#cropname").val(data[0]["CropId"] + ";" + data[0]["VarietyName"]);
                var c_isgen = data[0]["IsGen"];
                $("input:radio[value=" + c_isgen + "]").eq(0).attr("checked", 'checked');
                $("#au_min").val(data[0]["MinGuidePrice"]);
                $("#au_max").val(data[0]["MaxGuidePrice"]);
                $("#au_region").val(data[0]["BreedRegion"]);
                // $("#au_memo").val(data[0]["Memo"]);
                $("#au_organization").val(data[0]["BreedOrganization"]);
                $("#au_level").val(data[0]["CropLevel"]);
                $("#select_1").find("option[text='" + data[0]["VarietyName_1"] + "']").attr("selected", true);
                get_select_3(data[0]["VarietyName_2"]);
                $("#flag").empty();
                if (data[0]['Flag'] == '1')
                {
                    $("#flag").append("<text>已作废</text>");
                    $("#flag_qiyong").show();
                    $("#flag_zuofei").hide();
                } else
                {
                    $("#flag").append("<text>已启用</text>");

                    $("#flag_qiyong").hide();
                    $("#flag_zuofei").show();
                }

                $("#t_memo").empty();
                $("#t_memo").append(data[0]["Memo"]);
                $("#crop_img").empty();
                var c_img = data[0]["CropImgs"];
                if (c_img !== null && c_img !== "") {
                    arr_img = c_img.split(";");

                    for (var i = 0; i < arr_img.length; i++)
                    {
                        var imgurl = '<td><a href="https://www.renrenseed.com/files/cropImgs/' + arr_img[i] + '" target="_blank"><img src="https://www.renrenseed.com/files/cropImgs/' + arr_img[i] + '" height="100" width="100" /></a></td>';
                        $("#crop_img").append(imgurl);
                    }
                }
            }, 'json');
        }
    });
});
function get_select_1() {
    $.post("../Action/getselect_1.php", {sf_id: encodeURI($("#select_1").val())}, function (json) {
        var select_1 = $("#select_1");
        $("option", select_1).remove(); //清空原有的选项，也可使用 ds_id.empty(); 
        $.each(json, function (index, array) {
            var option = "<option value='" + array['ds_id'] + "'>" + array['ds_name'] + "</option>";
            select_1.append(option);
        });
        get_select_2();
    }, "json");
}
function get_select_2() {
    $.post("../Action/getselect_2.php", {sf_id: $("#select_1").val()}, function (json) {
        var select_2 = $("#select_2");
        $("option", select_2).remove(); //清空原有的选项，也可使用 ds_id.empty(); 
        $.each(json, function (index, array) {
            var option = "<option value='" + array['ds_id'] + "'>" + array['ds_name'] + "</option>";
            select_2.append(option);
        });
    }, "json");
}
function get_select_3(str) {
    $.post("../Action/getselect_2.php", {sf_id: $("#select_1").val()}, function (json) {
        var select_2 = $("#select_2");
        $("option", select_2).remove(); //清空原有的选项，也可使用 ds_id.empty(); 
        $.each(json, function (index, array) {
            var option = "<option value='" + array['ds_id'] + "'>" + array['ds_name'] + "</option>";
            select_2.append(option);
        });
        $("#select_2").find("option[text='" + str + "']").attr("selected", true);
    }, "json");
}
//下面是页面加载时自动执行一次getVal()函数 
$().ready(function () {
    get_select_1();
    $("#select_1").change(function () {//省份部分有变动时，执行getVal()函数 
        //alert($("#select_1").val());
        get_select_2();
    });
});


function addPic1() {
    var addBtn = document.getElementById('addBtn');
    var input = document.createElement("input");
    input.type = 'file';
    input.name = 'myfile[]';
    var picInut = document.getElementById('picInput');
    picInut.appendChild(input);
    if (picInut.children.length == 10) {
        addBtn.disabled = 'disabled';
    }
}
function resetProvince() {
    provinces = "";
    $("#t_memo").empty();
    $("#au_memo").val("");
}
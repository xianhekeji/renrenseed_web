/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $("#key").autocomplete({
        source: "../Action/searchEnterprise.php",
        minLength: 1,
        autoFocus: false
    });

    $("#brand").autocomplete({
        source: "../Action/searchBrand.php",
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
                // alert(data[0]["VarietyName_1"]+data[0]["VarietyName_2"]);
                $("#select_1").find("option[text='" + data[0]["VarietyName_1"] + "']").attr("selected", true);
                get_select_3(data[0]["VarietyName_2"]);
            }, 'json');
        }
    });
    $("#commodityname").autocomplete({
        source: "../Action/searchCommodity.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            // event 是当前事件对象
            ss = ui.item.label.split(";");
            $.post("../Action/searchCommodityById.php", {"commodityid": ss[0]}, function (data) {
                //这里你可以处理获取的数据。我使用是json 格式。你也可以使用其它格式。或者为空，让它自己判断得了	
                var c_class = data["CommodityClass"];
                $("input:radio[value=" + c_class + "]").eq(0).attr("checked", 'checked');
                $("#select_1").find("option[text='" + data["VarietyName_1"] + "']").attr("selected", true);
                get_select_3(data["VarietyName_2"]);
                $("#name").val(data["CommodityName"]);
                $("#price").val(data["CommodityPrice"]);
                $("#spec").val(data["CommodityLicence"]);
                $("#describe").val(data["CommodityDescribe"]);
                $("#brand").val(data["BrandId"] + ";" + data["BrandName"]);
                $("#key").val(data["EnterpriseId"] + ";" + data["EnterpriseName"]);
                $("#cropname").val(data["CropId"] + ";" + data["VarietyName"]);
                $("#flag").empty();
                if (data["CommodityFlag"] == 1)
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
                var c_img = data["CommodityImgs"];
                $("#commodityimg").empty();
                if (c_img !== null && c_img !== "") {
                    arr_img = c_img.split(";");

                    for (var i = 0; i < arr_img.length; i++)
                    {
                        var imgurl = '<td><a href="http://www.renrenseed.com/files/commodityImgs/' + arr_img[i] + '" target="_blank"><img src="http://www.renrenseed.com/files/commodityImgs/' + arr_img[i] + '" height="100" width="100" /></a></td>';
                        $("#commodityimg").append(imgurl);
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
            get_select_2();
        });
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
        get_select_2();
    });
});
function check(v) {
    var r = /^[0-9]+.?[0-9]*$/;
    if (!r.test(v)) { //isNaN也行的,正则可以随意扩展
        alert('只能输入数字');
    }
}
function addPic1() {
    var addBtn = document.getElementById('addBtn');
    var input = document.createElement("input");
    input.type = 'file';
    input.name = 'myfile[]';
    var picInut = document.getElementById('picInput');
    picInut.appendChild(input);
    if (picInut.children.length == 3) {
        addBtn.disabled = 'disabled';
    }
}
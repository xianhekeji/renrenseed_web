/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    provinces = "";
    $("#cropname").autocomplete({
        source: "../Action/searchCrop.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            ss = ui.item.label.split(";");
            $.post("../Action/searchCropById.php", {"CropId": ss[0]}, function (data) {
                $("#au_org").val(data[0]['BreedOrganization']);
            }, 'json')
        }
    });

    $("#au_number").autocomplete({
        source: "../Action/searchAuthorize.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            ss = ui.item.label.split(";");
            $.post("../Action/searchAuthorizeById.php", {"authorize_id": ss[0]}, function (data) {
                $("#select_status").find("option[value='" + data[0]["AuthorizeStatus"] + "']").attr("selected", true);
                $("#flag").empty();
                if (data[0]['AuFlag'] == '1')
                {
                    $("#flag").append("<text>已作废</text>");
                    $("#flag_qiyong").show();
                    $("#flag_zuofei").hide();
                } else if (data[0]['AuFlag'] == '2')
                {
                    $("#flag").append("<text>已退出</text>");
                    $("#flag_qiyong").hide();
                    $("#flag_zuofei").show();
                } else
                {
                    $("#flag").append("<text>已启用</text>");
                    $("#flag_qiyong").hide();
                    $("#flag_zuofei").show();
                }
                $("#cropname").val(data[0]["AuCropId"] + ";" + data[0]["AuCropName"]);
                $("#au_year").val(data[0]["AuthorizeYear"]);
                $("#au_province_name").val(data[0]["AuthorizeProvince"] + ";" + data[0]["AuthorizeProvinceName"]);
                $("#au_org").val(data[0]["BreedOrganization"]);
                $("#au_unit").val(data[0]["AuthorizeUnit"]);
                $("#au_source").val(data[0]["VarietySource"]);
                $("#au_featrue").val(data[0]["Features"]);
                $("#au_region").val(data[0]["BreedRegion"]);
                $("#au_featrue").val(data[0]["Features"]);
                $("#au_pro").val(data[0]["Production"]);
                $("#au_kangxing").val(data[0]["AuKangxing"]);
                $("#au_pinzhi").val(data[0]["AuPinzhi"]);
                $("#au_skill").val(data[0]["BreedSkill"]);
                $("#au_tuichu").val(data[0]["FlagReason"]);
                provinceids = data[0]["BreedRegionProvince"].split(",");
                provincenames = data[0]["BreedRegionProvinceName"].split(",");
                /*  alert(data[0]["BreedRegionProvince"]); */
                /*                 var provinceids=new array(data[0]["BreedRegionProvince"]);
                 
                 var provincenames=new array(data[0]["BreedRegionProvinceName"]); */

                var re_pro = "";
                for (var i = 0; i < provinceids.length; i++)
                {
                    re_pro = re_pro + provinceids[i] + "," + provincenames[i] + ";";
                }
                provinces = re_pro;
                $("#t_province").append(provinces);
            }, 'json')
        }
    });
    $("#au_province").autocomplete({
        source: "../Action/searchProvince.php",
        minLength: 1,
        autoFocus: false,
        select: function (event, ui) {
            ss = ui.item.label.split(";");
            provinces = provinces + ss + ";";
            $("#t_province").empty();
            $("#t_province").append(provinces);
            $("#au_province").val("");
        }
    });
    $("#au_province_name").autocomplete({
        source: "../Action/searchProvince.php",
        minLength: 1,
        autoFocus: false
    });

})
function resetProvince() {
    provinces = "";
    $("#t_province").empty();
    $("#au_province").val("");
}
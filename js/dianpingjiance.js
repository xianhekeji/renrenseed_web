/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function () {

});
function jinyan(obj) {

    $.post("../Action/disableUser.php", {"type": 0, "userid": obj}, function (data) {
        alert(data);
        location.reload();
    }, 'text')
}
function huifu(obj) {

    $.post("../Action/disableUser.php", {"type": 1, "userid": obj}, function (data) {
        alert(data);
        location.reload();
    }, 'text')
}
function setflag(obj1, obj2) {
    $.post("../Action/flagCropComment.php", {"flag": obj2, "id": obj1}, function (data) {
        alert(data);
        location.reload();
    }, 'text')
}
function sendHongbao(obj) {
    $.post("../Action/sendHongbao.php", {"id": obj}, function (data) {
        alert(data);
    }, 'text')
}
// Удаление доп. материала
$('.delete_ebook').submit(function (e) {
    var x = confirm("Удалить книгу?");
    if (x) {
        return true;
    }
    else {
        return false;
    }
});
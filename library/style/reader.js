/**
 * Created by will on 2016/12/4.
 */
function showAdd() {
    $('#modal_add').modal('show');
}
function showUpdate(Reader_id,Reader_name,sex,birthday,password,phone,mobile,Card_name,Card_id,level) {
    $('#update_rno').val(Reader_id);
    $('#update_rname').val(Reader_name);
    $('#update_sex').val(sex);
    $('#update_birthday').val(birthday);
    $('#update_password').val(password);
    $('#update_phone').val(phone);
    $('#update_mobile').val(mobile);
    $('#update_card_name').val(Card_name);
    $('#update_card_id').val(Card_id);
    $('#update_level').val(level);
    $('#modal_update').modal('show');
}
function showDel(id) {
    $('#modal_delete').modal('show');
    $('#delete_id').val(id);

}
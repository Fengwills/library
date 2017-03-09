/**
 * Created by will on 2016/12/6.
 */
function showDetail(Book_id,Book_name,category,author,publishing,price,Quantity_in,Quantity_left) {;
    $("#detail_bno").val(Book_id);
    $("#detail_bname").val(Book_name);
    $("#detail_tid").val(category);
    $("#detail_author").val(author);
    $("#detail_publishing").val(publishing);
    $("#detail_price").val(price);
    $("#detail_total").val(Quantity_in);
    $("#detail_remain").val(Quantity_left);
    $('#modal_detail').modal('show');
}
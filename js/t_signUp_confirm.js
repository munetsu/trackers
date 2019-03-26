$('.btn').on('click', function(e){
    e.preventDefault();
    let data_id = $(this).attr('data-id');
    if(data_id == 'edit'){
        $('form[name="signUp"]').attr('action', 't_signUp_edit.php');
    }else{
        $('form[name="signUp"]').attr('action', 'mvc/controller.php');
    }
    $('form[name="signUp"]').submit();
});
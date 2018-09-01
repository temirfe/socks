$('.js_rot_caret').click(function () {

    let deg=180, targ=$(this).attr('data-target');

    if($(targ).is(":visible")){deg=0;}
    $(this).find('i').css({'transform' : 'rotate('+deg+'deg)'});
});

function imgSorted(e, params){
    if(params.oldIndex!==params.newIndex && params.stack.length){
        console.log(params);
        $.ajax({
            type: 'POST',
            //data: {model_id:params.stack[0].model_id, model_name:params.stack[0].model_name,key:params.stack[0].key, _csrf: yii.getCsrfToken()},
            data: {model_id:params.stack[0].model_id, model_name:params.stack[0].model_name,stack:params.stack, _csrf: yii.getCsrfToken()},
            url: '/site/img-sort',
            //beforeSend: function () {},
            success:function(data){
                console.log(data);
            }
        });
    }
}

//Тур для группы из 6 человек
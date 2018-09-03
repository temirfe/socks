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


$('#price-group_of').blur(function() {
    let person=$(this).val();
    let en='Group of ', ru_pre='Тур для группы из ',ru_post=' человек', ko=' 인조';
    if(person==='1'){
        en='Price for '; ru_pre='Цена тура за '; ru_post='-го человека'; ko=' 의 가격';
    }
        $('#price-title').val(en + person);
        $('#price-title_ru').val( ru_pre + person + ru_post );
        $('#price-title_ko').val(person + ko);
    });

$('#price-price').blur(function() {
    let person=$('#price-group_of').val().toString();
    let en='', ru='', ko='';
    if(person==='1'){
        en='Price per person'; ru='Цена за 1-го целовека'; ko='1 인당 가격';
    }
    else{
        let price=$(this).val().toString();
        let price_person=parseInt(price)/parseInt(person)+" USD";
        en=price_person+' per person'; ru='Цена за человека '+price_person; ko='1 인당 '+price_person+' 달러';
    }
    $('#price-note').val(en);
    $('#price-note_ru').val(ru);
    $('#price-note_ko').val(ko);
});

$(document).ready(function () {
    //initialize swiper when document ready
    let swiperCont=$('.banner-container');
    if(swiperCont.length){
        let scount=parseInt(swiperCont.attr("data-count"));
        if(scount>1){
            let mySwiper = new Swiper ('.banner-container', {
                // Optional parameters
                //direction: 'vertical',
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                //loop:true,
                autoplay: {
                    delay: 12500,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })
        }
    }
});
$(document).on('click','.js_more',function(){
    $(this).parent().removeClass('closed');
    $(this).hide();
    $(this).siblings('.gradient').hide();
});
$(document).on('click','.js_less',function(){
    $(this).parent().addClass('closed');
    $(this).siblings('.gradient').show();
    $(this).siblings('.js_more').show();
});
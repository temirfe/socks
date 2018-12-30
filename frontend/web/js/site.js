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
    fillNote();
    });

$('#price-price').blur(function() {
    fillNote();
});
$('#price-currency').change(function() {
    fillNote();
});

function fillNote(){
    let person=$('#price-group_of').val().toString();
    let en='', ru='', ko='';
    let currency=$('#price-currency').val();
    if(person==='1'){
        en='Price per person'; ru='Цена за 1-го целовека'; ko='1 인당 가격';
    }
    else{
        let price=$('#price-price').val().toString();
        let price_person=Math.round(parseInt(price)/parseInt(person));
        if(!isNaN(price_person)){
            let str=price_person+" "+currency.toUpperCase();
            en=str+' per person'; ru='Цена за человека '+str; ko='1 인당 '+str+' 달러';
        }
    }
    $('#price-note').val(en);
    $('#price-note_ru').val(ru);
    $('#price-note_ko').val(ko);
}

$(document).ready(function () {
    //initialize swiper when document ready
    let swiperCont=$('.banner-container');
    if(swiperCont.length){
        let scount=parseInt(swiperCont.attr("data-count"));
        if(scount>1){
            let mySwiper = new Swiper ('.banner-container', {
                // Optional parameters
                //direction: 'vertical',
                loop: true,
                effect: 'coverflow',
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                //loop:true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })
        }
    }

    let img_wrap=$('.real_img_wrap');
    if(img_wrap.length){
        let img_count=parseInt(img_wrap.attr("data-count"));
        if(img_count>1){
            let imgSwiper = new Swiper ('.real_img_wrap', {
                // Optional parameters
                //direction: 'vertical',
                effect: 'coverflow',
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                //loop:true,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

            $('.js_img_swiper_item').click(function(){
                openPhotoSwipe(imgSwiper.activeIndex);
            });

            imgSwiper.on('slideChange', function () {
                $('.js_photo_swipe').attr('data-index',imgSwiper.activeIndex);
                $('.js_prevent_default').attr('class','js_open_thumb');
                $(".js_open_thumb[data-index='"+imgSwiper.activeIndex+"']").attr('class','js_prevent_default active_thumb');
            });


            $(document).on('click','.js_open_thumb',function(e){
                e.preventDefault();
                $('.js_prevent_default').attr('class','js_open_thumb');
                $(this).attr('class','js_prevent_default active_thumb');
                //$('.js_main_img').attr('src',$(this).attr('data-big'));

                let ind=$(this).attr('data-index');
                $('.js_photo_swipe').attr('data-index',ind);
                imgSwiper.slideTo(ind);

            });

        }
    }

});
$(document).ready(function () {
    //initialize swiper when document ready
    let slides=2;
    if($(document).width()>600){
        slides=4;
    }
    let swiperCont=$('.related_swiper');
    if(swiperCont.length){
        let scount=parseInt(swiperCont.attr("data-count"));
        if(scount>1){
            let mySwiper = new Swiper ('.related_swiper', {
                // Optional parameters
                //loop:true,
                slidesPerView: slides,
                spaceBetween: 2,
                freeMode: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                /*autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },*/
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            })
        }
    }
});

$(document).on('click','.js_more',function(e){
    e.preventDefault();
    let parent=$(this).parents('.js_more_less');
    parent.removeClass('closed');
    $(this).hide();
    parent.find('.gradient').hide();
});
$(document).on('click','.js_less',function(e){
    e.preventDefault();
    let parent=$(this).parents('.js_more_less');
    parent.addClass('closed');
    parent.find('.gradient').show();
    parent.find('.js_more').show();
});

//region PhosoSwipe
$(document).on('click','.js_photo_swipe',function(e){
    e.preventDefault();
    var index=$(this).attr('data-index');
    openPhotoSwipe(index);
});

var openPhotoSwipe = function(ind)
{
    var pswpElement =document.querySelectorAll('.pswp')[0];

    ind=parseInt(ind);
    // define options (if needed)
    var options = {
        index: ind, // start at first slide
        showHideOpacity:true,
        getThumbBoundsFn:false,
        bgOpacity:0.9,
        closeOnScroll:false,
        shareButtons: false
    };
    var items = [];
    var image=new Image();
    $(".js_img").each(function() {
        var src=$(this).parent().attr('data-big');
        image.src=src;
        var w=image.width;
        var h=image.height;
        items.push({src:src, w:w, h:h});
    });

    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
    gallery.init();
};
//endregion

//region gallery
$(document).on('click', '.js_prevent_default',function(e){
    e.preventDefault();
});

$('.js_main_img').click(function(){
    let active_thumb_link=$('.js_prevent_default');
    active_thumb_link.attr('class','js_open_thumb');
    let next=active_thumb_link.parent().next().find('a');
    if(next.length===0){
        next=active_thumb_link.parents('ul').find('li:first-child a');
    }
    $(this).attr('src',next.attr('data-big'));
    next.attr('class','js_prevent_default active_thumb');

    let ind=next.attr('data-index');
    $('.js_photo_swipe').attr('data-index',ind);
});
//endregion
if($('.product-index').length){
    reveal();
}
function reveal(){
    ScrollReveal().reveal('.js_product_item .product_box',{
        duration:1000,
        origin:'bottom',
        distance:'100px',
        delay: 200,
        useDelay: 'onload',
        viewFactor:0.2,
        interval:16
    });
}

$(document).on('pjax:success', function() {
    reveal();
});

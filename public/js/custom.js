$(function(){

    iziToast.settings({
        position: 'topRight',
        timeout: 5000,
        transitionIn: 'flipInLeft',
        transitionOut: 'flipOutLeft',
        layout: 2,
    });
});

function success(title,msg){
    iziToast.success({
        title: title,
        message: msg,
    });
}

function warning(title,msg){
    iziToast.warning({
        title: title,
        message: msg,
    });
}

function error(title,msg){
    iziToast.error({
        title: title,
        message: msg,
    });
}


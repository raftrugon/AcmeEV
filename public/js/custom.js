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

function message(title,msg){
    iziToast.show({
        theme: 'dark',
        icon: 'icon-drafts',
        title: title,
        message: msg,
        position: 'topRight',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        progressBarColor: 'rgb(0, 255, 184)',
        image: 'img/avatar.jpg',
        imageWidth: 70,
        layout: 2,
        iconColor: 'rgb(0, 255, 184)'
    });
}


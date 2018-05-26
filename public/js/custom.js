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
    if(msg.length > 38) msg = msg.substr(0,35)+'...';
    iziToast.show({
        theme: 'dark',
        icon: 'fas fa-envelope',
        title: title,
        message: msg,
        position: 'topRight',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        progressBarColor: 'rgb(0, 255, 184)',
        image: 'img/avatar.png',
        imageWidth: 70,
        layout: 2,
        iconColor: 'rgb(0, 255, 184)'
    });
}

function groupMessage(title,msg,sender){
    if(msg.length > 38) msg = msg.substr(0,35)+'...';
    iziToast.show({
        theme: 'dark',
        icon: 'fas fa-envelope',
        title: title,
        message: '<strong>'+sender+':</strong> '+msg,
        position: 'topRight',
        transitionIn: 'flipInX',
        transitionOut: 'flipOutX',
        progressBarColor: 'rgb(153, 255, 0)',
        image: 'img/avatar-group.png',
        imageWidth: 70,
        layout: 2,
        iconColor: 'rgb(153, 255, 0)'
    });
}


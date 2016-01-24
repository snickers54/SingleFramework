$(document).ready(function(){

});

// petite fonction js qui ramene en haut du site
function goTop()
{
        $('html,body').animate({scrollTop: 0}, 'slow');
}

// display un message d'erreur
function addError(object)
{
        if (object._error_)
        {
                $(".notifications").remove();
                var error = '<div class="row-fluid" class="notifications">' +
                                '<div class="span12">' +
                                        '<div class="alert alert-error">'+
                                                       object._error_ +
                                           '</div>'+
                                '</div>'+
                            '</div>';
                $("#main-content").prepend(error);
                goTop();
                return true;
        }
        return false;
}
// display un message de succes
function addSuccess(object)
{
        if (object._success_)
        {
                $(".notifications").remove();                
                var success = '<div class="row-fluid" class="notifications">' +
                                '<div class="span12">' +
                                        '<div class="alert alert-success">'+
                                                    object._success_ +
                                        '</div>'+
                                '</div>'+
                            '</div>';
                $("#main-content").prepend(success);
                goTop();
                return true;
        }
        return false;
}

// fonctions de gestion de cookie
function setCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
};

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
};

function deleteCookie(name) {
    setCookie(name,"",-1);
};

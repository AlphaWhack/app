/**
 * Created by Hervé MVENG on 20/09/2016.
 */

$(document).ready(function(){

     if($('body').hasClass('page-login-register')){
         $('.base.bxslider').bxSlider({
             video: true,
             useCSS: false
         });
     }
    if($('body').hasClass('page-user')){
        var slider = $('.core-user.bxslider').bxSlider({
            mode: 'horizontal',  //fade
            speed: 2000,
            auto: true,
            pause: 10000,
        });
    }

        /*
        $.ajax({
            type        : $('#form-connexion').attr( 'method' ),
            url         : '{{ path("fos_user_security_check") }}',
            data        : $('form').serialize(),
            dataType    : "json",
            success     : function(data, status, object) {
                if(data.error) $('.msg-connexion').html(data.message);
            },
            error: function(data, status, object){
                console.log(data.message);
                $('.msg-connexion').html(data.message);
            }
        });

        */

    $(".min-profil-name").click(function(){
        if($(".pseudo-profil").find(".glyphicon").hasClass("glyphicon-menu-down")){
            $(".pseudo-profil").find(".glyphicon").removeClass("glyphicon-menu-down");
            $(".pseudo-profil").find(".glyphicon").addClass("glyphicon-menu-up");
            $(".pseudo-profil").css("color","#ffa500");
            $(".other-link-infos").slideDown();
        }
        else{
            $(".pseudo-profil").find(".glyphicon").removeClass("glyphicon-menu-up");
            $(".pseudo-profil").find(".glyphicon").addClass("glyphicon-menu-down");
            $(".pseudo-profil").css("color","#fff");
            $(".other-link-infos").slideUp();
        }
    });

    $(".wrap-icon-search .glyphicon-search").click(function(){
        if(!$(this).hasClass("open-search")){
            $(this).addClass("open-search");
            $(".wrap-icon-search .glyphicon-search").css("color","#ffa500");
            $(".wrap-icon-search .container-search").slideDown();
        }
        else{
            $(this).removeClass("open-search");
            $(".wrap-icon-search .glyphicon-search").css("color","#fff");
            $(".wrap-icon-search .container-search").slideUp();
        }

    });

    $(".wrap-side-header .link-connect").click(function(){
        if(!$(this).hasClass("open-connexion")){
            $(this).addClass("open-connexion");
            $(".wrap-side-header .wrap-connexion").slideDown();
        }
        else{
            $(this).removeClass("open-connexion");
            $(".wrap-side-header .wrap-connexion").slideUp();
        }

    });






});

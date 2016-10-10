/**
 * Created by Hervé MVENG on 20/09/2016.
 */

$(document).ready(function(){

    $('#_submita').click(function(e){
        e.preventDefault();
        if($('#form-connexion #username').val() == '' || $('#form-connexion #password').val() == ''){
           $('.msg-connexion').html("Login or password empty ...");
            //alert("Login or password empty");
        }
        else{
            $.ajax({
                type: 'POST',
                url: $('#form-connexion').attr( 'action' ),
                data : $('#form-connexion').serialize(), // SOME DATA,
                success: function(data) {
                    // DO THE STUFF
                    $('.msg-connexion').html(data.message);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    switch (jqXHR.status) {
                        case 401:
                            var redirectUrl = Routing.generate('fos_user_security_login');
                            $('.msg-connexion').html("Status "+ jqXHR.status);
                            window.location.replace(redirectUrl);
                            break;
                        case 403: // (Invalid CSRF token for example)
                            // Reload page from server
                            $('.msg-connexion').html("Status "+ jqXHR.status);
                            window.location.reload(true);
                    }
                },
            });
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
        }

    });

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

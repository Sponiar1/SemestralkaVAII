function checkUsername() {
    jQuery.ajax({
        url:'App/Views/Auth/checkUsername.php',
        data: 'username='+$("#username").val(),
        type: "POST",
        success:function (data){
            $("#check-username").html(data);
        },
        error:function (){}
    });
}

$(document).ready(function(){
    $("#search-box").keyup(function(){
        $.ajax({
            type: "POST",
            url: "App/Views/Auth/autoCompleteName.php",
            data:'keyword='+$("#search-box").val(),
            success: function(data){
                $("#suggesstion-box").show();
                $("#suggesstion-box").html(data);
                $("#search-box").css("background","#FFF");
                $("#suggesstion-box").css("background","#FFF");
                $("#suggesstion-box").css("color","black");
                $("#suggesstion-box").css("font-size","1rem");
                $("#suggesstion-box").css("cursor","pointer");
                $("#suggesstion-box").css("text-allign","center");
                $("#suggesstion-box").css("width","200px");
                $("#suggesstion-box").css("border-bottom","0.1rem solid black");
                $("#suggesstion-box").css("margin-left","auto");
                $("#suggesstion-box").css("margin-right","auto");
            }
        });
    });
});

function selectUser(val) {
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
}

/**
 * Created by gabriel on 2/3/16.
 */
$(function() {
    var processInvite = function(val, _id){
        var obj = {
            action:"",
            id:_id
        };
        if(val){
            obj.action = "accept";
        }else{
            obj.action ="reject";
        }
        //alert(JSON.stringify(obj));
        $.ajax({
            type: 'POST',
            url: '../php/accept_reject_request.php',
            data: obj,
            success: function(msg) {
                console.log(msg);
            },
            error:function(msg){
                console.log(msg+"error");
            }
        });

    }

    $(".rejectInvite").click(function(e){
        e.preventDefault();
        var id = $(this).parents('li').attr('class');
        var date = $(this).parent().attr('id');
        if(date>0){
            var this_class = id.split(" ");
            $("."+this_class[1]).hide();
            console.log(this_class[1]);
            $("."+this_class[1]+'+li').hide();
        }
        processInvite(false, id);

    });

    $(".acceptInvite").click(function(e){
        e.preventDefault();
        var id = $(this).parents('li').attr('class');
        var this_class = $(this).parents('li').attr('id');
        var date = $(this).parent().attr('id');
        if(date>0){
            $("#"+this_class).hide();
            console.log(this_class);
            $("#"+this_class+'+li').hide();
        }
        processInvite(true,id);
    });


    $('.adekprofile').click(function(e){
        e.preventDefault();
        var id = $(this).parent().attr('id');
        $.ajax({
            type: 'POST',
            url: '../php/adekprofile.php',
            data: {'id':id},
            success: function(msg) {
                console.log(msg);
                window.location = 'viewuserprofile.php';
            },
            error:function(msg){
                console.log(msg+"error");
            }
        });
    });
});

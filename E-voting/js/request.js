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
        var id = $(this).parent().attr('class');
        var date = $(this).parent().attr('id');
        if(date>0){
            $("."+id).hide();
        }
        processInvite(false, id);

    });

    $(".acceptInvite").click(function(e){
        e.preventDefault();
        var id = $(this).parent().attr('class');
        var date = $(this).parent().attr('id');
        if(date>0){
            $("."+id).hide();
        }
        processInvite(true,id);
    });
});

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
        var id = setId($(this));
        processInvite(false, id);
    });

    $(".acceptInvite").click(function(e){
        e.preventDefault();
        var id = setId($(this));
        processInvite(true,id);
    });

    function setId(item){
        var id = item.parents('li.row').attr('class');
        var date = item.parent().attr('id');
        if(date>0){
            var this_class = id.split(" ");
            var request_count = document.getElementById('request_count').innerHTML;
            document.getElementById('request_count').innerHTML = request_count-1;
            setRequestCount();
            $("."+this_class[1]).hide();
        }
        return id;
    }
});

    
// $(function(){
//     $("#unique").click(function(e){
//         e.preventDefault();
//         var datas = $(this).attr('id');
//         console.log('2');
//         //processRemoval(datas);
//         // var date = $(this).parent().attr('id');
//         // if(date>0){
//         //     $("."+id).hide();
//         // }
//         // processInvite(true,id);
//     });
// });

function deleteParticipant(user, election, datediff, status){
    var id=user + "_" + election;
    if(datediff>0){
     document.getElementById(id).style.display = 'none';
    }
    
    var obj = {            
        user:user,
        election:election,
        datediff:datediff,
        status:status
    };
    //console.log(obj);
    //console.log(e);
    //alert(JSON.stringify(obj));
    $.ajax({
        type: 'POST',
        url: '../php/remove.php',
        data: obj,
        success: function(msg) {
            console.log(msg);
        },
        error:function(msg){
            console.log(msg+"error");
        }
    });
}

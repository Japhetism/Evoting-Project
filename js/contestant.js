/**
 * Created by gabriel on 2/5/16.
 */

function myfunction2(){
    var text = document.getElementById('no_of_points').value;
    var dem=document.getElementById('dem');
    if(text>7|| text<1){
        dem.innerHTML = 'Enter a value between 1 and 7';
    }else{
        document.getElementById('dem1').innerHTML="<br>";
        var count=1;
        dem.innerHTML="";
        for(var i=1; i<=text; i++) {
            var manifestoPoint='point'+i;
            dem.innerHTML += "Manifesto point "+count+"<input type='text' class='form-control' maxlength='150' style='width: 100%' name="+manifestoPoint+" required><br>";
            count++;
        }

    }
}
//contestant edit nick or manifestos
function edit(parameter){
    var hide="";
    if(parameter===0){
        //edit nickname
        var nickName=document.getElementById('dem').innerHTML;
        document.getElementById('dem').innerHTML='<input class="form-control" type="text" maxlength="20" name="nick_name" value="'+nickName+'" required></input>';
        hide='nick';
    }else{
        //edit manifestos
        for(var i=0;i<parameter;i++){
            var current='dem'+i;
            var fieldName="manifesto"+i;
            var fieldText=document.getElementById(current).innerHTML;
            document.getElementById(current).innerHTML='<textarea type="text" maxlength="150"  class="form-control" name="'+fieldName+'"  required>'+fieldText+'</textarea><br>';
        }
        hide='manifesto';
    }
    //hide the edit button
    document.getElementById(hide).style.display='none';
}

//contestant change photo
function changePicture(){      
    $('.pictureChange').toggleClass('hide','show');
}

$('.toggleEdit').click(function(){
    $('.editField').toggleClass('hide');
});


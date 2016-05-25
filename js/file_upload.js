/**
 * Created by oyindamola on 3/9/16.
 */

$('input[type="submit"]').prop("disabled", true);
var a=0;
var b=0;
//binds to onchange event of your input field
$('#picture').bind('change', function() {
    if ($('input:submit').attr('disabled',false)) {
        $('input:submit').attr('disabled',true);
    }
    var cancel=$('#picture').val();

    if (cancel!=''){
        var ext = $('#picture').val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['png','jpg','jpeg']) == -1){
            $('#pic_error1').slideDown("slow"); $('#pic_error2').slideUp("slow"); a=0;
        } else {
            var picsize = (this.files[0].size);
            if (picsize > 2000000){
                $('#pic_error2').slideDown("slow"); a=0;
            } else { 
                a=1; $('#pic_error2').slideUp("slow");
            }

            $('#pic_error1').slideUp("slow");

            if (a==1 ) {
                $('input:submit').attr('disabled',false);
            }
        }
    }else{
        $('#pic_error1, #pic_error2').slideUp("slow");
    }
});

$('#citation').bind('change', function() {
    if ($('input:submit').attr('disabled',false)) {
        $('input:submit').attr('disabled',true);
    }
    var ext = $('#citation').val().split('.').pop().toLowerCase();
    if($.inArray(ext, ['pdf']) == -1){ 
        $('#sig_error1').slideDown("slow"); $('#sig_error2').slideUp("slow"); b=0;
    } else {
        var picsize = (this.files[0].size);
        if (picsize > 2000000){ 
            $('#sig_error2').slideDown("slow"); b=0;
        } else {
            b=2; $('#sig_error2').slideUp("slow"); 
        }
        $('#sig_error1').slideUp("slow");
        if (a==1 ) {
            $('input:submit').attr('disabled',false);
        }
    }
});


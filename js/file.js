// jQuery to collapse the navbar on scroll
$(window).scroll(function() {
    if ($(".navbar").offset().top > 50) {
        $(".navbar-fixed-top").addClass("top-nav-collapse");
    } else {
        $(".navbar-fixed-top").removeClass("top-nav-collapse");
    }
});

// jQuery for page scrolling feature - requires jQuery Easing plugin
$(function() {
            
		$('a.page-scroll').bind('click', function(event) {
			var $anchor = $(this);
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});
        $('#page-wrapper').fadeIn(600);
});
$("#formSubmit").click(function(e){
    alert('button clicked');
    e.preventDefault();
    var type = 'POST';
    var php_file = '../php/join.php';
    var data = '#thatForm';
    ajax_submit(type,php_file,data);
});


		// $("#formSubmit").click(function(e){
		// 	e.preventDefault();
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: '../php/join.php',
		// 		data: $("#thatForm").serialize(),
		// 		success: function(msg) {
		// 			console.log(msg);
		// 			var success=document.getElementById('output');
					
		// 			success.innerHTML=msg;
  //                   success.style.color="red";
		// 		},
		// 		error:function(msg){
		// 			console.log(msg+"error");
		// 		}
		// 	});
		// });

		// clear input button
		$('.clear-input').click(function(){
				var disabled = $('input:submit').attr('disabled');
				var input_field = $($(this).attr('target'));
				var required = input_field.prop('required');
				input_field.val('');
				if (required) {
					$('input:submit').attr('disabled',true);
				}else{
					$('input:submit').attr('disabled',false);
				}
				$('#sig_error1, #sig_error2, #pic_error1, #pic_error2').slideUp();
		});

		// display tooltip
		$('i').parent().mouseover(function(){
			if ($(this).children().attr('data-toggle')=='tooltip') {
				$(this).append('<i class="badge" style="display:none">'+$(this).children('i').attr('data-title')+'</i>');
				$('i.badge').fadeIn(800);
			}
		});
		
		$('i').parent().mouseout(function(){
			if ($(this).children().attr('data-toggle')=='tooltip') {
				$(this).children('i.badge').remove();
			}
		});

			





//jQuery for hiding tables
	$('.tableLinks').children().click(function(){
		$('.tables').children().slideUp('slow');
		$('.'+$(this).attr('target')).delay('slow').slideDown('slow');
	});
	
	//show sidebar on links 	
	$(".sideBarSturvs").click(function(){
		$(this).parent().children().removeClass("active1");
		$(this).addClass("active1");
	});

// Closes the Responsive Menu on Menu Item Click
$('.navbar-collapse ul li a').click(function() {
    $('.navbar-toggle:visible').click();
});


//show or hide a div
function showOrHideDiv(div_id){
	var div=document.getElementById(div_id);
	var div_visibility=div.style.display;
	if (div_visibility=='none'){
		div.style.display='block';
	}else{
		div.style.display='none';
	}
}


//toggles password types from text and password 
$('.eyeChange').mousedown(function(){
	$(this).children('#eye').attr('class','fa fa-eye-slash');
	$(this).siblings('.password').attr('type','text');
});

$('.eyeChange').mouseup(function(){
	$(this).children('#eye').attr('class','fa fa-eye');
	$(this).siblings('.password').attr('type','password');
});


//toggles password types from text and password 
function showPassword(element_id,eye_id){
	var eye=document.getElementById(eye_id);
	var eyeicon=eye.getAttribute('class');
	var password=document.getElementById(element_id);
	if (eyeicon=="fa fa-eye"){
	password.setAttribute("type","text");
	eye.setAttribute("class","fa fa-eye-slash");
	}else{
	password.setAttribute("type","password");	
	eye.setAttribute("class","fa fa-eye");
	}
}

//clears modal on joining an election successfully 
function  joinSuccess(){
	document.getElementById('input').innerHTML="Election joined successfully"; 
	document.getElementById('input2').innerHTML=" "; 
	document.getElementById('myModalLabel').innerHTML="";  
}

//show posts for editing
function displayPosts(div_id){
	var posts=document.getElementById(div_id);
	var editPosts=posts.style.display;
	if(editPosts=="none"){
	$('#addPosts').slideDown();
	}else{
	$('#addPosts').slideUp();
	}
}
		
//show textboxes for posts input		
function myfunction(){
	var text = "";
	var text2="";
	text = document.getElementById('number_of_posts').value;
	if(text>20|| text<1){
		document.getElementById('dem').innerHTML = '<span style="color:red;float:left;">Enter a value between 1 and 20</span>';
		document.getElementById('dem1').innerHTML = '';
	}else{
		document.getElementById('dem').innerHTML = 'Post(s)<br>';
		document.getElementById('dem1').innerHTML = 'Pin(s)<br>';


		for(var i=0; i<text; i++) {
			var currentPost='post'+i;
			var currentPin='pin'+i;
			document.getElementById('dem').innerHTML  += "<input class='form-control' id='"+i+"' type='text' name="+currentPost+" required><br>";
			document.getElementById('dem1').innerHTML  += "<input class='form-control' id='"+i+"' type='text' name="+currentPin+" required><br>";
		}

	}
	$('#dem, #dem1, #field_close').slideDown(200);
}
	//display dropdown menu
	
	$('.userActions').click(function(){
		var dropdown = $(this).children('#userOptions');
		dropdown.slideToggle();
	});
	$(document).click(function(){
		$('#userOptions').slideUp();
	});


	function changePassword(){
		var newPassword = document.getElementById('newPassword');
		/*var conNewPassword = document.getElementById('conNewPassword');*/
		var changePassword = document.getElementById('changePassword');
		if (newPassword.style.display=='none') {
			$('#newPassword').slideDown();
			changePassword.innerHTML= 'hide <i class="fa fa-angle-up" style="font-weight:bold;"></i>';
		}else{			
			$('#newPassword').slideUp();
			changePassword.innerHTML= 'change password';
		}

		/*conNewPassword.style.display = 'block';*/
		changeP.style.display = 'none';
	}
	

	//to display the image immediately when selected
	function showPhoto(input) {
        if (input.files && input.files[0]) {
        	var img_src = $('#image').attr('src');
            var reader = new FileReader();

            reader.onload = function (e) {
            	var image_src = input.files[0]['name'];
        		var extension = image_src.split('.').pop().toLowerCase();
            	if (extension == 'jpg' || extension == 'gif' ){
	                $('#image').fadeOut(400,function(){
	                	$('#image')
	                    .attr('src', e.target.result)
	                });
            		$('#imgError').attr('class','text-success').html('<i class="fa fa-check-circle text-success"></i>valid image ( '+input.files[0]['name']+' )').slideDown();
	                $('#image').fadeIn();
            	
            	}else{
            		$('#imgError').attr('class','text-danger').html('<i class="fa fa-close text-danger"></i>Invalid file ( '+input.files[0]['name']+' )').slideDown();
            		$('#image').attr({'src':'',
            						  'alt':''
					});
            	}
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

//meant for post,update and delete news on the same page
function editNews(id){
    var text = document.getElementById(id).innerHTML;
    document.getElementById('modify_news'+id).value = text;
    document.getElementById('getid'+id).value = id;
    var update = document.getElementById('update_news'+id);
    var cancel_delete = document.getElementById('cancel_delete_news'+id);
    var textarea = document.getElementById('modify_news'+id);
    var news = document.getElementById(id);
    var dem = document.getElementById('dem'+id);
    dem.style.display = 'none';
    /*news.style.display = 'none';*/
    textarea.style.display = 'block';
    update.style.display = 'block';
    cancel_delete.style.display = 'block';
    document.getElementById('modify_news'+id).focus();
}

function deleteNews(id){
    var text = document.getElementById(id).innerHTML;
    document.getElementById('modify_news'+id).value = text;
    document.getElementById('getid'+id).value = id;
    var deletes = document.getElementById('delete_news'+id);
    var cancel_delete = document.getElementById('cancel_delete_news'+id);
    var textarea = document.getElementById('modify_news'+id);
    var news = document.getElementById(id);
    var dem = document.getElementById('dem'+id);
    dem.style.display = 'none';
    /*news.style.display = 'none';*/
    textarea.style.display = 'block';
    deletes.style.display = 'block';
    cancel_delete.style.display = 'block';
    document.getElementById('modify_news'+id).disabled=true;

}

function cancelNews(id){
    var update = document.getElementById('update_news'+id);
    var cancel_delete = document.getElementById('cancel_delete_news'+id);
    var textarea = document.getElementById('modify_news'+id);
    var deletes = document.getElementById('delete_news'+id);
    var dem = document.getElementById('dem'+id);
    dem.style.display = 'block';
    textarea.style.display = 'none';
    update.style.display = 'none';
    cancel_delete.style.display = 'none';
    deletes.style.display = 'none';

    document.getElementById('modify_news'+id).disabled=false;
}
	
function confirmPassword(){
	var newP = document.getElementById('confirmNew').value;
	var old = document.getElementById('new').value;
	if (newP!=old) {
		$('#hello').removeClass('text-success');
		document.getElementById('hello').innerHTML='<i class="text-danger fa fa-close"></i>passwords do not match';
		$('#hello').slideDown();
	}else{
		$('#hello').addClass('text-success');
		document.getElementById('hello').innerHTML='<i class="text-success fa fa-check-circle"></i>passwords match';
	}
}

function displayContent(){
		$('#dateButton, d').fadeOut(400,function(){
    	$('d').remove();
        	$('#datePicker1, #datePicker2, #timeStart, #timeEnd').fadeIn();
    	});
}

function getScreenHeight(){
	return screen.availHeight;
}


function ajax_submit(type,php_file,data){
            $.ajax({
                type: type,
                url: php_file,
                data: $(data).serialize(),
                success: function(msg) {
                    console.log(msg);
                    var success=document.getElementById('output');
                    
                    success.innerHTML=msg;
                    success.style.color="red";
                },
                error:function(msg){
                    console.log(msg+"error");
                }
            });
}

        $('.load_cover, #load_cover').fadeOut();
        $('.load_cover, #load_cover').children('i').fadeOut();


			// image preview function		
            $('img.preview').hover(function(){
                    var image = $(this);
                    image.parent().append('<i class="preview-img" style="display:none"><img src='+image.attr('src')+' width="80px" height="100px" </i>');
                    $('i.preview-img').fadeIn();
                },function(){
                    $(this).siblings().remove('i.preview-img');
                }
            );


            $('img.preview').bind('click', function(){
                var imagesrc = '<img src="'+$(this).attr('src')+'" width="98%" height="480px" style="">';
                $('.content').html(imagesrc);
                $('.blanket').fadeIn(400,function(){
                    $('.content').animate({'top':'5%'});
                });
            });

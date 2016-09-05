<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E-voting | Password Reset</title>


    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../images/logo.png" rel="icon">



    <!-- Custom CSS for body-->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../fontawesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
    	body{
    		background: url("../images/voting1.jpg") center fixed no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            overflow-x: hidden;
    	}
        .container-fluid{
            background: rgba(0,0,0,0.6);
            height: 100vh;
            padding-top: 100px;
            width: 100vw;
            overflow-x: hidden;
        }
    	form{
    		box-shadow: 0px 4px 6px rgba(0,0,0,0.2);
    		padding: 10px 10px;
    		background-color: white;
    	}
        h4{
            margin-top: 0;
            margin-bottom: 20px;
            border-bottom: dashed #ccc 1px;
            border-top: dashed #ccc 1px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
    	<div class="col-sm-10 col-sm-offset-1 col-md-4 col-md-offset-4">
	    	<form>
	    		<h4 class="text-center alert-success">Reset Password</h4>
	    		<fieldset>
	    			<br>
	    			<input type="email" name="" disabled="disabled" value="<!-- echo person's email address here -->" class="form-control">
	    			<br>
	    			<input type="text" name="" class="form-control" placeholder="Enter new password">
	    			<br>
	    			<input type="text" name="" class="form-control" placeholder="Confirm new password">
	    			<br>
	    			<input type="submit" value="SAVE" name="" class="btn btn-block btn-success">
	    		</fieldset>
	    		<br>
	    		<span class="text-center" style="font-size: 20px;display: block;">or login <a href="index.php#login">here</a></span>
	    	</form>
    	</div>
    </div>
</body>
</html>
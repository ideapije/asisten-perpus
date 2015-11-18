<?php ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Digital Asistan Library</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css" media="screen"/>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-theme.min.css" type="text/css" media="screen"/>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.css" type="text/css" media="screen"/>
	<!--<link rel="stylesheet" href="<?php //echo base_url();?>assets/css/customs.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/uikit.min.css" type="text/css" media="screen"/>
    -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/grid-style.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/sticky-footer.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/rating.css" type="text/css" media="screen"/>
    
  
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>  
	<style type="text/css">
	body {
     	margin: 0;
     	background:url('<?php echo base_url();?>assets/gambar/bg.jpg');
     	background-position: center center;
     	background-repeat:no-repeat;
     	background-attachment:fixed;
     	background-size: cover;
     	background-color: #464646;	
        overflow:hidden;
     	/*background-size: 1440px 800px;
    	display: compact;
     	font: 13px/18px "Helvetica Neue", Helvetica, Arial, sans-serif;*/
	}
  .container .jumbotron, .container-fluid .jumbotron {
    border-radius: 0px;
  }
  .jumbotron .h1, .jumbotron h1 {
  font-size: 50px;
}
  @media screen and (min-width: 768px){
    .jumbotron {
       padding: 0px 0;
    }
  }
    .media-object {
        max-width: 150px;
        max-height: 110px;
    }
    .media {
        margin-top: 10px;
    }
    .carousel-caption {
        color: #161616;
        text-align: right;
        right: 15%;
    }
    @media only screen and (max-width: 1020px){
        body{
            overflow:scroll;
        }
    }
    @media only screen and (max-width: 920px){
        body{
            overflow:scroll;
        }
    }
    @media only screen and (max-width: 760px){
        body{
            overflow:scroll;
        }
    }
    @media only screen and (max-width: 667px){
        body{
            overflow:scroll;
        }
    }
	@media only screen and (max-width: 320px){
        body{
            overflow:scroll;
        }
		.media-body, .media-left, .media-right{
			display: block;
		}	
	}
.navbar2-header {
  background-color: #FFF;
}
.navbar2-default .navbar2-brand {
  
  color: #fff;
}
  .navbar2-inverse .navbar2-brand {
    background-color: #22A7F0;
    color: #fff;
  }
  @media (min-width: 768px) {
  .navbar2-collapse {
    height: auto;
    border-top: 0;
    box-shadow: none;
    max-height: none;
    padding-left:0;
    padding-right:0;
  }
  .navbar2-collapse.collapse {
    display: block !important;
    width: auto !important;
    padding-bottom: 0;
    overflow: visible !important;
  }
  .navbar2-collapse.in {
    overflow-x: visible;
  }

.navbar2
{
  max-width:300px;
  margin-right: 0;
  margin-left: 0;
} 

.navbar2-nav,
.navbar2-nav > li,
.navbar2-left,
.navbar2-right,
.navbar2-header
{float:none !important;}

.navbar2-right .dropdown-menu {left:0;right:auto;}
.navbar2-collapse .navbar2-nav.navbar2-right:last-child {
    margin-right: 0;
}
}

.col-item .info .rating
{
    color: #777;
}

.col-item .rating
{
    /*width: 50%;*/
    float: left;
    font-size: 17px;
    text-align: right;
    line-height: 52px;
    margin-bottom: 10px;
    height: 52px;
}

.col-item .separator
{
    border-top: 1px solid #E1E1E1;
}

.clear-left
{
    clear: left;
}

.col-item .separator p
{
    line-height: 20px;
    margin-bottom: 0;
    margin-top: 10px;
    text-align: center;
}

.col-item .separator p i
{
    margin-right: 5px;
}
.col-item .btn-add
{
    width: 50%;
    float: left;
}

.col-item .btn-add
{
    border-right: 1px solid #E1E1E1;
}

.col-item .btn-details
{
    width: 50%;
    float: left;
    padding-left: 10px;
}
.controls
{
    margin-top: 20px;
}
.container {
  width: auto;
  max-width: 1080px;
  padding: 0 15px;
}
.well-lg{
    border-radius:0px;
}


.thumbnail, .img-thumbnail {
    max-width: 135px;
    max-height: 175px;
}
.bs-docs-header {
position: relative;
padding: 30px 15px;
color: #cdbfe3;
text-align: center;
text-shadow: 0 1px 0 rgba(0,0,0,.1);
background-color: #338cd9;
}
.bs-docs-header {
font-size: 20px;
}
	</style>
	</head>
	<body onload="<?php echo(isset($_GET['m']) || isset($_GET['r']))? 'loadmres()' : ''; ?>">
<div id="wrap">
<div class="container" >
        
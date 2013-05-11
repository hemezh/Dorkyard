<!DOCTYPE html>
<?php
	require_once("template.php");
	print_r($_GET);
	echo $postCount=$_GET["id"]."asS";
	if($postCount="" ||  ($row=getMessage($postCount))==false )
		header('Location: ../home/');
?>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<title>Welcome to Dorkyard</title>
	<meta property="og:title" content="Post #<?php echo $postcount; ?> " />
	<meta property="og:type" content="" />
	<meta property="og:url" content="www.dorkyard.com/post/<?php echo $postcount; ?>" />
	<meta property="og:image" content="" />
	<meta property="og:site_name" content="Dorkyard.com" />
	<link rel="stylesheet" href="stylesheets/foundation.min.css">
	<link rel="stylesheet" href="stylesheets/app.css">
	<link rel="stylesheet" href="stylesheets/main.css">
	<script src="javascripts/modernizr.foundation.js"></script>
	<script src="javascripts/jquery.js"></script>
	<!-- start Mixpanel --><script type="text/javascript">(function(e,b){if(!b.__SV){var a,f,i,g;window.mixpanel=b;a=e.createElement("script");a.type="text/javascript";a.async=!0;a.src=("https:"===e.location.protocol?"https:":"http:")+'//cdn.mxpnl.com/libs/mixpanel-2.2.min.js';f=e.getElementsByTagName("script")[0];f.parentNode.insertBefore(a,f);b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==
typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,
e,d])};b.__SV=1.2}})(document,window.mixpanel||[]);
mixpanel.init("4c02dc06f6c6865fed3063f245b61f95");</script><!-- end Mixpanel -->
	
</head>
<body onload="logging()">
<div class="row top-bar-wrap">
  <div class="twelve columns">
    <nav class="top-bar">
      <ul>
        <!-- Title Area -->
        <li class="name">
          <h1>
            <a href="#">
              Dorkyard
            </a>
          </h1>
        </li>
        <li class="toggle-topbar"><a href="#"></a></li>
      </ul>

      <section>
        <!-- Left Nav Section -->
        <ul class="left">
          <li class="divider"></li>
          <li class="">
            <a class="active" href="./">Home</a>

          <li class="divider"></li>
          </li>
            </ul>
          <li class="divider hide-for-small"></li>
        </ul>

        <!-- Right Nav Section -->
        <ul class="right">
        	<li class="login">
        		<a class="button small" onclick="login()">Sign In</a>
        	</li>
        	<li class="logout">
        		<a class="button small" onclick="logout()">Logout</a>
        	</li>
        </ul>
      </section>
    </nav>
  </div>
</div>
<div class="row">	  	
	<div class="eight columns mainbar">

		<?php 
				viewPost($row);
		?>
		<div class="fb-comments" data-href="http://9gag.com/gag/6319105" data-width="611" data-num-posts="10"></div>
		
	</div>
	<?php 
	rightbar();
	?>
	<div class="feedback-button">
	    <a href="/contact" target="_blank" >Feedback</a>
	</div>
</div><div class="fb-root"></div>
<script src="javascripts/connect.js"></script>
</body>
</html>

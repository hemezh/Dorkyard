<?php
	
	require_once("user_activity.php");
		
	function rightbar() {
		echo '
			<div class="four columns rightbar">
				<div class="panel">					
					<h2 class="blue">'. getTotalPosts() .'</h2>
					posts and counting..
				</div>
				<div class="social">
					<a href="https://twitter.com/hemezh" class="twitter-follow-button" data-show-count="true" data-show-screen-name="false">Follow @hemezh</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					<div class="fb-like" data-href="http://www.facebook.com/Dorkyard" data-send="false" data-width="400" data-show-faces="false" data-layout="button_count"></div>
				</div>
				<div class="panel">
					<h2 class="blue about">
						Have something to share ?
					</h2>
					<p>Life is a bitch! Ever did/thought/wished for something interesting? Why not share it being anonymous?</p>
		        </div>
		        <div class="footer">
		        	&copy; 2013 Dorkyard.com
		        </div>
			</div>
			<a href="https://mixpanel.com/f/partner" class="mixpanel"><img src="//cdn.mxpnl.com/site_media/images/partner/badge_light.png" alt="Mobile Analytics" /></a>
		';
	} 
	function viewPost($row) {
		extract($row);
		?>
		<div class="panel postwrap">
			<div class="posttitle">
				<a href="./post.php?id=<?php echo $postcount; ?>">Post #<?php echo $postcount; ?></a>
			</div>
			<div class="posttime">
				<?php echo timeago(date('Y-m-d H:i:s',time()),$time); ?> 
			</div>
			<div class="post">		
			<?php echo $message; ?>
			</div>
			<div class="cb">
				<ul class="inline-list left" >
					<li class="left">
						<div class="icon-thumbs-up" postid="<?php echo $messageid; ?>" ></div>
					</li>
					<li class="left count" id="ucount-<?php echo $messageid; ?>">
						<?php echo $likes; ?>
					</li>
					<li class="left">					
						<div class="icon-thumbs-down" postid="<?php echo $messageid; ?>" ></div>
					</li>
					<li class="left count" id="dcount-<?php echo $messageid; ?>">
						<?php echo $dislikes; ?>
					</li>
					<li class="left">					
						<a href="./post.php?id=<?php echo $postcount; ?>"><div class="icon-cmnt" postid="<?php echo $messageid; ?>" ></div></a>
					</li>
					<li class="left count" id="dcount-<?php echo $messageid; ?>">
						<?php echo $dislikes; ?>
					</li>		
					<li class="right">					
						<div class="icon-fb" data-name="Dorkyard.com : Post #<?php echo $postcount; ?>" data-url="http://www.dorkyard.com/post.php?id=<?php echo $postcount; ?>" data-content="<?php echo $message; ?>"></div>
					</li>
					<li class="right">	
					<a href="javascript:(function(){window.twttr=window.twttr||{};var D=550,A=450,C=screen.height,B=screen.width,H=Math.round((B/2)-(D/2)),G=0,F=document,E;if(C>A){G=Math.round((C/2)-(A/2))}window.twttr.shareWin=window.open('http://twitter.com/share?url=www.dorkyard.com/post/<?php echo $postcount; ?>&text=<?php echo $message; ?>&via=dorkyard','','left='+H+',top='+G+',width='+D+',height='+A+',
personalbar=0,toolbar=0,scrollbars=1,resizable=1');E=F.createElement('script');E.src='http://platform.twitter.com/widgets.js';F.getElementsByTagName('head')[0].appendChild(E)}());
">						<div class="icon-twt">
						</div>
					</a> 
					</li>
				</ul>
			</div>
					
		</div>
		<?php 
	}
	function getMorePosts($category,$start,$end=10) {
                $result=getMessages($category,$start,$end);
                while($row=mysql_fetch_array($result)) {
                viewPost($row);
                }
        }

     
?>

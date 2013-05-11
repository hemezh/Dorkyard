
window.fbAsyncInit = function() {
  console.log(FB);
    FB.init({
      appId      : '213604222115766', // App ID
      //channelUrl : '//localhost/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true,  // parse XFBML
      logging    : true,
      oauth      : true
    });
    FB.getLoginStatus(function(response){
      if(response.status==='connected'){
          $('.login').hide();
          $('.logout').show();        
      }
    });
};

function fblogin(){
  FB.getLoginStatus(function(response){
    if(response.status==='connected'){
      console.log(response);
      $('.login').css('display','none');
      $('.logout').css('display','block');
    }
    else{
      fblogging();  
    }
  });
}

function isAuthenticated(){
  var userid;
  FB.getLoginStatus(function(response){
    if(response.status==='connected'){
      userid=response.authResponse.userID;
    }
    else{
      return false;
    }
  });
  return userid;
}
function fblogging() {
    FB.login(function(response) {
        if (response.authResponse) {
          console.log(response.authResponse);
          var name,email;
          FB.api('/me', function(response) {
            name=response.name;
            email=response.email;            
            var userid=response.id;
            $.ajax({
              type:"POST",
              url :"process.php",
              data:{'userid':userid,'name':name,'email':email,file:'register'}
              }).done(function(data){
                console.log('session not created');
            }); 
            $('.login').css('display','none');
            $('.logout').css('display','block');
          });
        } 
    },{scope:'email,publish_actions'});
}

function fblogout(){
  FB.logout(function(response){
    console.log(response);
    $('.login').css('display','block');
    $('.logout').css('display','none');
  });
} 

function vote(type,act,clas,postId){
  var userid=isAuthenticated();
  mixpanel.track('vote');
  if (userid){
    $.ajax({
      type: "POST",
      url: "process.php",
      data: { id: userid, category: type , action: act,file:'vote' ,postid:postId}
      }).done(function( data) {
          var count=data.split(':');
          $('#ucount-'+postId).text(count[0]);
          $('#dcount-'+postId).text(count[1]);
    });
  }
  else{
        alert('you need to log in to upvote or downvote the content');
  }
}
function replaceAll(find, replace, str) {
  return str.replace(new RegExp(find, 'g'), replace);
}
function post(typ,data){
  mixpanel.track('post');
  $.ajax({
      type: "POST",
      url: "process.php",
      data: {category: typ , content:data,file:'post' }
      }).done(function( data) {
        $('.postres').show();
        $('.inpbox').text('Write your post here.. Use #tags to');
    });
}

(function(d){
     var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement('script'); js.id = id; js.async = true;
     js.src = "//connect.facebook.net/en_US/all.js";
     ref.parentNode.insertBefore(js, ref);
}(document,false));


$(document).ready(function(){
  var poststr=$(".inpbox").text();
  var category = "1";
  var postStart=10,postCount=10;
  $('.icon-thumbs-up').click(function(){
    var pid=$(this).attr('postid');
    vote(category,'like','.ucount',pid);
  });

  $('.icon-thumbs-down').click(function(){
    var pid=$(this).attr('postid');
    vote(category,'dislike','.dcount',pid);
  });

  $('.postbtn').click(function(){
    var content=$('.inpbox').val();
    content = replaceAll("\n", "<br>", content);
    post(category,content);
  });
  $('.inpbox').on('focus',function(){
    if($(this).text()==poststr){
      $(this).text("");
    }
  });
  $(".icon-fb").on('click', function(e){
    e.preventDefault();
    FB.ui({
      method: 'feed',
      name: $(this).data('name'),
      link: $(this).data('url'),
      picture: '',
      description: $(this).data('content')
    });
  });
  $(window).scroll(function(){
      if($(window).scrollTop() == $(document).height() - $(window).height()){
          $('div#loader').show();
          
          $.ajax({
            type:"POST",
            data:{"start":postStart, "count":postCount, file:"paginate"},
            url: "process.php"
          }).done(function(html){
              if(html){
                  postStart = postStart+10;
                  $("#loader").before(html);
                  $('div#loader').hide();
              }else{
                  $('div#loader').html('<strong><center>No More Posts to Show.</center></strong>');
              }
          });
      }
  });
});

<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  <title>Eva Bot By Akshay N Shaju</title>
  
  
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-design/4.0.2/bootstrap-material-design.css'>
	    <script src="web/js/jquery.js" type="text/javascript"></script>

<link rel='stylesheet prefetch' href='https://fonts.googleapis.com/icon?family=Material+Icons'>

      <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript">
        $(document).ready(function () {
						$('#think').hide();

            var localUrl = window.location.href;
            localUrl = localUrl.replace('web/', '');

			
            var webServiceUrl = window.location.href + 'api.php';
            console.log(webServiceUrl);
            $('.clean').click(function () {

                Clear();
                AddText('system ', 'cleaning...');

                $('.userMessage').hide();

                $.ajax({
                    type: "GET",
                    url: webServiceUrl,
                    data: {
                        requestType: 'forget'
                    },
                    success: function (response) {
                        AddText('system ', 'Ok!');
                        $('.userMessage').show();
                    },
                    error: function (request, status, error) {
                        Clear();
                        alert('error');
                        $('.userMessage').show();
                    }
                });
            });


            $('#fMessage').submit(function () {

                // get user input
                var userInput = $('input[name="userInput"]').val();

                // basic check
                if (userInput == '')
                    return false;
                //

                // clear
                $('input[name="userInput"]').val('');

                // hide button
//                $(this).hide();
				$('#think').show();

				var type;
                // show user input
				AddText('self', userInput);  
               

                $.ajax({
                    type: "GET",
                    url: webServiceUrl,
                    data: {
                        userInput: userInput,
                        requestType: 'talk'
                    },
                    success: function (response) {
                        console.log(webServiceUrl);
                        console.log(userInput);
                        AddText('user', response.message);
						$('#think').hide();
                        $('#fMessage').show();
                        $('input[name="userInput"]').focus();
                    },
                    error: function (request, status, error) {
                        console.log(error);
                        alert('error');
                        $('#fMessage').show();
						
                    }
                });

                return false;
            });

            function Clear() {
                $('.chatBox').html('');
            }

            function AddText(user, message) {
                console.log(user);
                console.log(message);
				
                var div = $('<div>');
                var name = $('<labe>').addClass('name');
                var text = $('<span>').addClass('message');

                name.text(user + ':');
                text.text('\t' + message);
	var INDEX =0;
				var imgurl = '<img src=\"img\/user.png\">';
	var type = user;
				if(type=='user')
					{
						var imgurl = '<img src=\"img\/eva.jpg\">';
					}
	INDEX++;
    var str="";
    str += "<div id='cm-msg-"+INDEX+"' class=\"chat-msg "+type+"\">";
    str += "          <span class=\"msg-avatar\">";
    str += imgurl;
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += message;
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-"+INDEX).hide().fadeIn(300);
    if(type == 'self'){
     $("#chat-input").val(''); 
    }    
    $(".chat-logs").stop().animate({ scrollTop: $(".chat-logs")[0].scrollHeight}, 1000);  
				
				

                div.append(name);
                div.append(text);
				
                $('.chatBox').append(div);

                $('.chatBox').scrollTop($(".chatBox").scrollTop() + 100);
            }


        });
    </script>

  
</head>

<body>

  <div id="center-text">
    <h2>Eva</h2>
    <p>An AI Driven chatbot</p>
  </div> 
<div id="body"> 
  
<div id="chat-circle" class="btn btn-raised">
        <div id="chat-overlay"></div>
		    <i class="material-icons">speaker_phone</i>
	</div>
  
  <div class="chat-box">
    <div class="chat-box-header">
      Akshay's ChatBot
      <span class="chat-box-toggle"><i class="material-icons">close</i></span>
    </div>
    <div class="chat-box-body">
      <div class="chat-box-overlay">   
      </div>
      <div class="chat-logs">
<!--chat-log -->
		  <style>
		  
/* LOADING DOTS VERSION #3 */
.version3 .loading:after {
  overflow: hidden;
  display: inline-block;
  vertical-align: bottom;
  -webkit-animation: ellipsis steps(4,end) 900ms infinite;      
  animation: ellipsis steps(4,end) 900ms infinite;
  content: "\2026"; /* ascii code for the ellipsis character */
  width: 0px;
}

@keyframes ellipsis { /* Add @-webkit-keyframes for webkit support */
  to {
    width: 1.25em;    
  }
}




		  </style>
    </div><div id="think" class="version3"><div class="loading" style="padding-left: 18px;color:  grey;">Eva is thinking</div></div>
    <div id="box2" class="chat-input userMessage">      
      <form id="fMessage">
        <input type="text" id="userInput" name="userInput" placeholder="Send a message..."/>
      <button type="submit" class="chat-submit" id="submit"><i class="material-icons send">send</i></button>
      </form>      
    </div>
  </div>
  
  
  
  
</div>
<!--  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>-->
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/js/bootstrap.min.js'></script>

  

    <script  src="js/index.js"></script>


	</div>

</body>
</html>

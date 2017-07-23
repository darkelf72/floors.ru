<?php header("Content-Type: text/html; charset=utf-8");?>
<!DOCTYPE hmtl>
<html>
<head>
    <meta charset="utf-8">
    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript">
        $(function(){
            function login(){
                if($.cookie("username") == null){
                    $("#username").val("");
                    $("#username").prop("disabled", false);
                    $("#login").val("login");
                    $("#sendForm").hide();
                    $("#username").focus();                    
                }
                else {
                    $("#username").val($.cookie("username"));
                    $("#username").prop("disabled", true);
                    $("#login").val("logout");
                    $("#sendForm").show(); 
                    $("#message").val("");
                    $("#message").focus(); 
                };
            }
            login();

            var messageid = 0; //id последнего сообщения

            function getChat(){
                var roomname = $("#rooms").val();
                var username = $.cookie("username");
                $.ajax({
                    method: "GET",    
                    url: "php/ajax.php",
                    dataType: 'json',
                    data: {method: "getChat", messageid: messageid, roomname: roomname, username: username}
                })
                .done(function(msg){
                    if (messageid == 0) $("#messageBox ul").empty();
                    if (msg.length == 0) return;
                    messageid = msg[msg.length-1].id;
                    //alert(messageid);
                    for(var i=0; i<msg.length; i++){
                        $("#messageBox ul").append("<li><b>"+msg[i].username+"</b>: "+msg[i].message+"</li>");
                    }
                    $("#messageBox").scrollTop($("#messageBox").prop("scrollHeight"));                    
                });
                setTimeout(arguments.callee, 2000);
            };
            getChat();
            //setInterval(getChat, 2000);

            function sendMessage(){
                var message = $("#message").val();
                var roomname = $("#rooms").val();
                var username = $.cookie("username"); 
                $("#message").val("");
                $.ajax({
                    method: "POST",    
                    url: "php/ajax.php",
                    data: {method: "sendMessage", message: message, roomname: roomname, username: username}
                })
                .done(function(msg){                                    
                    //getChat();
                    //$("#message").val("");
                });            
            };

            $("#loginForm").submit(function(){
                if ($("#username").val() == "") return;
                if ($("#login").val() == "login"){
                    $.cookie("username", $("#username").val());
                }
                else{
                    $.removeCookie("username");
                };
                login();
            });            

            $("#sendForm").submit(function(){
                if ($("#message").val() == "") return;
                sendMessage();
            });

            $("#rooms").change(function(){
                messageid = 0;
                //getChat();
            });
        });
    </script>
</head>
<body>
    <?php require_once "php/chatif.php";
        $chat = new Chat();
    ?>
    <form id="loginForm" onsubmit="return false;">    
        <input type="text" id="username" placeholder="Your login">
        <input type="submit" id="login" style="margin-top:5px;">
    </form>
    <form>
        <div id="messageBox">
            <ul></ul>
        </div>
        <div id="sidebar">
            <p>Rooms:</p>
            <select id="rooms" size = "10">
                <?php
                    $rooms = $chat->getRooms();    
                    for($i=0; $i<count($rooms); $i++){
                        if ($i==0){
                            echo "<option selected>".$rooms[$i]["name"]."</option>";    
                        }
                        else{
                            echo "<option>".$rooms[$i]["name"]."</option>";
                        }
                    };
                ?>
            </select>
            <p>Blocked users:</p>
            <select id="blocked" size="10" disabled="true"> 
                <?php
                    $blocked = $chat->getBlocked();    
                    for($i=0; $i<count($blocked); $i++){
                        echo "<option>".$blocked[$i]["username"]."</option>";
                    };
                ?>    
            </select>
        </div>
    </form>
    <form id="sendForm" onsubmit="return false;" hidden>    
        <input type="text" id="message" placeholder="Type the message">
        <input type="submit" value="send">
    </form>
</body>
</html>
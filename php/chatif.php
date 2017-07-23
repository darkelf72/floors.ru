<?php
interface ChatIF{
    public function getRooms();
    public function getBlocked();
    public function getChat();
    public function sendMessage();
}

class Chat implements ChatIF{
    private function createConnection(){ 
        $link = pg_connect("host=localhost port=5432 dbname=floors user=postgres");
        return $link;
    }

    public function getRooms(){
        $link = $this->createConnection();
        $query = "SELECT id, name FROM room;";
        $result = pg_query($link, $query);
        $array = array();
        while($row = pg_fetch_assoc($result)){
            $array[] = array("id"=>$row['id'],"name"=>$row['name']);
        }
        pg_close($link);
        //echo json_encode($array);
        return $array;
    }

    public function getBlocked(){
        $link = $this->createConnection();
        $query = "SELECT id, username FROM blocked;";
        $result = pg_query($link, $query);
        $array = array();
        while($row = pg_fetch_assoc($result)){
            $array[] = array("id"=>$row['id'],"username"=>$row['username']);
        }
        pg_close($link);
        //echo json_encode($array);
        return $array;
    }

    public function getChat(){
        $messageid = $_GET['messageid']; 
        $username = $_GET['username'];
        $roomname = $_GET['roomname'];
        $link = $this->createConnection();       
        $query = "SELECT c.id, c.message, c.timedate, c.roomname, c.username
                FROM chat c                
                WHERE c.roomname='".$roomname."' AND c.id>".$messageid."
                AND (c.username='".$username ."' OR c.username not in (SELECT b.username FROM blocked b));";
        $result = pg_query($link, $query);
        $array = array();
        while($row = pg_fetch_assoc($result)){
            $array[] = array("id"=>$row['id'],"timedate"=>$row['timedate'],"message"=>$row['message'],"roomname"=>$row['roomname'],"username"=>$row['username']);
        }
        pg_close($link);
        //echo $query;
        echo json_encode($array);
    }

    public function sendMessage(){
        $message = $_POST['message'];
        $username = $_POST['username'];
        $roomname = $_POST['roomname'];     
        $link = $this->createConnection();
        $query = "INSERT INTO chat (message, timedate, roomname, username) VALUES ('".$message."',Now(),'".$roomname."','".$username."');";
        $result = pg_query($link, $query);
        pg_close($link);
    }
}
?>
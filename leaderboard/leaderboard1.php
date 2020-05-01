<?php
include "../config/connect.php";
$userRanking = [];
//user class for each fetched user
class User
{
    public $nickname;
    public $track;
    public $level;
    public $score;

    function __construct($nickname,$track,$level,$score){
    $this->nickname = $nickname;
    $this->track = $track;
    $this->level = $level;
    $this->score = $score;
    }
}

//categories for filter 
if (isset($_GET['track']) and isset($_GET['level']) and $_GET['level'] !== 'general') {
    $track = $_GET['track'];
    $level = $_GET['level'];    
    $sql = "SELECT * FROM leaderboard WHERE `track`='$track' AND `level` = '$level' ORDER BY `score` DESC LIMIT 20";
}
elseif (isset($_GET['track']) and $_GET['track'] == 'general' and isset($_GET['level'])) {
    $level = $_GET['level'];    
    $sql = "SELECT * FROM leaderboard WHERE `level` = '$level' ORDER BY `score` DESC LIMIT 20";

}
elseif (isset($_GET['track']) and $_GET['track'] == 'general' and !isset($_GET['level'])) {    
    $sql = "SELECT * FROM leaderboard ORDER BY `score` DESC LIMIT 20";

}
elseif (isset($_GET['track']) and !isset($_GET['level'])) {
    $track = $_GET['track'];    
    $sql = "SELECT * FROM leaderboard WHERE `track`='$track' ORDER BY `score` DESC LIMIT 20";
}
elseif (!isset($_GET['track']) and isset($_GET['level'])) {
    $level = $_GET['level'];    
    $sql = "SELECT * FROM leaderboard WHERE AND `level` = '$level' ORDER BY score DESC LIMIT 20";
}
else {    
    $sql = "SELECT * FROM leaderboard ORDER BY `score` DESC LIMIT 20";
}
$result = mysqli_query($conn,$sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $nickname = $row['nickname'];
        $track = $row['track'];
        $level = $row['level'];
        $score = $row['score'];
        $user = new User($nickname,$track,$level,$score);
        array_push($userRanking,$user);
    }
}else{
    die('error fetching rankings please try again later');
}
print_r($userRanking);

 ?>
 <!DOCTYPE html>
<html>
    <head>
      <link rel="stylesheet" href="./index.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <link rel="shortcut icon" href="https://30daysofcode.xyz/favicon.png" type="image/x-icon">
    </head>
    <body>
      <div class="filter">
        <form id="filterform" action="leaderboard1.php" method="GET">
          <select name="level" id="filter" class="form-control">
           <option value="beginner">Beginner</option>
           <option value="intermediate">Intermediate</option>
          </select>
          <button type="submit" class="btn btn-warning">Filter</button>          
        </form>
      </div>
      <div class="center">
        <div class="top3">
          <div class="two item">
            <div class="pos">
              2
            </div>
            <div class="pic" style="background-image: url(&#39;https://randomuser.me/api/portraits/men/44.jpg&#39;)"></div>
            <div class="name">
              Ifihan Olusheye
            </div>
            <div class="track">empty</div>
            <div class="score">
              30
            </div>
          </div>
          <div class="one item">
            <div class="pos">
              1
            </div>
            <div class="pic" style="background-image: url(&#39;https://randomuser.me/api/portraits/men/31.jpg&#39;)"></div>
            <div class="name">
              Geektutor
            </div>
            <div class="track"></div>
            <div class="score">
              10
            </div>
          </div>
          <div class="three item">
            <div class="pos">
              3
            </div>
            <div class="pic" style="background-image: url(&#39;https://randomuser.me/api/portraits/women/91.jpg&#39;)"></div>
            <div class="name">
              Akin Aguda
            </div>
            <div class="track"></div>
            <div class="score">
              50
            </div>
          </div>
        </div>
          <div class="list others">
          </div>
        </div>
      <script src="leaderboard.js"></script>
    </body>
</html>

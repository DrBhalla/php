<?php
    require('config.php');
    unset($_SESSION["tab"]);
    unset($_SESSION["employee"]);
    unset($_SESSION["agreement"]);
    if(!isset($_SESSION['user'])){
        header('Location: login.php');
        exit;
    }
    else{
        if(isset($_GET['finYear'])){
            $_SESSION['finYear'] = $_GET['finYear'];
        }
        else{
            $_SESSION['finYear'] = $_SESSION['finYear'];
        }
        unset($_SESSION['godown']);
        if(isset($_POST['addGodown'])){
            $username = $_SESSION['user'];
            $godown = $_POST['godownName'];
            $finYear = $_SESSION['finYear'];
            $sql = "INSERT INTO godowns (godown, username, finYear) VALUES ('$godown', '$username', '$finYear')";
            if ($conn->query($sql) === TRUE) {
                
            }
            else{
                echo "<h4 style='text-align: center;'>Godown Could Not be Added</h4>";
            }
        }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godown</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body{
            background: #d2ae6d;
            overflow: auto;
            color: #373435;
            font-family: 'Times New Roman', Times, serif;
        }
        #main{
            width: 86vw;
            min-height: 90vh;
            margin: 5vh auto;
            border: 0.5px solid #433e39;
            background: #fffbd6;
            border-radius: 5vw;
            padding: 3%;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            grid-gap: 3% 2%;
            justify-items: stretch;
            overflow: auto;
        }
        .button{
            margin: 0 auto;
            padding: 5% 15%;
            background: #d2ae6d;
            font-size: 26px;
            border: 1px solid #433e39;
            border-radius: 5px;
            cursor: pointer;
            min-width: 23vw;
        }
        a{
            all: unset;
        }
        #heading{
            grid-column: 1/4;
            text-align: center;
        }
        .inner{
            justify-self: center;
        }
        .addButton, .deleteButton{
            padding: 0.65% 2%;
            margin: 5px;
            color: #fefefe;
            background-color: dodgerblue;
            border: none;
            border-radius: 5px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            cursor: pointer;
        }
        .deleteButton{
            background-color: red;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.8);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @keyframes example {
            0%   {margin-top: -15%;}
            100% {margin-top: 5%}
        }

        .modal-content {
            background-color: #fffbd6;
            margin: 5% auto;
            padding: 10px;
            border: 1px solid #373435;
            width: 60%;
            border-radius: 15px;
            animation: example 0.3s ease-out;
        }

        .close{
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: 900;
            margin-right: 8px;
        }

        .close:hover, .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-label, .modal-input{
            font-size: 18px;
            font-weight: 500;
        }

        hr{
            width: 85%;
            border-bottom: 1px solid #d2ae6d;
        }

        .button1{
            margin: 25px auto;
            color: #fefefe;
            background: #a45e4d;
            padding: 5px 30px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: block;
        }
        .heading{
            text-align: center;
            font-size: 26px;
            color: #5ca47a;
            margin: 2% auto;
        }
        .error{
            text-align: center;
            color: #a45e4d;
            margin: -3px auto;
        }

        .delete{
            margin: 25px;
            color: #fefefe;
            background: #a45e4d;
            padding: 8px 20px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            display: inline;
        }

        @media screen and (max-width: 700px){
            #main{
                grid-template-columns: 1fr 1fr !important;
            }
            #heading{
                grid-column: 1/3;
            }
            .button{
                min-width: 37vw;
            }
            .modal-content {
                width: 90%;
            }
        }
        @media screen and (max-width: 470px){
            
            #main{
                grid-template-columns: 1fr !important;
            }

            #heading{
                grid-column: 1/2;
            }
            .button{
                min-width: 65vw;
            }
            .modal-input{
                display: block;
            }
        }


    </style>
</head>
<body>
    <div id="main">
        <h1 id="heading">List of Godown's <button class="addButton" id="myBtn"> + Add New</button> <button class="deleteButton" id="myBtn1"> - Delete Godown</button></h1>
        <?php
            $user = $_SESSION['user'];
            $finYear = $_SESSION['finYear'];
            $sql = "SELECT * FROM godowns WHERE username='$user' AND finYear='$finYear'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
        ?>
            <div class="inner"><a href="index.php?godown=<?php echo $row['godown']; ?>">
                <button class="button">
                    <?php echo $row['godown']; ?>
                </button>
            </a></div>	
            
        <?php }
            } else {
            echo "<h2>No Godown Is Added</h2>";
        }
        ?>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3 class="heading">Add Godown</h3>
          <center><hr><br>
            <form action="godown.php" method="POST">
              <label for="godownName" class="modal-label">Name of the Godown: </label>
              <input type="text" name="godownName" id="godownName" class="modal-input" required><br><br>
              <input type="submit" value="Add Godown" class="button1" name="addGodown">
            </form>
        </center>
        </div>
      </div>


      <div id="myModal1" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h3 class="heading">Delete Godown</h3>
          <center><hr><br>
            <?php 
                $user = $_SESSION['user'];
                $sql = "SELECT * FROM godowns WHERE username='$user'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) { ?>
            
                <a href="deleteGodown.php?godown=<?php echo $row['godown']; ?>"><button class="delete"><?php echo $row['godown']; ?></button></a>
                    
            <?php }}
                ?>  
          </center>
        </div>
      </div>
</body>

<script>
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];
  
    btn.onclick = function() {
      modal.style.display = "block";
    }
  
    span.onclick = function() {
      modal.style.display = "none";
    }

    var modal1 = document.getElementById("myModal1");
    var btn1 = document.getElementById("myBtn1");
    var span1 = document.getElementsByClassName("close")[1];
  
    btn1.onclick = function() {
      modal1.style.display = "block";
    }
  
    span1.onclick = function() {
      modal1.style.display = "none";
    }
  
    window.onclick = function(event) {
      if (event.target == modal1 || event.target == modal) {
        modal1.style.display = "none";
        modal.style.display = "none";
      }
    }
  </script>
</html>

<?php
    }
?>
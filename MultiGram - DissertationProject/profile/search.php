<?php
include("../Main/database.php");
include("../Main/databaseTable.php");
session_start();
 ?>
 
 <?php 
 if(isset($_SESSION['id'])){
  $id = $_SESSION['id'];
 
 ?>
 		<!DOCTYPE html>
 <html>
  <head>
 	<link rel="stylesheet" type="text/css" href="../Styles/Style.css">
		
  		<link rel="stylesheet" type="text/css" href="../Bootstrap/bootstrap.min.css">
	
		<link rel="stylesheet" type="text/css" href="../Bootstrap/jquery-ui.css">
		
  		<!-- <link rel="stylesheet" type="text/css" href="../Bootstrap/weblesson/bootstrap.min.css"> -->

  		<link rel="stylesheet" href="../Bootstrap/emojionearea.min.css">
		
		
		<script src="../Bootstrap/jquery-1.12.4.js"></script>

		<script src="../Bootstrap/jquery-ui.js"></script>


		<script src="../Bootstrap/emojionearea.min.js"></script>
		
		<script src="../Bootstrap/jquery.form.js"></script>

		<script src="../Bootstrap/bootstrap.min.js"></script>
 	<title>
 	</title>
 </head>
 <body>
 <header class="userHeader">
 	 <nav class="navbar navbar-expand-lg navbar-light bg-secondary">
 
  <a class="navbar-brand"  href="../HTML/userlayout.php?user=userIndex"><b id="logo">MultiGram</b></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  


  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  	 <form class="form-inline mr-auto my-2  my-lg-0" action="search.php" method="POST">
      <input class="form-control" type="search" id="search" name="search" placeholder="Search" aria-label="Search" value="<?php echo $_POST['search'] ?>">
      <button class="btn btn-light my-2 my-sm-0" type="submit" name="search-user"><img src="../Icons/search.png" alt="Search" style="width:20px; "></button>
    </form>
    <div class="dropdown-menu" id="back_result" ></div>

    <!-- <br> -->
    <ul class="navbar-nav">

	  <li class="nav-item">
      	<a class="nav-link bg-secondary active" href="../profile/userProfile.php">
      	<?php 
 			$users = new DatabaseTable($pdo, 'users');//new database table for users.
			$users = $users->search('user_id', $_SESSION['id']);
			//display users information.
			foreach($users as $user){		
 			echo $user['firstname'];
			}
 			 ?>
        </a>
      </li>

      <li class="nav-item ">
        <a class="nav-link  bg-secondary active" href="../HTML/userlayout.php?user=userIndex">Home <span class="sr-only">(current)</span></a>
      </li>


      
      <!-- message -->
       <li class="nav-item ">
        <a class="nav-link  bg-secondary active" href="../Messages/chatApplication.php"><img src="../Icons/msg.png" alt="MESSAGES" style="width:25px; margin-bottom: 4px;"></a>
      </li>

      <!-- notification -->
       <li class="nav-item">
        <a class="nav-link  bg-secondary active" href="#"><img src="../Icons/ntf.png" alt="NOTIFICATION" style="width:23px; margin-bottom: 4px;"></a>
      </li>


      <!-- more section -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle bg-secondary" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          More
        </a>
        <div class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
        	<a class="dropdown-item" href="../settings/editProfile.php">Setting</a>
          	<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="../HTML/userLayout.php?user=userLogouts">Logout</a>
        
        </div>
      </li>
    
    </ul>   
      
  </div>
</nav>

 <style>
.navbar:hover {box-shadow: 1px 4px 3px lightgrey}
#logo:hover  {box-shadow: 1px 4px 4px lightgrey}
  </style>


 </header>	

 	
 <main class="searchUser" style="margin-left: 20%; margin-right: 20%; margin-top: 15%;">

  <div class="continer">

     <?php 

    if (isset($_POST['search-user'])) {
        $users = $pdo->query("SELECT * FROM users")->fetch();;

      if (isset($_POST['search'])) {
        $search = $_POST['search'];
      }

      if (empty($search)) {
        echo "<b>Please type something in search input.</b>";
      }
      else
      {
        $sql = "
          SELECT * FROM users WHERE (firstname like '%".$_POST['search']."%' OR lastname like '%".$_POST['search']."%') 
          AND (user_id != '$id' AND activation = 1 AND verified = 1)" ;

        $searchUser = $pdo->query($sql);
        $users = $pdo->query("SELECT * FROM users")->fetch();
        
          // echo '<h1>Possible match</h1>';
        foreach ($searchUser as $user) {
          
             echo '<div>
          <a class="dropdown-item" href="../profile/otherUsersProfile.php?id='.$user['user_id'].'">
          <div class="btn btn-secondary" style="display: flex; flex-direction: row;">
            <div style="width: 10%;"> '.get_profile_picture($pdo, $user['user_id']).' </div><div><b><h5> '.$user['firstname'].' '.$user['lastname'].' </h5></b>
            </div>
          </div>
          </a>
          </div>';

        
          }
        }

      }
    // }

     ?>

  </div>
   
 </main>


<footer class="bg-secondary" style="margin-top: 10%;">
	<p>----------------------------------------</p>
	<p>(c) 2018</p>
</footer>
 <script>
    $(document).ready(function(){
      $('#search').userup(function(){
        var name = $(this).val();
        $.ajax({
        url: "../Include/get_users.php",
        method: "POST",
        data: {name:name},
        success:function(data){
          $('#back_result').html(data);
          $('#back_result').css({'display':'block'});
          
          }
        })        
      });
    });
  </script>
 
 </body>
 </html>
 	<?php 
 	}

 	else
 	{
 		header('Refresh: 1; url =../Layouts/index.php');
 	}
 	?>		
 

 
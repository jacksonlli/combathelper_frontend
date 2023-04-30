<?php
$jsonString = file_get_contents("https://combathelper.herokuapp.com/player");
$playArr = json_decode($jsonString);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter");
$encArr = json_decode($jsonString);
$encArrId = array_column($encArr, 'id');
array_multisort($encArrId, SORT_ASC, $encArr);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/monster");
$monsArr = json_decode($jsonString);
$monsArrName = array_column($monsArr, 'name');
array_multisort($monsArrName, SORT_ASC, $monsArr);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>D&D Combat Helper</title>
    <meta name="description" content="d&d combat helper">
    <meta name="author" content="caw4comics">

    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le styles -->
    <link href="bootstrap.css" rel="stylesheet">
    <script src="combathelperscripts.js"></script>
	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>

    <!-- Le fav and touch icons -->
   
  </head>

  <body>
	<!-- Side bar -->
	<div id="mySidebar" class="sidebar">
		<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		<div class="my-sidebar-scrollbar">
		<a href="index.php"><u>Homepage</u></a>
		<?php 
			foreach ($encArr as $encounter) { 
				echo '<a href="editEncounter.php?id='.$encounter->id.'">' . $encounter->name . '</a>';
			}
		  ?>
		</div>
	</div>

	<div id="main">

	<!-- Content -->
    <div class="container">

      <div class="content">
        <div class="page-header">
			<div class="row">
			<div class="span1">
				<button class="openbtn" onclick="openNav()">&#9776;</button>
			</div>
			<div class="span6">
				<h1>D&D Combat Helper</h1>
			</div>
			</div>
		</div>
		<h2> Player Characters List </h2>
		<!--
		<input type="text" class="form-control" placeholder="New Player">
		<button type="submit" class = "btn btn-default" role = "button">Add</button>
		-->
		<form action="addPlayer.php" method="post">
			<input type="text" class="form-control" placeholder="New Player" name="name">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
		</form>
		
	


		<p>
		<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">Character Name</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		<?php 
			$row_no = 1;
			foreach ($playArr as $player) { 
				
				echo '<tr><th scope="row">' . $row_no . '</th><td>' . $player->name . '</td>
				<td> <button class="openbtn" onclick="deletePlayer(\''.$player->name.'\')">Delete</button></td></tr>';
				$row_no++;
			}
		  ?>
		  
		</tbody>
		</table>
		</div>
		<br>
		<h2> Encounters List </h2>
		<form action="addEncounter.php" method="post">
			<input type="text" class="form-control" placeholder="Encounter Title" name="name">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
		</form>
		<p>
		<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">id</th>
			<th scope="col">Encounter</th>
			<th scope="col"></th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		<?php 

			foreach ($encArr as $encounter) { 
				echo '<tr><th scope="row">' . $encounter->id . '</th><td>' . $encounter->name . '</td>
				<td><a class="openbtn" href="editEncounter.php?id='.$encounter->id.'">Edit</a></td>
				<td> <a class="openbtn" href="deleteEncounter.php?id='.$encounter->id.'">Delete</a></td></tr>';
			}
		  ?>
		  
		</tbody>
		</table>
		</div>
		<br>
		<h2> Monsters List</h2>
		<form action="addMonster.php" method="post">
			<input type="text" class="form-control" placeholder="Monster Name" name="name">
			<input type="text" class="form-control" placeholder="Default AC" name="AC"><br>
			<input type="text" class="form-control" placeholder="Default HP" name="HP">
			<input type="text" class="form-control" placeholder="Default DEX" name="DEX">
			<input type="text" class="form-control" placeholder="Default WIS" name="WIS">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
		</form>
		<p>
		<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">id</th>
			<th scope="col">Monster</th>
			<th scope="col">Default AC</th>
			<th scope="col">Default HP</th>
			<th scope="col">Default DEX</th>
			<th scope="col">Default WIS</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		<?php 

			foreach ($monsArr as $monster) { 
				echo '<tr><th scope="row">' . $monster->id . '</th><td>' . $monster->name . '</td><td>' . $monster->AC . '</td><td>' . $monster->HP . '</td><td>' . $monster->DEX . '</td><td>' . $monster->WIS . '</td><td> <a class="openbtn" href="deleteMonster.php?id='.$monster->id.'">Delete</a></td></tr>';
			}
		  ?>
		  
		</tbody>
		</table>
		</div>
		<br>
         <footer>
        <p>&copy; Li 2020</p>
      </footer>

    </div> <!-- /container -->
	</div> <!-- main-->
  </body>
</html>

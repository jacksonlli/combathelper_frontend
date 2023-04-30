<?php
$id = $_GET['id'];
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter/$id");
$thisEncounter = json_decode($jsonString);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter_monster/$id");
$emArr = json_decode($jsonString);
//print_r($playArr);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter");
$encArr = json_decode($jsonString);
$encArrId = array_column($encArr, 'id');
array_multisort($encArrId, SORT_ASC, $encArr);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/player");
$playArr = json_decode($jsonString);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Combat Helper</title>
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
			<div class="span9">
				<h1>D&D Combat Helper - Encounter</h1>
			</div>
			</div>
		</div>
		<?php echo'<h2>Title: '.$thisEncounter->name.'</h2>
		<form action="editTitle.php?id='.$id.'" method="post">
			
			<input type="text" class="form-control" placeholder="Edit Title" name="name">'?>
			<button type="submit" class = "btn btn-default" role = "button">Edit</button>
			
		</form>
		<h2> Add Monsters </h2>
		<!--
		<input type="text" class="form-control" placeholder="New Player">
		<button type="submit" class = "btn btn-default" role = "button">Add</button>
		-->
		<?php
		echo'<form action="addMonsterToEncounter.php?encounter_id='.$id.'" method="post">'?>
			<input type="text" class="form-control" placeholder="Monster name" name="monster_name">
			<input type="number" class="form-control" placeholder="Quantity" name="quantity">
			<input type="number" class="form-control" placeholder="Custom AC" name="AC">
			<input type="number" class="form-control" placeholder="Custom HP" name="HP">
			<input type="number" class="form-control" placeholder="Custom DEX" name="DEX">
			<input type="number" class="form-control" placeholder="Custom WIS" name="WIS">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
		</form>
		<h2> Import Monsters from Encounter </h2>
		<?php
		echo'<form action="importEncounter.php?id='.$id.'" method="post">'?>
			<input type="text" class="form-control" placeholder="Encounter name" name="name">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
			
		</form>
		
	


		<p>
		<h2> Current Encounter Monsters </h2>
		<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">Monster</th>
			<th scope="col">Quantity</th>
			<th scope="col">AC</th>
			<th scope="col">HP</th>
			<th scope="col">DEX</th>
			<th scope="col">WIS</th>
			<th scope="col"></th>
		  </tr>
		</thead>
		<tbody>
		<?php 
			$row_no = 1;
			foreach ($emArr as $em) { 
				echo '<tr><th scope="row">' . $row_no . '</th><td>' . $em->monster_name . '</td><td>' . $em->quantity . '</td><td>' . $em->AC . '</td><td>' . $em->HP . '</td><td>' . $em->DEX . '</td><td>' . $em->WIS . '</td><td> <a class="openbtn" href="deleteEncounterMonster.php?id='.$em->id.'">Delete</button></td></tr>';
				$row_no++;
			}
		  ?>
		  
		</tbody>
		</table>
		</div>
		<br>
		<h2>Player Initiative Rolls</h2>
		<?php
		echo '<form action="initEncounter.php?id='.$id.'" method="post">'
		?>
		<div class="table-wrapper-scroll-y my-custom-scrollbar">

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">#</th>
			<th scope="col">Character Name</th>
			<th scope="col">Initiative Roll</th>
		  </tr>
		</thead>
		<tbody> 
		<?php 
			$row_no = 1;
			foreach ($playArr as $player) { 
				echo '<tr><th scope="row">' . $row_no . '</th><td>' . $player->name . '</td><td><input type="number" class="form-control" placeholder="Enter initiative roll" name="'.urlencode($player->name).'_initiative_roll"></td></tr>';
				$row_no++;
			}
		  ?>

		</tbody>
		</table>
		</div>
		<div class="row">
			<div class="span12">
				<button type="submit" class = "btn pull-right" role="button">
					Play
				</button>
			</div>
			
			<div class = "span2">
				<a href="index.php" class = "btn pull-right" role="button">
					Return
				</a>

			</div>
		</div>
		
       	</form>
            <footer>
        <p>&copy; Li 2020</p>
      </footer>
	</div>
    </div> <!-- /container -->
	</div> <!-- main-->
  </body>
</html>

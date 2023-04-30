<?php
$id = $_GET['id'];
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter/$id");
$thisEncounter = json_decode($jsonString);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/play/$id");
$statusArr = json_decode($jsonString);
$statusArrInit = array_column($statusArr, 'initiative_roll');
array_multisort($statusArrInit, SORT_DESC, $statusArr);
$jsonString = file_get_contents("https://combathelper.herokuapp.com/encounter");
$encArr = json_decode($jsonString);
$encArrId = array_column($encArr, 'id');
array_multisort($encArrId, SORT_ASC, $encArr);
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
			<div class="span12">
				<?php echo'<h1>Now Playing: '.$thisEncounter->name.'</h1>'?>
			</div>
			</div>
		</div>
		<p>

		<table class="table table-bordered table-striped mb-0">
		<thead>
		  <tr>
			<th scope="col">Name</th>
			<th scope="col">HP</th>
			<th scope="col"></th>
			<th scope="col"></th>
			<th scope="col">AC</th>
			<th scope="col">WIS</th>
			<th scope="col">Status</th>
			<th scope="col"></th>
			<th scope="col"></th>
			<th scope="col">D20 Rolls</th>
		  </tr>
		</thead>
		<tbody>
		<?php 

			foreach ($statusArr as $s) { 
				if ($s->isPlayer){
					echo '<tr><th scope="row">'  . $s->name . '</th>
					<td colspan="6" style="text-align:right;">' . $s->text . '</td>
					<form action="editText.php?id='.$s->id.'" method="post">
					<td> <input type="text" style="width:100px" class="form-control" placeholder="Update status" name="newtext"></td>
					<td><button type="submit" class = "btn btn-default" role = "button">Edit</button></td>
					</form>
					
					</tr>';
				}
				else{
					echo '<tr><th scope="row">' . $s->name . '</th>
					<td>' . $s->HP . '</td>
					<form action="editHP.php?id='.$s->id.'" method="post">
					<td><input type="number" style="width:50px" class="form-control" placeholder="- HP" name="DMG"></td>
					<td><button type="submit" class = "btn btn-default" role = "button">Apply</button></td>
					</form>
					<td>' . $s->AC . '</td>
					<td>' . $s->WIS . '</td>
					<td>' . $s->text  . '</td>
					<form action="editText.php?id='.$s->id.'" method="post">
					<td><input type="text" style="width:100px" class="form-control" placeholder="Update status" name="newtext"></td>
					<td><button type="submit" class = "btn btn-default" role = "button">Edit</button></td>
					</form>
					<td><b>' . rand(1,20) . ', '. rand(1,20) . '</b>, '. rand(1,20) .', '. rand(1,20) . ', '. rand(1,20) . ', '. rand(1,20) .'</td>
					</tr>';
				}
			}
		  ?>
		  
		</tbody>
		</table>
		<a href="javascript:window.location.href=window.location.href" class = "btn pull-right" role="button">Reroll</a>
		</br>
		<h2> Add Monsters </h2>
		<?php
		echo'<form action="addMonsterToRun.php?encounter_id='.$id.'" method="post">'?>
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
		echo'<form action="importRun.php?id='.$id.'" method="post">'?>
			<input type="text" class="form-control" placeholder="Encounter name" name="name">
			<button type="submit" class = "btn btn-default" role = "button">Add</button>
			
		</form>
		
		<br>
		<div class="row">
			<div class="span9">
				<?php echo '<a href="deleteRun.php?id='.$id.'" class = "btn pull-left" role="button">'?>
					Delete Run
				</a>
			</div>
			<div class = "span1">
				<?php echo '<a href="editEncounter.php?id='.strval(intval($id)-1).'" class = "btn pull-right" role="button">' ?>
					&#8592
				</a>

			</div>
			<div class = "span1">
				<?php echo '<a href="editEncounter.php?id='.strval(intval($id)+1).'" class = "btn pull-right" role="button">' ?>
					&#8594
				</a>

			</div>
			<div class = "span2">
				<a href="index.php" class = "btn pull-right" role="button">
					Return
				</a>

			</div>
		</div>
		
        <footer>
        <p>&copy; Li 2020</p>
      </footer>
	</div>
    </div> <!-- /container -->
	</div> <!-- main-->
  </body>
</html>

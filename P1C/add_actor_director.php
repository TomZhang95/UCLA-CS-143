<!DOCTYPE html>
<html>
	<!---------------------------------- Top Cell---------------------------------->
	<head> 
		<meta charset="utf-8"> 
		<title>Project 1C Movie Database</title> 
		<link rel="stylesheet" href="style.css">
	</head>

	<body>
		<table cellspacing="0" cellpadding="0" style="width:100%; height:100%">
			<tr>
				<td style="background-color:#2D70AE;" colspan="2">
					<center><mark class="h1title2">movie</mark><mark class="h1title">Base</mark></center>
					<center><mark class="italicwhite">#1 database movies by Reinaldo Daniswara and Tianyang Zhang</mark></center>
				</td>
			</tr>
			<!---------------------------------- Left Cell---------------------------------->
			<tr>
				<td style="background-color:#F6FBFD ;width:200px;vertical-align:top;">
					<mark class="leftorder">Add New Content:</mark><br>
					<ul>
						<li><a href="add_actor_director.php">Add Actor/Director</a>
						<li><a href="add_movie_info.php">Add Movie Information</a>
						<li><a href="add_movie_actor_relation.php">Add Movie/Actor Relation</a>
						<li><a href="add_movie_director_relation.php">Add Movie/Director Relation</a>
						<li><a href="add_review.php">Add Review for Movies</a>
					</ul>	
					
					<br><br>

					Search Interface:<br>
					<ul>
						<li><a href="search.php">Search Actor/Movie</a><br><br>
					</ul>
					<br>
				</td>

				<!---------------------------------- Contents Cell---------------------------------->
				<td valign="top">
					<mark class="cellcontent">Add Actor/Director: </mark><br>
					<p>
						<form action="add_actor_director.php" method="GET">
							Type: <input type="radio" name="type" value="Actor" <?php echo (htmlspecialchars($_GET['type'])=='Actor')?'checked':''?>>Actor
									<input type="radio" name="type" value="Director" <?php echo (htmlspecialchars($_GET['type'])=='Director')?'checked':''?>>Director<br/><br/>	
							First Name:	<input type="text" placeholder="First Name..." name="first" maxlength="20" value="<?php echo htmlspecialchars($_GET['first']);?>"><br/>
							Last Name:	<input type="text" placeholder="Last Name..." name="last" maxlength="20" value="<?php echo htmlspecialchars($_GET['last']);?>"><br/><br/>	
							Sex: <input type="radio" name="sex" value="Male" <?php echo (htmlspecialchars($_GET['sex'])=='Male')?'checked':''?>>Male
									<input type="radio" name="sex" value="Female" <?php echo (htmlspecialchars($_GET['sex'])=='Female')?'checked':''?>>Female<br/><br/>	
							Date of Birth:	<input type="text" placeholder="YYYY-MM-DD" name="dob" maxlength="10" value="<?php echo htmlspecialchars($_GET['dob']);?>"> <br/>
							Date of Death:	<input type="text" placeholder="YYYY-MM-DD, if applicable" name="dod" maxlength="10" value="<?php echo htmlspecialchars($_GET['dod']);?>"> <br/>
							<br/>
							<input type="submit" value="Add me!!"/>
						</form>

					</p>
					<?php
						//Connect to db ----------------------------------------------------------
						$connection = mysqli_connect("127.0.0.1", "cs143", "") or die(mysqli_connect_error());
						mysqli_select_db($connection, "CS143");

						$get_type=trim($_GET["type"]);
						$get_first=trim($_GET["first"]);
						$get_last=trim($_GET["last"]);
						$get_sex=trim($_GET["sex"]);
						$get_dob=trim($_GET["dob"]);
						$get_dod=trim($_GET["dod"]);

						$dob_date = date_parse($get_dob);
						$dod_date = date_parse($get_dod);

						$maximum_id = mysqli_query($connection, "SELECT MAX(id) FROM MaxPersonID") or die(mysqli_error($connection));
						$maximum_id_arr = mysqli_fetch_array($maximum_id);
						$maxID = $maximum_id_arr[0];
						$max_id_rs = $maxID + 1;




						//Create query for ACTOR search ------------------------------------------
						if($get_type=="" && $get_first=="" && $get_last=="" && $get_sex=="" && $get_dob=="" && $get_dod=="") //everything is empty
						{
							echo "Please input some informations to add";
						}
						else if($get_first=="" || $get_last=="")
						{
							echo "Please enter a valid first and last name.";
						}
						else if($get_type=="")
						{
							echo "Please specify Actor or Director to input.";
						}
						
						else if(preg_match('/[^A-Za-z\s\'-]/', $get_first) || preg_match('/[^A-Za-z\s\'-]/', $get_last))
						{
							echo "Only letters, spaces, single-quotes, and hyphens are allowed in the $get_type name.";
						}
						else if($get_type=='Actor' && $get_sex=="")
						{
							echo "echo $get_sex Please select the Actor's or Director's sex";
						}
						else if($get_dob=="" || !checkdate($dob_date["month"], $dob_date["day"], $dob_date["year"]))
						{
							echo "Please follow the format YYYY-MM-DD";
						}	
						else if($get_dod!="" && !checkdate($dod_date["month"], $dod_date["day"], $dod_date["year"]))
						{
							echo "If you specify a date of death, it must be valid.";
						}
						else 
						{				
							if($get_type=="Actor")
								{
									if($get_dod=="")
										$query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$max_id_rs', '$get_last', '$get_first', '$get_sex', '$get_dob', NULL)";
									else
										$query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$max_id_rs', '$get_last', '$get_first', '$get_sex', '$get_dob', '$get_dod')";
								}
							else //Director
								{
									if($get_dod=="")
										$query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$max_id_rs', '$get_last', '$get_first', '$get_dob', NULL)";
									else
										$query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$max_id_rs', '$get_last', '$get_first', '$get_dob', '$get_dod')";
								}
			
								$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		
								mysqli_query($connection, "UPDATE MaxPersonID SET id=$max_id_rs WHERE id=$maxID") or die(mysqli_error($connection));
			
								echo "New $get_type added with first name $get_first, last name $get_last (with id=$max_id_rs).";
						}

					mysqli_close($connection);

						//------------------------------ PHP ENDS ------------------------------
					?>
				</td>
			</tr>
		</table>

	</body>
</html>
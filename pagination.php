<?php

$con = new mysqli('localhost','root','','ezyro_22455960_db');
if($con->connect_error){
	die ('failed to load data connection:'.$con->connect_error);
}
/*----------------------------------------
	Below is your desire records  per page. 
	---------------------------------------*/
	$perpage = 50;
	/* ---------------------------
COUNT RECORDS IN THE DATABASE
 --------------------------- */
$count=$con->query("SELECT count(word) as count FROM entries");
$results = $count->fetch_assoc();
$c = $results['count'];
$count->close();

if(isset($_GET['q']))
{
			if(isset($_GET['page']))
			{	
				$page = (int) $_GET['page'];	
				if($page < 1){
				$page = 1;
				}
				$from = ($page*$perpage) - $perpage;
				
			} else {
				$from=0;
			}
	$q=$con->escape_string($_GET['q']);
	$query = $con->prepare("SELECT word, wordtype, definition FROM entries WHERE word LIKE CONCAT('%',?,'%') LIMIT $from,$perpage");
	$query->bind_param("s",$q);
	$query->execute();
	$result = $query->get_result();
	
	$qr = $con->prepare("SELECT word FROM entries WHERE word LIKE CONCAT('%',?,'%')");
	$qr->bind_param("s",$q);
	$qr->execute();
	$c = $qr->get_result()->num_rows;

}else if(isset($_GET['page'])){
	$page = (int) $_GET['page'];	
	if($page < 1){
	$page = 1;
	}
	
	$from = ($page*$perpage) - $perpage;
	$query = $con->prepare("SELECT word, wordtype, definition FROM entries LIMIT $from,$perpage");
	$query->execute();
	$result = $query->get_result();
	
} else {
	$query = $con->prepare("SELECT word, wordtype, definition FROM entries LIMIT 0,15");
	$query->execute();
	$result = $query->get_result();
}


?>
<html lan="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<head>
<title>DICTIONARY</title>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
	<body>
	<div class="w3-bar w3-teal w3-border">
		<a  href="" class="w3-button w3-bar-item"> <b>DICTIONARY</b></a>
		<form method="GET" action="dictionary.php">
		<input type="text" class="w3-bar-item w3-input" value="<?php echo $srch = (isset($_GET['q']))?$_GET['q']:'';?>" name="q" placeholder="Search..">
		<button type="submit" class="w3-bar-item w3-button w3-green">Go</button>
		</form>
	</div>
	<?php echo "<b>". "Current Records in the database:" .$c."</b>" ?>

		<table class="w3-table w3-table-all" style="font-family:Helvitica;font-size:17px">
			<tr>
				<th>WORD</th>
				<th>WORDTYPE</th>
				<th>DEFINITION</th>
			</tr>
				<?php 
					while($r=$result->fetch_assoc()){
						$q = $r['word'];
						$a = $r['wordtype'];
						$g = $r['definition'];
					
				?>
				<tr>
					<td><?php echo $q ?></td>
					<td><?php echo $a ?></td>
					<td><?php echo $g ?></td>
				</tr>
					<?php 
					
					} 
					$result->free_result();
				$con->close();
					?>
		</table>
	
		<br>
		<div class="w3-center">
		<div class="w3-bar w3-border">
		<?php
		/* ----------------------------------------------------
			Name: Pagination script
			(c) Rey Jhon A. Baquirin
			Date: 08/03/2018 
			This is using w3-css as stylesheet.
			$page = $_GET['page'] ->> page parameter from url
			$c ->> total records in the database.
			$perpage ->> your desire record perpage.
			$this_srch ->> handles your search parameter using $_GET['q']
			
			$from = ($page*$perpage) - $perpage
			put -->> $from <<-- to your query ex.: ("SELECT * FROM youTable LIMIT $from, $perpage")
		---------------------------------------------------- */
		
		$this_srch = (isset($_GET['q']) ? = "&q=".$_GET['q'] :""; 
		
		$totalpages = ceil($c/$perpage);
		if(isset($_GET['page']) && $page <= $totalpages){
			$current = $page;
		} else {
			$totalpages = ceil($c/$perpage);
				if($c>$perpage){
					$current = (isset($_GET['q'])  && $totalpages < 10) ? $totalpages : 10;		
				}else{
					$current = $totalpages;
				}
			$page =1;
		}
			if($page < $totalpages){
				if($page >= $current){				
					$current += 5;		
					if($current > $totalpages){
						$excess = $current - $totalpages;
						$current -= $excess;
					}
				}	
			} 	
			$first = ($page >= 6) ? '<a class="w3-button w3-bar-item" href="dictionary.php?page=1'.$this_srch.'">First</a>':'';
			$last = ($current >= 6) ? '<a class="w3-button w3-bar-item" href="dictionary.php?page='.$totalpages.$this_srch.'">Last</a>':'';			
			// display the last 5 pages links
			$p = ($page > 4)?$page-4:1;
			$pagination="";
			for($i = $p;$i<=$current;$i++){
				if($page==$i){
					$pagination .= '<a class="w3-button w3-bar-item w3-teal" href="dictionary.php?page='.$i.$this_srch.'">'.$i.'</a>';
				}else {
					$pagination .= '<a class="w3-button w3-bar-item" href="dictionary.php?page='.$i.$this_srch.'">'.$i.'</a>';
				}
			}
			if($c==0){
			}else if($c>50){
			echo $first .'&nbsp;' . $pagination . '&nbsp;' . $last;}
			?>
			</div>
		</div>
	</body>
</html>
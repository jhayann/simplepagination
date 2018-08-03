		<?php
		
		$this_srch = (isset($_GET['q'])) ? "&q=".$_GET['q'] :""; 
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
			$first = ($page >= 6) ? '<a class="w3-button w3-bar-item" href="pagination.php?page=1'.$this_srch.'">First</a>':'';
			$last = ($current >= 6) ? '<a class="w3-button w3-bar-item" href="pagination.php?page='.$totalpages.$this_srch.'">Last</a>':'';			
			// display the last 5 pages links
			$p = ($page > 4)?$page-4:1;
			$pagination="";
			for($i = $p;$i<=$current;$i++){
				if($page==$i){
					$pagination .= '<a class="w3-button w3-bar-item w3-teal" href="pagination.php?page='.$i.$this_srch.'">'.$i.'</a>';
				}else {
					$pagination .= '<a class="w3-button w3-bar-item" href="pagination.php?page='.$i.$this_srch.'">'.$i.'</a>';
				}
			}
			if($c==0){
			}else if($c>50){
			echo $first .'&nbsp;' . $pagination . '&nbsp;' . $last;}
			?>
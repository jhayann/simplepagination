 ----------------------------------------------------
			Name: Simple Pagination script
			(c) Rey Jhon A. Baquirin
			https://github.com/jhayann/simplepagination.git
			Test on 176,000 rows.
			Date: 08/03/2018 
			This is using w3-css as stylesheet.
			$page = $_GET['page'] ->> page parameter from url
			$c ->> total records in the database.
			$perpage ->> your desire record perpage.
			$this_srch ->> handles your search parameter using $_GET['q']
			
			$from = ($page*$perpage) - $perpage
			put -->> $from <<-- to your query ex.: ("SELECT * FROM youTable LIMIT $from, $perpage")
---------------------------------------------------- 
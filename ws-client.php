
<?php

	if($_POST["priority"]=="") {
		retrieveData(0);
	} 
	elseif( (int)$_POST["priority"]>0 && (int)$_POST["priority"]<4 ) {
		$arg = (int)$_POST["priority"];	
		retrieveData($arg);
	} else {
		echo "Greska!";
	}

	function retrieveData($arg)
	{
		
		$service = new SoapClient("http://localhost:9090/ws/hsms?wsdl");
		if($arg==0) {
			$hsms = $service->listAllActions();	
		} else {
			$hsms = $service->listActionsByPriority(array('arg0'=>$arg));
		}
		
		echo "<h1>HSMS Web service client</h1>";
		// var_dump($hsms);
		echo "\n"."</br></br>";
		$obj = $hsms->return;
		echo "<table border='3'>
				<tr>
					<th>RB</th>
					<th>Opis</th>
					<th>SMS broj</th>
					<th>Cena poruke</th>
					<th>Organizacija</th>
					<th>Prioritet</th>
				</tr>";
				
				if(is_array($obj)) {
					
					foreach ($obj as $k=>$v) {
					echo "<tr>
							<td style=\"text-align: center;\">".($k+1)."</td>
							<td>".$v->desc."</td>
							<td style=\"text-align: center;\">".$v->number."</td>
							<td style=\"text-align: center;\">".$v->price."</td>
							<td>".$v->organisation."</td>
							<td style=\"text-align: center;\">".$v->priority."</td>
						</tr>";
				}
					
				} else {
					echo "<tr>
							<td style=\"text-align: center;\">".(1)."</td>
							<td>".$obj->desc."</td>
							<td style=\"text-align: center;\">".$obj->number."</td>
							<td style=\"text-align: center;\">".$obj->price."</td>
							<td>".$obj->organisation."</td>
							<td style=\"text-align: center;\">".$obj->priority."</td>
						</tr>";
				}
		echo "</table>";
	}
	echo "<a href=\"index.html\"><p>Pocetna stranica</p></a>";
?>
<?php
require_once('lib/nusoap.php');
require_once('lib/class.wsdlcache.php');
$soapclient = new nusoap_client( 'http://cursodssw.hol.es/comprobarmatricula.php?wsdl',true);




function compPs($pass){
	$fp=fopen("toppasswords.txt","r") or exit("Unable to open file!");;
	$res="VALIDA";
	while(!feof($fp)){
		$linea=fgets($fp);
            if (strcmp (trim($linea),$pass) == 0){	
            		$res="INVALIDA";
		}
	}
	fclose($fp);
	return $res;
}

if(isset($_POST['email'])){
	$response=$soapclient->call('comprobar',array('x'=>$_POST['email']));	
}





$connect=mysqli_connect("mysql.hostinger.es","u461050408_usr","Prueba1","u461050408_quiz");

if ($connect) {
		
		echo "conexion establecida.";
		echo "<br/>";
	
		$nombre=$_POST["nombre"];
		$email=$_POST["email"];
		$password=$_POST["password"];
		$telefono=$_POST["telefono"];
		$especialidad=$_POST["especialidad"];
		$compEmail=$soapclient->call('comprobar',array('x'=>$email));
		$comPass=compPs($password);

		echo "<br/>";
		
		
		if (strcmp($comPass,"VALIDA")!=0){
			echo "<br/>";
			echo "Password hackeable por mi abuela.";
			echo "<br/>";
		
		
		}else if(strcmp($compEmail,"SI")!=0){
			echo "<br/>";
			echo "El usuario no pertenece a este curso.";
			echo "<br/>";
	
		}else{
		
			$sql="INSERT INTO Usuario(Nombre,Email,Password,Telefono,Especialidad) VALUES ('$nombre','$email','$password','$telefono','$especialidad')";
		
			if(!mysqli_query($connect,$sql)){
		
				die('Error: ' .mysqli_error($connect));
			}
			else{
				echo "<br/>";
				echo " Felicidades, se ha registrado usted correctamente.";
				echo "<br/>";
			}	
		
		}

	mysqli_close($connect);
}
?>
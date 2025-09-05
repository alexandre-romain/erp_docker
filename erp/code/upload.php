<?php
include("./include/config/common.php");

$num_ticket	= $_REQUEST['num_ticket']; //Récupération du ticket associé a l'upload
$user		= $_REQUEST['user']; //Récupération de l'user uploader
$name		= addslashes($_REQUEST['name']); //Récupération du nom du fichier
$dossier = 'upload/'; //Dossier d'upload
$fichier = basename($_FILES['doc']['name']);
$taille_maxi = 100000000; //Taille Maximum du fichier
$taille = filesize($_FILES['doc']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.pdf', '.doc', '.xls', '.docx', '.txt', '.csv','.PNG', '.GIF', '.JPG', '.JPEG', '.PDF', '.DOC', '.XLS', '.DOCX', '.TXT', '.CSV');
$extension = strrchr($_FILES['doc']['name'], '.'); 

if ($name != '') {
	$filename=$name;
}
else {
	$filename=$fichier;
}

//Début des vérifications de sécurité...
if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     if(move_uploaded_file($_FILES['doc']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
		 $path=$dossier.$fichier;
		 $sql="INSERT INTO ".$tblpref."files(name,path,ticket,user_uploader,date_upload) VALUES ('$filename','$path','$num_ticket','$user',now())";
		 $req=mysql_query($sql);
		 if (isset($_REQUEST['id_task'])) {
			 $message='Votre fichier à été uploadé avec succès.';
		 	 header('Location: ./task.php?num_task='.$_REQUEST['id_task'].'&message='.$message); 
		 }
		 else {
			if (isset($_REQUEST['num_task'])) {
				header('Location: ./task.php?num_task='.$_REQUEST['num_task'].'&upload=ok'); 
			}
			else {
         		header('Location: ./ticket.php?num_ticket='.$num_ticket.'&upload=ok'); 
			}
		 }
     }
     else //Sinon (la fonction renvoie FALSE).
     {
          echo 'Echec de l\'upload !';
     }
}
else
{
     echo $erreur;
}
?>

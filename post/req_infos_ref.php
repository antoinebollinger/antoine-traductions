<?php 
$id = htmlspecialchars((isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '1' ))) ;
session_start();
$lang = (isset($_SESSION['langue'])) ? $_SESSION['langue'] : 'fr' ;
include('../bdd/bdd.php');
$query = "SELECT * FROM references_".$lang." WHERE id = ".$id;
$req = $bdd->prepare($query);
$req->execute();
$presentation = array(); $oeuvre = array(); $tem_aut = array(); $tem_tra = array();
While ($donnees = $req->fetch()) {
	if ($donnees['nom'] != '') {$presentation[] = '<span style="text-transform:uppercase;font-weight:bold;">'.$donnees['nom'].'</span>';}
	if ($donnees['prenom'] != '') {$presentation[] = $donnees['prenom'];}
	if ($donnees['fonction'] != '') {$presentation[] = $donnees['fonction'];}
	$img = ($donnees['image'] != '') ? $donnees['image'] : 'zero.jpg' ;
	if ($donnees['titre'] != '') {$oeuvre[] = '<span style="font-style:italic;">'.$donnees['titre'].'</span>';}
	if ($donnees['edition'] != '') {$oeuvre[] = $donnees['edition'];}
	if ($donnees['tem_aut'] != '') {$tem_aut[] = '... '.($lang == 'fr' ? 'de l\'auteur' : 'do autor').' : <span class="caveat">'.$donnees['tem_aut'].'</span>';}
	if ($donnees['tem_tra'] != '') {$tem_tra[] = '... '.($lang == 'fr' ? 'du traducteur' : 'do tradutor').' : <span class="caveat">'.$donnees['tem_tra'].'</span>';}
	$url = ($donnees['url'] != '') ? '<a href="'.$donnees['url'].'" target="_blank">'.($lang == 'fr' ? 'Voir l\'ouvrage sur le site de l\'éditeur' : 'Ver no site da editora').'</a>' : "" ;
}
$resultat = $req->fetch();
$req->closeCursor();
?>
<div class="sub_main_reference">
	<div class="sub_main_reference_left">
		<img src="css/documents/<?php echo $img; ?>" >
	</div>
	<div class="sub_main_reference_right">
		<?php echo (count($presentation) != 0) ? "<h4>".implode(", ", $presentation)."</h4>" : "" ; ?>
		<?php echo (count($oeuvre) != 0) ? "<h4>".implode(", ", $oeuvre)."</h4>" : "" ; ?>
		<br/>
		<?php echo (count($tem_aut) != 0 || count($tem_tra) != 0) ? "<h4><em>".($lang == 'fr' ? 'Témoignage' : 'Depoimento')."...</em></h4>" : "" ; ?>
		<?php echo (count($tem_aut) != 0) ? "<h4>".implode(", ", $tem_aut)."</h4>" : "" ; ?>
		<?php echo (count($tem_tra) != 0) ? "<h4>".implode(", ", $tem_tra)."</h4>" : "" ; ?>
		<?php echo (count($tem_aut) != 0 || count($tem_tra) != 0) ? "<br/>" : "" ; ?>		
		<?php echo $url; ?>
	</div>
	<div style="clear:both;"></div>
</div>	

<?php 
$id_page = 'collection';
session_start();
include('session/stop_message.php');
include('post/liste_fonctions.php');
include('bdd/bdd.php');

if (!isset($_SESSION['list_grid'])) {$_SESSION['list_grid'] = 'grid';}
if (isset($_POST['list_grid']) && in_array($_POST['list_grid'],array('list','grid'))) {
	$_SESSION['list_grid'] = $_POST['list_grid'];
}
$filtre = array(); $search_query = "";
$rech_gen = trim((isset($_GET['rech_gen']) && $_GET['rech_gen'] != '') ? htmlspecialchars($_GET['rech_gen']) : '');
if ($rech_gen != '') {
	$filtre[] = array('rech_gen',$rech_gen);
	$search_query = "AND (ca.pays LIKE '%".$rech_gen."%' OR ca.annee LIKE '%".$rech_gen."%' OR ca.theme_1 LIKE '%".$rech_gen."%' OR ca.yvert LIKE '%".$rech_gen."%')";}
$rech_gen_array = array();
if ($rech_gen != '' && strpos($rech_gen," ") !== false) {
	$search_query = "";
	$rech_gen_array = explode(" ", $rech_gen);
	$filtre = array();
	foreach($rech_gen_array as $value) {
		$filtre[] = array('rech_gen_array',$value);
		$search_query .= "AND (ca.pays LIKE '%".$value."%' OR ca.annee LIKE '%".$value."%' OR ca.theme_1 LIKE '%".$value."%' OR ca.yvert LIKE '%".$value."%') ";
	}
}
$pays = (isset($_GET['pays']) && $_GET['pays'] != '') ? htmlspecialchars($_GET['pays']) : '';
$annee = (isset($_GET['annee']) && $_GET['annee'] != '') ? htmlspecialchars($_GET['annee']) : '';
$theme = (isset($_GET['theme']) && $_GET['theme'] != '') ? htmlspecialchars($_GET['theme']) : '';
$type = (isset($_GET['type']) && $_GET['type'] != '') ? htmlspecialchars($_GET['type']) : '';
if ($pays != '') {$filtre[] = array('pays',$pays);}
if ($annee != '') {$filtre[] = array('annee',$annee);}
if ($theme != '') {$filtre[] = array('theme',$theme);}
if ($type != '') {$filtre[] = array('type',$type);}
$type_query = ($type == "Dispoliste") ? "AND nbr > 1" : (($type == "Mancoliste") ? "AND nbr = 0" : "");
$main_query = "
SELECT ca.*, pa.drapeau FROM catalogue ca 
LEFT JOIN pays pa ON pa.pays = ca.pays 
WHERE ca.pays LIKE :pays AND ca.annee LIKE :annee AND ca.theme_1 LIKE :theme ".$type_query." ".$search_query." 
ORDER BY ca.pays, ca.annee";
$main_query_array = array('pays' => (($pays != '') ? $pays : "%"), 'annee' => (($annee != '') ? $annee : "%"), 'theme' => (($theme != '') ? $theme : "%"));
$req_nb = $bdd->prepare($main_query);
$req_nb->execute($main_query_array);
$nb_total = 0;
While ($donnees_nb = $req_nb->fetch()) {$nb_total++;}
$req_nb->closeCursor();
//gestion limite nb par page
if (!isset($_SESSION['nb_par_page'])) {$_SESSION['nb_par_page'] = 50;}
if (isset($_GET['nb_par_page']) AND $_GET['nb_par_page'] != "") {
	$nb_par_page_tmp = intval(htmlspecialchars($_GET['nb_par_page']));
	$_SESSION['nb_par_page'] = (in_array($nb_par_page_tmp,array(50,100,150,200))) ? $nb_par_page_tmp : 50;
}
$nombreDeMessagesParPage = intval($_SESSION['nb_par_page']);
$nombreDePages  = ceil($nb_total / $nombreDeMessagesParPage);
if (!isset($_SESSION['page'])) {$_SESSION['page'] = 1;}
if (isset($_GET['page']) AND $_GET['page'] != "") {
	$page_tmp = intval(htmlspecialchars($_GET['page']));
	$_SESSION['page'] = ($page_tmp > $nombreDePages || $page_tmp < 1) ? 1 : $page_tmp;
}
$page = $_SESSION['page'];
$premierMessageAafficher = ($page - 1) * $nombreDeMessagesParPage;
?>
<!DOCTYPE html>
<html lang="fr">
<?php include('header/head.php'); ?>
	<body class="active ending collection initiate">
	<div id="background"></div>
<?php include('patientez.php'); include('doc/cgu.php'); include('header/logo.php'); include('forms/ajout_serie.php'); include('forms/map.php'); ?>
	<nav>
		<div id="menu_icon">
			<div class="menu-icon menu-icon-cross">
				<span></span>
				<svg x="0" y="0" width="40px" height="40px" viewBox="0 0 40 40">
				<circle cx="20" cy="20" r="18"></circle>
				</svg>
			</div>
		</div>
<?php include('nav/nav.php'); ?>
	</nav>
	<div id="main_collec">
<?php include('main_'.((isset($_GET['ma_liste']) && $_GET['ma_liste'] == 'ma_liste') ? 'liste' : 'collec').'.php'); ?>
	</div>
<?php include('liens_directs.php'); ?>
<?php include('footer/footer.php'); ?>
	</body>
</html>
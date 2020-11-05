<?php 
session_start();
include('session/stop_message.php');
if (!isset($_SESSION['connect']) OR $_SESSION['connect']==false) {header('Location: login.php');exit();}
else {
$lang = 'fr';$lang_bis = ($lang == 'fr') ? 'fr' : 'pt' ;
$id_page = 'espace_pro';
function print_tab($tab){
	if (!is_array($tab)) return false;
	static $balise_fermante = array();
	$str = "<ul class=\"ul_session\">\r\n";
	$balise_fermante[] = "</ul>\r\n";
	foreach ($tab as $k => $v) {
		if(is_array($v)){
			$str .= "<li>[<b>$k</b>] => <em>array</em>\r\n";
			$balise_fermante[] = "</li>\r\n";
			$str .= print_tab($v);
		} else {
			$str .= "<li>[<b>$k</b>] => <span style=\"color:#4285f4;\">".htmlentities($v)."</span>";
			$balise_fermante[] = "</li>\r\n";
		}
		$str .= array_pop($balise_fermante);
	}
	$str .= array_pop($balise_fermante);
	return $str;
}
include('bdd/bdd.php');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
	<head>
<?php include('header/head.php'); ?>
	</head>
	<body>
		<nav>
<?php include('nav/nav_'.$lang_bis.'.php'); ?>	
		</nav>
		<div id="wrapper">
		<div id="wrapper-before"></div>
			<header>
<?php include('header/header.php'); ?>
			</header>
			<main>
				<div class="main_sub">
					<h1>Bonjour <?php echo $_SESSION['prenom']; ?></h1>
					<p>Variable de session :</p>
					<?php echo print_tab($_SESSION); ?>
				</div>
			</main>
			<footer>
			</footer>
		</div>
		<div id="div_patientez"></div>
		<!--<script src="js/java.js"></script>-->
	</body>
</html>
<?php } ?>
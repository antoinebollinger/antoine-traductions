<?php 
session_start();
include('session/stop_message.php');
if (!isset($_SESSION['langue'])) {
	$_SESSION['langue'] = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}
if (isset($_POST['input_langue']) && $_POST['input_langue'] != '') {$_SESSION['langue'] = htmlspecialchars($_POST['input_langue']);}
$lang = $_SESSION['langue'];
$lang_bis = ($lang == 'fr') ? 'fr' : 'pt' ;
$id_page = 'index';
include('bdd/bdd.php');
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
	<head>
<?php include('header/head.php'); ?>
	</head>
	<body>
		<div id="wrapper-before"></div>
		<header>
<?php include('header/header.php'); ?>
		</header>
		<nav>
<?php include('nav/nav_'.$lang_bis.'.php'); ?>	
		</nav>
		<main>
			<div id="background"></div>
<?php include('main/main_'.$lang_bis.'.php'); ?>
		</main>
		<footer>
<?php include('footer/footer.php'); ?>
		</footer>
<?php include('doc/cgu.php');include('doc/cgv.php');include('doc/infos_ref.php'); ?>		
		<script src="js/java.js"></script>
	</body>
</html>
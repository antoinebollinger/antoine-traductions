<?php $id_sub_page = 'main_liste'; ?>
<div class="main_collec_left">
	<h3>Ma liste d'intérêt</h3>
	<p>Vous pouvez supprimer et/ou modifier les séries que vous avez déjà ajoutées à votre liste d'intérêt, puis m'envoyer cette liste par email.</p>
	<h3><i class="fas fa-tools"></i>Outils</h3>
	<ul>
		<li><button id="tout_supprimer" type="button"<?php if (isset($_SESSION['list']) && count($_SESSION['list']['id']) == 0) {echo ' disabled';}?>><i class="fas fa-trash-alt"></i><span>Tout supprimer</span></button></li>
		<li><button id="envoyer_mail" class="valider"><i class="fas fa-paper-plane"></i><span>Envoyer par email</span></button></li>
	</ul>
	
<?php 
	//echo print_tab($_SESSION['list']); 
?>
</div>
<div class="main_collec_right">
<?php 
if (isset($_SESSION['list']) && count($_SESSION['list']['id']) > 0) {
	foreach($_SESSION['list']['id'] as $key => $value) {
		echo '
<div class="id_liste" data-id="'.$value.'">
	<div>
		<div>
			<div class="id_liste_img" style="background-image:url(\'css/images/timbres/miniatures/'.$_SESSION['list']['photo'][$key].'\');"></div>
			<div class="id_liste_text">
				<h3>'.$_SESSION['list']['pays'][$key].'</h3>
				<p><b>'.$_SESSION['list']['annee'][$key].'</b></p>
				<p>N° Yvert : <b>'.$_SESSION['list']['yvert'][$key].'</b></p>
				<p>Cote : <b>'.$_SESSION['list']['cote'][$key].'</b> €</p>
			</div>
		</div>
	</div>
	<div>
		<div>
			<div class="id_liste_commentaire">
				<h4>Je suis intéressé(e) par :</h4>
				<p><b>'.$_SESSION['list']['commentaire'][$key].'</b></p>
				<p>Quantité souhaitée : <b>'.$_SESSION['list']['qte'][$key].'</b></p>
			</div>
			<div class="id_liste_modifier">
				<button type="button" class="valider modifier"><i class="fas fa-edit"></i><span>Modifier</span></button>
				<button type="button" class="retirer"><i class="fas fa-trash-alt"></i><span>Retirer</span></button>		
			</div>	
		</div>
	</div>
</div>
		';
	}
} else {
	echo '<h4>Votre liste est vide.</h4><p>Rendez-vous sur la <a class="noir" href="collection.php">collection</a> et trouvez les séries de timbre qui vous intéressent !</p>';
}
?>
<script>
var liste = $(".id_liste");
$(document).click(function(event) {
	var actual_ele = $(event.target).closest(liste);
	liste.removeClass('active');
	actual_ele.addClass('active');
});
$("button.retirer").click(function() {
	if (confirm("Êtes-vous certain de vouloir supprimer cette série de votre liste ?")) {
		var actual_ele = $(this).closest(liste);
		$.post('post/liste_fonctions.php',{action: 'retirer', id_delete: actual_ele.data('id')}, function() {
			location.reload();
		});
	}
});
$("#tout_supprimer").click(function(event) {
	event.preventDefault();
	if (confirm("Êtes-vous certain de vouloir tout retirer ?")) {
		$.post('post/liste_fonctions.php',{action: 'initialiser'},function() {
			location.reload();
		});
	}
});
liste.mousedown(function() {
	$(this).addClass("grabbing");
}).mouseup(function() {
	$(this).removeClass("grabbing");
});
</script>	
</div>
<div style="clear:both;"></div>
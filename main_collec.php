<?php $id_sub_page = 'main_collec'; ?>
<div class="main_collec_left">
<h3><i class="fas fa-search"></i>Recherche</h3>
<form method="get" action="collection.php" id="form_gen">
	<div id="div_search_sub">
		<input type="text" name="rech_gen" id="text_search_sub" value="<?php echo $rech_gen; ?>" placeholder=" " autocomplete="off" />
		<i id="delete_search" class="far fa-times-circle"></i>
	</div>
<h3><i class="fas fa-filter"></i>Filtres</h3>
<label for="pays">Pays (voir la <a id="show_map" class="noir">carte&nbsp;<i class="fas fa-globe"></i></a>)</label>
<script>
$("#show_map").click(function(event) {
	event.preventDefault();
	$("#div_map_1").addClass('active');
	setTimeout(set_map,310);
});
function set_map() {
	$("#div_map_3").append('<div id="div_map" style="width:100%;height:100%;"></div>');
	$('#div_map').vectorMap({
		map: 'world_mill',
		series: {
			regions: [{
				values: gdpData,
				scale: ['#C8EEFF', '#0071A4'],
				normalizeFunction: 'polynomial'
			}]
		}, 
		backgroundColor: '#ffffff'
	});	
}
</script>
<select name="pays" onchange="$('#form_gen').submit()">
	<optgroup label="Pays">
		<option value="">Tous les pays</option>	
<?php 
	$req = $bdd->prepare("SELECT pays FROM catalogue WHERE pays != '' AND annee LIKE :annee AND theme_1 LIKE :theme ".$type_query." GROUP BY pays ORDER BY pays");
	$req->execute(array('annee' => (($annee != '') ? $annee : "%"), 'theme' => (($theme != '') ? $theme : "%")));
	While ($donnees_pays = $req->fetch()) {
		echo '<option'.(($pays == $donnees_pays['pays']) ? " selected" : "").'>'.$donnees_pays['pays'].'</option>';
	}
	$req->closeCursor();
?>		
	</optgroup>
</select>
<label for="annee">Année</label>
<select name="annee" onchange="$('#form_gen').submit()">
	<optgroup label="Années">
		<option value="">Toutes les années</option>	
<?php 
	$req = $bdd->prepare("SELECT annee FROM catalogue WHERE pays LIKE :pays AND annee != '' AND theme_1 LIKE :theme ".$type_query." GROUP BY annee ORDER BY annee");
	$req->execute(array('pays' => (($pays != '') ? $pays : "%"), 'theme' => (($theme != '') ? $theme : "%")));
	While ($donnees_annee = $req->fetch()) {
		echo '<option'.(($annee == $donnees_annee['annee']) ? " selected" : "").'>'.$donnees_annee['annee'].'</option>';
	}
	$req->closeCursor();
?>		
	</optgroup>
</select>
<label for="theme">Thème</label>
<select name="theme" onchange="$('#form_gen').submit()">
	<optgroup label="Thèmes">
		<option value="">Tous les thèmes</option>	
<?php 
	$req = $bdd->prepare("SELECT theme_1 FROM catalogue WHERE pays LIKE :pays AND annee LIKE :annee AND theme_1 != '' ".$type_query." GROUP BY theme_1 ORDER BY theme_1");
	$req->execute(array('pays' => (($pays != '') ? $pays : "%"), 'annee' => (($annee != '') ? $annee : "%")));
	While ($donnees_theme = $req->fetch()) {
		echo '<option'.(($theme == $donnees_theme['theme_1']) ? " selected" : "").'>'.$donnees_theme['theme_1'].'</option>';
	}
	$req->closeCursor();
?>		
	</optgroup>
</select>
<label for="type">Dispoliste / mancoliste</label>
<select name="type" onchange="$('#form_gen').submit()">
	<optgroup label="Type">
		<option value=""<?php echo (($type == "") ? " selected" : ""); ?>>Tous</option>	
		<option value="Dispoliste"<?php echo (($type == "Dispoliste") ? " selected" : ""); ?>>Dispoliste</option>	
		<option value="Mancoliste"<?php echo (($type == "Mancoliste") ? " selected" : ""); ?>>Mancoliste</option>
	</optgroup>
</select>
<input type="text" id="page_input" name="page" style="display:none;" value="<?php echo $page; ?>" />
<input type="text" id="nb_par_page_input" name="nb_par_page" style="display:none;" value="<?php echo $nombreDeMessagesParPage; ?>" />
</form>
<h3>Filtres actifs</h3>
<div id="filtres_actifs">
<?php 
$result = '';
foreach($filtre as $key => $value) {
	$bg = "";
	if ($filtre[$key][0] == 'pays') {
		$req = $bdd->prepare('SELECT drapeau FROM pays WHERE pays = :pays');
		$req->execute(array('pays' => $filtre[$key][1]));
		$donnees = $req->fetch();
		$req->closeCursor();
		$bg = 'style="background-image:url(\'css/images/drapeaux/'.$donnees['drapeau'].'\');" class="filtre_pays"';
	}
	echo '<h5 alt="'.$filtre[$key][0].'" title="Cliquez sur la croix pour supprimer ce filtre"'.$bg.'>'.$filtre[$key][1].'<i class="far fa-times-circle"></i></h5>';
	$result .= '<b>'.$filtre[$key][1].'</b>'.(($key + 1 < count($filtre)) ? ', ' : '');
}
echo ($result == '') ? '<p>Aucun filtre actif</p>' : '';
?>
<div style="clear:both"></div>
</div>
<form method="get" action="collection.php" id="form_gen_reset">
<input type="hidden" name="page" value="1" />
<input type="hidden" name="rech_gen" id="rech_gen" value="<?php echo $rech_gen; ?>" />
<input type="hidden" name="pays" id="pays" value="<?php echo $pays; ?>" />
<input type="hidden" name="annee" id="annee" value="<?php echo $annee; ?>" />
<input type="hidden" name="theme" id="theme" value="<?php echo $theme; ?>" />
<input type="hidden" name="type" id="type" value="<?php echo $type; ?>" />
<!--<input type="hidden" name="page" value="<?php echo $page; ?>" />-->
<input type="hidden" name="nb_par_page" value="<?php echo $nombreDeMessagesParPage; ?>" />
</form>

<h3>Légende</h3>
	<p class="p_legende"><span class="double"></span>Dispoliste</p>
	<p class="p_legende"><span class="mancoliste"></span>Mancoliste</p>
	<p class="p_legende"><span class="present"></span><i class="fas fa-shopping-basket"></i> Dans ma liste d'intérêt</p>
</div>
<div class="main_collec_right<?php echo ((isset($_SESSION['list_grid']) && $_SESSION['list_grid'] == 'grid') ? ' grid' : ''); ?>">
<?php 
$swiper_html = ''; $nb_count = 0;
if ($nb_total > 0) {
	$req_gen = $bdd->prepare($main_query.' LIMIT '.$premierMessageAafficher.','.$nombreDeMessagesParPage);
	$req_gen->execute($main_query_array);
	$id_slide = 0; $nb_count = $premierMessageAafficher; $pays_actuel ="";
	echo '<fieldset>';
	While ($donnees = $req_gen->fetch()) {
		if ($donnees['pays'] != $pays_actuel) {
			echo '<div style="clear:both"></div></fieldset>			
			<fieldset class="palette"><legend><h2 style="background-image:url(\'css/images/drapeaux/'.$donnees['drapeau'].'\')">'.$donnees['pays'].'</h2></legend>';
			$pays_actuel = $donnees['pays'];
		}
		$nb_count++; $add_class = " active"; $delete_class = " unactive"; $present_class = "";
		if (isset($_SESSION['list']) && count($_SESSION['list']['id']) > 0 && in_array($donnees['id'],$_SESSION['list']['id'])) {
			$add_class = " unactive"; $delete_class = " active"; $present_class = " present";
		}
		$double_class = ($donnees['nbr'] > 1) ? " double" : "";
		$mancoliste_class = ($donnees['nbr'] == 0) ? " mancoliste" : "";
		$disabled_class = ($donnees['nbr'] <= 1) ? " disabled" : "";
		echo '
<div class="id_timbre'.$mancoliste_class.$double_class.$present_class.'" id="vigne_'.$donnees['id'].'">
	<div class="id_timbre_img" style="background-image:url(\'css/images/timbres/miniatures/'.$donnees['image'].'\');" data-id="'.$id_slide.'"></div>
	<div class="id_timbre_text">
		<h4>'.$donnees['pays'].'</h4>
		<p><b>'.$donnees['annee'].'</b></p>
		<p><b>'.($donnees['theme_1'] != '' ? $donnees['theme_1'] : '&nbsp;').'</b></p>
		<p><b>'.($donnees['nb_valeur'] != '' ? $donnees['nb_valeur'] : '&nbsp;').'</b></p>
		<p>N° Yvert : <b>'.$donnees['yvert'].'</b></p>
		<p>Cote : <b>'.$donnees['cote'].'</b> €</p>
	</div>
	<div class="id_timbre_button">
		<button	data-id="'.$donnees['id'].'" class="valider ajouter'.$add_class.'"'.$disabled_class.'><i class="fas fa-shopping-basket"></i><span>Ajouter à ma liste</span></button>
		<button data-id="'.$donnees['id'].'" class="retirer'.$delete_class.'"'.$disabled_class.'><i class="fas fa-trash-alt"></i><span>Retirer de ma liste</span></button>
	</div>
	<div style="clear:both;"></div>	
</div>';
$swiper_html .= '
<div class="swiper-slide" id="slide_'.$donnees['id'].'">
	<div class="card'.$mancoliste_class.$double_class.$present_class.'">
		<div>
			<div class="sliderText">
				<img src="css/images/timbres/'.$donnees['image'].'" data-magnify-src="css/images/timbres/'.$donnees['image'].'" />
			</div>
			<div class="content">
				<h4>'.$donnees['pays'].'</h4>
				<p><b>'.$donnees['annee'].'</b></p>
				<p><b>'.($donnees['theme_1'] != '' ? $donnees['theme_1'] : '&nbsp;').'</b></p>
				<p><b>'.($donnees['nb_valeur'] != '' ? $donnees['nb_valeur'] : '&nbsp;').'</b></p>
				<p>N° Yvert : <b>'.$donnees['yvert'].'</b></p>
				<p>Cote : <b>'.$donnees['cote'].'</b> €</p>
			</div>
			<div class="data"  data-id_ajout="'.$donnees['id'].'" data-libelle_ajout="'.$donnees['libelle'].'" data-photo_ajout="'.$donnees['image'].'" data-pays_ajout="'.$donnees['pays'].'" data-annee_ajout="'.$donnees['annee'].'" data-yvert_ajout="'.$donnees['yvert'].'" data-cote_ajout="'.$donnees['cote'].'"></div>
		</div>
		<button	data-id="'.$donnees['id'].'" class="valider ajouter'.$add_class.'"'.$disabled_class.'><i class="fas fa-shopping-basket"></i><span>Ajouter à ma liste</span></button>
		<button data-id="'.$donnees['id'].'" class="retirer'.$delete_class.'"'.$disabled_class.'><i class="fas fa-trash-alt"></i><span>Retirer de ma liste</span></button>
		<div style="clear:both;"></div>
	</div>
</div>
';
		$id_slide++;
	}
	$req_gen->closeCursor();
	echo '<div style="clear:both;"></div></fieldset>';
} else {
	echo '<p>Pas de résultat</p>';
}
?>

</div>
<div style="clear:both;"></div>
<div id="main_collec_results">
	<div class="results-table">
		<div class="results-table-cell">
			<h4>
				<i class="fas fa-angle-double-left<?php echo ($page != 1 && $nombreDePages != 0) ? ' active' : ''; ?>" alt="1"></i>
				<i class="fas fa-angle-left min_w<?php echo ($page != 1 && $nombreDePages != 0) ? ' active' : ''; ?>" alt="<?php echo ($page > 1) ? $page - 1 : 1; ?>"></i>
				<span><input id="change_page" type="text" min="1" max="<?php echo $nombreDePages; ?>" value="<?php echo $page; ?>" /><?php echo ' / '.(($nombreDePages > 0) ? $nombreDePages : 1); ?></span>
				<i class="fas fa-angle-right min_w<?php echo ($page != $nombreDePages && $nombreDePages != 0) ? ' active' : ''; ?>" alt="<?php echo ($page < $nombreDePages) ? $page + 1 : $nombreDePages; ?>"></i>
				<i class="fas fa-angle-double-right<?php echo ($page != $nombreDePages && $nombreDePages != 0) ? ' active' : ''; ?>" alt="<?php echo $nombreDePages; ?>"></i>
			</h4>	
		</div>	
		<div class="results-table-cell">
			<p>
				<span id="list_grid">Affichage : <i class="fas fa-list-ul<?php echo ((isset($_SESSION['list_grid']) && $_SESSION['list_grid'] == 'list') ? ' active' : ''); ?>" id="aff_list" alt="list" title="Afficher sous forme de liste."></i> <i class="fas fa-th<?php echo ((isset($_SESSION['list_grid']) && $_SESSION['list_grid'] == 'grid') ? ' active' : ''); ?>" id="aff_grid" alt="grid" title="Afficher sous forme de grille."></i> | </span><span class="a_swiper" data-id="0"><i class="far fa-images"></i> Mode Diapo</span> | <label for="nb_par_page">Afficher</label>
				<select name="nb_par_page" id="nb_par_page_select" onchange="">
					<option<?php echo ($nombreDeMessagesParPage == 50) ? ' selected' : ''; ?> value="50">50</option>
					<option<?php echo ($nombreDeMessagesParPage == 100) ? ' selected' : ''; ?> value="100">100</option>
					<option<?php echo ($nombreDeMessagesParPage == 150) ? ' selected' : ''; ?> value="150">150</option>
					<option<?php echo ($nombreDeMessagesParPage == 200) ? ' selected' : ''; ?> value="200">200</option>		
				</select>
			<label>résultats par page.</label>
			</p>			
		</div>
		<div class="results-table-cell">
			<p>Résultat(s) : <b><?php echo $nb_total; ?></b> <em>(affichage des résultats <?php echo ($nb_total == 0) ? '0' : $premierMessageAafficher + 1; ?> à <?php echo $nb_count; ?>)</em> | Filtres actifs : <?php echo ($result != '') ? $result : '<b>aucun</b>'; ?></p>
		</div>
	</div>
</div>
<div id="details">
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php echo $swiper_html; ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</div>
<script src="js/swiper.min.js"></script>
<script>
$(document).ready(function() {
	$("button.ajouter").click(function() {
		var id_a_ajouter = $(this).data('id');
		$.post('post/present_liste.php',{id:id_a_ajouter},function(data) {
			if (data.present_liste == 'oui') {
				if(confirm("Cette série est déjà dans votre liste. Souhaitez-vous l'ajouter à nouveau ? Nous vous conseillons de vous rendre sur votre liste d'intérêt et de modifier la série")) {
					ajouter(id_a_ajouter);
				}
			} else {
				ajouter(id_a_ajouter);
			}
		},'json');
	});
	function ajouter(id) {
		$("#ajout_serie_photo").empty().append($("#slide_"+id+" .card div").html());
		setTimeout(light_div,100);
		function light_div() {
			$("#div_ajout_serie_1").addClass("active");
		}
	}
	$("button.retirer").click(function() {
		if (confirm("Êtes-vous certain de vouloir supprimer cette série de votre liste ?")) {
			var id_a_suppr = $(this).data('id');
			$.post('post/liste_fonctions.php',{action: 'retirer', id_delete: id_a_suppr}, function() {
				$.post('post/nb_liste.php',{}, function(data) {
					$("#p_direct_liste span").text(data.nb_liste);
					$("#vigne_"+id_a_suppr+" button.retirer, #slide_"+id_a_suppr+" button.retirer").removeClass("active").addClass("unactive");
					$("#vigne_"+id_a_suppr+" button.ajouter, #slide_"+id_a_suppr+" button.ajouter").removeClass("unactive").addClass("active");
					$("#vigne_"+id_a_suppr+", #slide_"+id_a_suppr+" .card").removeClass('present');
				},'json');
			});
		}
	});
	var swiper; var magnify; var swiper_id;
	$(".a_swiper, .id_timbre_img").click(function(event) {
		event.preventDefault();
		swiper_id = $(this).data('id');
		setTimeout(light_swiper,100);
	});
	function light_swiper() {
		swiper = new Swiper('.swiper-container', {
			initialSlide: swiper_id, 
			effect: 'coverflow',
			grabCursor: true,
			centeredSlides: true,
			slidesPerView: 'auto',
			coverflowEffect: {
				rotate: 30,
				stretch: 0,
				depth: 200,
				modifier: 1,
				slideShadows : true,
			},
			pagination: {
				el: '.swiper-pagination',
				type: 'fraction'
			},
			keyboard: {
				enabled: true,
				onyInViewport: false,
			},
			on: {
				init: function() {
					magnify = $(".swiper-slide-active .sliderText img").magnify();
				},
				slideChange: function() {
					magnify.destroy();
					magnify = $($(".swiper-slide").get(swiper.activeIndex)).find(".sliderText img").magnify();
				},
			},
		});
		$("#details").addClass('active').animate({opacity: 1}, function() {$("#details").addClass('active');});
	}
	$(".swiper-slide").mousedown(function() {$(this).addClass("grabbing");}).mouseup(function() {$(this).removeClass("grabbing");});
	$("#details").click(function(event) {
		if (event.target.id == this.id || event.target.classList.contains('swiper-container')) {details_close();}
	});
	function details_close() {
		$("#details").animate({opacity:0},200,'linear', function() {
			magnify.destroy();
			swiper.destroy();				
			$("#details").removeClass('active');
		});
	}
	var liste = $(".id_timbre");
	$(document).click(function(event) {
		if (!$("#div_ajout_serie_1").hasClass('active') && !$("#details").hasClass('active')) {
			$(".id_timbre").removeClass('active');
			$(event.target).closest(liste).addClass('active');
		}
	});	
	liste.mousedown(function() {
		$(this).addClass("grabbing");
	}).mouseup(function() {
		$(this).removeClass("grabbing");
	});
});
 </script>
<script>var cur_page = <?php echo $page; ?>, nb_par_page = <?php echo $nombreDeMessagesParPage; ?>, nombreDePages = <?php echo $nombreDePages; ?>;</script>
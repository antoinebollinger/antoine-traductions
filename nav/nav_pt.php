<div id="menu_icon">
	<div class="menu-icon menu-icon-cross">
		<span></span>
		<svg x="0" y="0" width="40px" height="40px" viewBox="0 0 40 40">
		<circle cx="20" cy="20" r="18"></circle>
		</svg>
	</div>
</div>
<div class="nav-icons">
	<div class="nav-langue">
		<img src="css/images/france.png" <?php if ($lang == 'fr') {echo 'class="active" title="Le site est déjà en français."';} else {echo 'title="Passer au français (ma spécialité)."';} ?> alt="fr" />
		<img src="css/images/brasil.png" <?php if ($lang != 'fr') {echo 'class="active" title="O site já está em português."';} else {echo 'title="Mudar para o português."';} ?> alt="pt"  />
		<div style="clear:both;"></div>
		<form action="index.php" method="post" id="form_langue">
			<input name="input_langue" type="hidden" id="input_langue" />
		</form>
	</div>
	<div class="nav-close">
		<p id="nav-close"><i class="fas fa-times"></i><span><?php echo ($lang == 'fr') ? 'FERMER' : 'FECHAR' ; ?></span></p>
	</div>
</div>
<div class="nav-nav">
	<ul>
		<li id="main_nav_li_0" title="Voltar para o início." alt="Home">Home</li>
		<li id="main_nav_li_1" title="Saber mais sobre eu..." alt="Meu trabalho">Meu trabalho</li>
		<li id="main_nav_li_2" title="... e o que eu já produzi" alt="Minhas referências">Referências</li>
		<li id="main_nav_li_3" title="Pois é..." alt="Tarifas">Tarifas</li>
		<li id="main_nav_li_4" title="...mas ficamos em contato!" alt="Contato">Contato</li>
	</ul>
</div>
<div class="nav-footer">
	<p><i class="fas fa-phone-square"></i>&nbsp;<span itemprop="tel">+33 6 11 80 63 96</span></p>
	<p><i class="fas fa-envelope-square"></i>&nbsp;<a href="mailto:antoine.bollinger@gmail.com">antoine.bollinger@gmail.com</a></p>
	<p><a href="" id="link_cgu">Menções Legais & CGU</a> | <a href="login.php" id="link_pro" target="_blank">Espaço PRO</a></p>
</div>
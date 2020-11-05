<div class="header-column header-left">
	<div id="div_menu">
		<p><i class="fas fa-bars"></i><span>MENU</span></p>
	</div>
</div>
<div class="header-column header-center">
	<a href="index.php">
		<div id="div_logo">
			<p class="caveat">Antoine Traductions</p>
			<p><?php echo ($lang == 'fr') ? 'Portugais-Français' : 'Português-Francês' ; ?></p>
		</div>
	</a>
</div>
<div class="header-column header-right">
	<p id="div_social">
		<a class="btns-linkedin-share a-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=https://www.antoine-traductions.com" onclick="window.open(this.href, '', 'height=500, width=500, top=100, left=500'); return false;"><i class="fab fa-linkedin-in"></i></a>
		<a href="https://plus.google.com/share?url=https://www.antoine-traductions.com" onclick="window.open(this.href, '', 'height=500, width=500, top=100, left=500'); return false;" class="a-google"><i class="fab fa-google-plus-g"></i></a>
		<a href="https://twitter.com/intent/tweet?url=https://www.antoine-traductions.com" onclick="window.open(this.href, '', 'height=500, width=500, top=100, left=500'); return false;" class="a-twitter"><i class="fab fa-twitter"></i></a>
		<a href="https://www.facebook.com/sharer.php?u=https://www.antoine-traductions.com" onclick="window.open(this.href, '', 'height=500, width=500, top=100, left=500'); return false;" class="a-facebook"><i class="fab fa-facebook-f"></i></a>
	</p>
	<div id="div_logout">
		<p><a href="javascript:if(confirm('&Ecirc;tes-vous sûr de vouloir vous déconnecter ?')) document.location.href='session/deconnexion.php'">
			<i class="fas fa-sign-out-alt"></i><span>DECONNECTION</span>
		</a></p>
	</div>	
</div>
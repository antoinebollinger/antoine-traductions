$(window).load(function(){
	$("header .header-left, nav #nav-close, #wrapper-before, #link_cgu, #menu_icon, #link_pro").click(function() {
		body_right();
	});
	var mainItems = $("section").length,
	menuItems = $("nav").find("li"),
	id_header,curId,
	headerItems = $("#main_main_0 h1").length;
	if ($("#menu_icon").css("display") == 'none') {	
		activeNav(getId());
		bgPercent(scrollPercent());
	} else {
		$("#main_main_0").addClass('active');
		activeNav_mobile();
	}
	menuItems.click(function(e){
		e.preventDefault();
		item_click(parseInt($(this).attr("id").substring(12)));
		body_right();
	});
	$(window).scroll(function(){
		if ($("#menu_icon").css("display") == 'none') {
			activeNav(getId());
			bgPercent(scrollPercent());
		} else {
			activeNav_mobile();
		}
	});
	function item_click(target_id) {
		if ($("#menu_icon").css("display") == 'none') {
			var offsetTop = target_id*$("html").height()+((target_id == 0) ? 0 : 50);
			var temps = 100;
		} else {
			var offsetTop = $("#main_main_"+target_id).offset().top-50;
			var temps = 300;
		}
		$('html, body').stop().animate({scrollTop: offsetTop}, temps);		
	}
	function getId() {
		var id = parseInt(mainItems - (((mainItems*$("html").height())-($(window).scrollTop()))/ $("html").height()));
		return id;
	}
	function activeNav(id) {
		if (id > 0) {
			$("footer").addClass('active');
			$("nav").addClass('active');
			$("body").addClass('active');
		} else {
			$("footer").removeClass('active');
			$("nav").removeClass('active');
			$("body").removeClass('active');
		}
		$("nav li").removeClass('active');
		$("#main_nav_li_"+id).addClass('active');
		if (!$("#background").hasClass('main_'+id)) {
			$('#background').fadeOut(200,function() {
				$('#background').removeClass().addClass('main_'+id).fadeIn(300);
			});
		}
		for (var i=0; i<mainItems; i++) {
			if (i < id) {$("#main_main_"+i).removeClass('active').addClass('active_out');}
			if (i == id) {
				$("#main_main_"+i).removeClass('active_out').addClass('active');

			}
			if (i > id) {$("#main_main_"+i).removeClass('active active_out');}
		}
	}
	function activeNav_mobile() {
		$("section").each(function() {
			var scrollId = $(this).offset().top-$(window).scrollTop()-51;
			if (scrollId <= 0) {
				curId = $(this).attr("id").substring(10);
			}
		});
		if ($(window).scrollTop() > 0) {
			$("body").addClass('active');
		} else {
			$("body").removeClass('active');
		}
		$("nav li").removeClass('active');
		$("#main_nav_li_"+curId).addClass('active');		
	}
	function scrollPercent() {
		if ($('body').css('height') != ((mainItems*100)+20)+'%') {$('body').css('height',((mainItems*100)+20)+'%');}
		percent = ((100/($("body").height()-$("html").height()))*($(window).scrollTop()));
		return percent;
	}
	function bgPercent(percent) {
		if (!$('body').hasClass('unactive')) {
			$('body').css('background-position-y',percent+'%');
			//$("body").css("background-position","100% "+(percent)+"%");
		}
	}
	function body_right() {
		if ($("#menu_icon").css("display") == 'none') {	
			if ($('body').hasClass('body-right')) {
				$('body').removeClass('body-right');
			} else {
				$('body').addClass('body-right');
			}
		} else {
			if ($("#menu_icon").hasClass("active")) {
				$("#menu_icon").removeClass('active');
				$('body').removeClass('body-right'); 
			} else {
				$("#menu_icon").addClass('active');
				$('body').addClass('body-right'); 
			} 			
		}
	}
	//ANIMATION
	$("#rejouer_anime").click(function() {
		if ($(this).hasClass('active')) {anime_reset();anime();}
	});
	$("#pause_anime").click(function() {
		if (!$(this).hasClass('unvisible')) {
			pause();
		}
	});
	$("#sub_main_barre_sub").click(function() {
		if (!$(this).hasClass('pause')) {
			pause();
		} else {
			jouer();
		}
	});
	$("#jouer_anime").click(function() {
		if (!$(this).hasClass('unvisible')) {
			jouer();
		}
	});	
	function pause() {
		$("#pause_anime").addClass('unvisible');
		$("#jouer_anime").removeClass('unvisible');
		$("#pause_anime").addClass('pause');
		$("#jouer_anime").addClass('pause');
		$("#rejouer_anime").addClass('pause');
		$("#main_main_0 h1").addClass('pause');
		$("#main_main_0 .sub_main_bg").addClass('pause');
		$("#main_main_0 .sub_main_fg").addClass('pause');
		$("#sub_main_barre_sub").addClass('pause');		
	}
	function jouer() {
		$("#jouer_anime").addClass('unvisible');
		$("#pause_anime").removeClass('unvisible');
		$("#jouer_anime").removeClass('pause');
		$("#pause_anime").removeClass('pause');
		$("#rejouer_anime").removeClass('pause');			
		$("#main_main_0 h1").removeClass('pause');
		$("#main_main_0 .sub_main_bg").removeClass('pause');
		$("#main_main_0 .sub_main_fg").removeClass('pause');
		$("#sub_main_barre_sub").removeClass('pause');			
	}
	anime();
	function anime() {
		setTimeout(anime_tmp,400);
	}
	function anime_reset() {
		$("#main_main_0 .sub_main_bg").removeClass('active').addClass('unactive');
		$("#main_main_0 .sub_main_fg").removeClass('active').addClass('unactive');
		$("#sub_main_barre_sub").removeClass('active');		
		$("#main_main_0 h1").removeClass('active');	
		$("#rejouer_anime").removeClass('active');	
		$("#jouer_anime").removeClass('active');
		$("#jouer_anime").addClass('unvisible');
		$("#pause_anime").removeClass('active');	
		
	}
	function anime_tmp() {
		id_header = 1; 
		if ($("#menu_icon").css("display") == 'none') {
			var total = 10,multi = 3.5;
			for (var i=0;i<headerItems;i++) {
				var id=i+1,
				delai = multi*Math.sqrt((4/(headerItems-1))*i),
				duration = total-delai;
				$("#header_"+id).css("animation-duration",duration+"s");
				setTimeout(header,1000*delai);
			}
			$("#main_main_0 .sub_main_bg").removeClass('unactive').addClass('active');	
			$("#main_main_0 .sub_main_fg").removeClass('unactive').addClass('active');
			$("#sub_main_barre_sub").addClass('active');		
			$("#rejouer_anime").addClass('active');
			$("#pause_anime").addClass('active');
			$("#jouer_anime").addClass('active');
		}		
	}
	function header() {
		if (id_header <= headerItems) {
			$("#header_"+id_header).addClass("active");
		}
		id_header++;
	}
});

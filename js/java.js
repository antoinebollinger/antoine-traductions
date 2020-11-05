$(function(){
	setInterval(function(){
		var slide_width = $(".slideshow").width();
		$(".slideshow ul").animate({marginLeft:-slide_width},800,function(){
			$(this).css({marginLeft:0}).find("li:last").after($(this).find("li:first"));
		});
	}, 10000);
});
CKEDITOR.replace('textarea_message', {language: 'fr', uiColor: '#EFEFEF'});
$(window).load(function(){
	$("#envoyer_email").click(function() {
		var mon_message = CKEDITOR.instances.textarea_message.getData();
		if (mon_message != '') {
			envoi_mail(mon_message);
		} else {
			alert("Votre message est vide, il n'est pas envoyé.");
		}
	});
	function envoi_mail(mon_message) {
		$("#wrapper-before").addClass("active");
		var posting = $.post('post/mail.php', {
		nom: $("#input_nom").val(),
		email: $("#input_email").val(),
		sujet: $("#input_sujet").val(),
		message: mon_message}, 
		function(data) {
			if (data.envoye == 'oui') {
				alert('Votre message a bien été envoyé, nous nous efforcerons de vous répondre dans les plus brefs délais.');
				location.reload();
			}
			$("#wrapper-before").removeClass("active");
		}, "json" );		
	};
	$(".nav-langue img").click(function() {
		$("#input_langue").val($(this).attr('alt'));
		$("#form_langue").submit();
	});
	$("#link_livre").click(function(event) {
		event.preventDefault();
		$('body').addClass('block');
		$("#div_livre_1").addClass('active');
	});
	$("#fermer_livre").click(function(event) {
		event.preventDefault();
		$('body').removeClass('block');
		$("#div_livre_1").removeClass('active');
	});
	$("#link_cgu").click(function(event) {
		event.preventDefault();
		$('body').addClass('block');
		$("#div_cgu_1").addClass('active');
	});
	$("#fermer_cgu").click(function(event) {
		event.preventDefault();
		$('body').removeClass('block');
		$("#div_cgu_1").removeClass('active');
	});
	$("#div_cgu_1").click(function(event) {
		event.preventDefault();
		if (event.target.id == 'div_cgu_1') {
			$('body').removeClass('block');
			$(this).removeClass('active');
		}
	});
	$("#link_cgv").click(function(event) {
		event.preventDefault();
		$('body').addClass('block');
		$("#div_cgv_1").addClass('active');
	});
	$("#fermer_cgv").click(function(event) {
		event.preventDefault();
		$('body').removeClass('block');
		$("#div_cgv_1").removeClass('active');
	});
	$("#div_cgv_1").click(function(event) {
		event.preventDefault();
		if (event.target.id == 'div_cgv_1') {
			$('body').removeClass('block');
			$(this).removeClass('active');
		}
	});
	//INFOS REF
	$("#main_main_2 .picture").click(function() {
		$("#wrapper-before").addClass("active");
		$.post('post/req_infos_ref.php',{id:$(this).data('id')},function(data) {
			$("#div_infos_ref").empty().prepend(data);
			$("#wrapper-before").removeClass("active");
			$('body').addClass('block');
			$("#div_infos_ref_1").addClass('active');
		},'html');
	});
	$("#fermer_infos_ref").click(function(event) {
		event.preventDefault();
		$('body').removeClass('block');
		$("#div_infos_ref_1").removeClass('active');
	});
	$("#div_infos_ref_1").click(function(event) {
		if (event.target.id == 'div_infos_ref_1' || event.target.id == 'div_infos_ref') {
			event.preventDefault();
			$('body').removeClass('block');
			$(this).removeClass('active');
		}
	});	
});
jQuery(document).ready(function($){
  
  var data = {
		'action'   : 'toplist_cz_dashboard_content',
		'_wpnonce' : $("#toplist_cz_dashboard .inside #toplist_nonce").attr("value"),
		'whatever' : 1234
	};

	$.post(ajaxurl, data, function(response) {
	  $("#toplist_cz_dashboard .inside").html(response).slideDown();
	})
	.fail(function() {
	  $("#toplist_cz_dashboard .inside").html("fail").slideDown();
	});

  $('body').on('click', '#toplist_cz_dashboard #toplist_password_form #toplist_password_submit', function() {
    var pwd = $(this).parents("form").find("#toplist_password");
    if (pwd.val() == '') {
      pwd.css('background-color', 'LightPink');
      alert('Please fill-in the password.');
      return;
    }
    var data = {
  		'action'   : 'toplist_cz_save_password',
  		'_wpnonce' : $(this).parents("form").find("#toplist_password_nonce").val(),
  		'password' : pwd.val()
  	};
// disable the input fields here
// show rolling circle
    $.post(ajaxurl, data, function(response) {
  	  $("#toplist_cz_dashboard .inside").html(response);
  	})
  	.fail(function() {
  	  // $("#toplist_cz_dashboard .inside").html("fail").slideDown();
  	});    

  });

});
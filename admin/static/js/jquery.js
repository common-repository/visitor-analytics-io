// debugger
console.log('jquery.js loaded');

// debug 
console.log('$visaIoUid = <?php echo $visaIoUid; ?>');
console.log('$visaIoWid = <?php echo $visaIoWid; ?>');

// jQuery 
jQuery(document).ready(function() {
	// test jQ 
    console.log('jQ is ready!');
	
	// toggle forms 
	jQuery('#account-existing').hide();
	jQuery('#installation-complete').hide();
	
	// 
	jQuery('.account-new-show').click( function() {
		// divs 
		jQuery('#account-new').show();
		jQuery('#account-existing').hide();
		jQuery('#installation-complete').hide();
		// buttons
		jQuery('#buttons').show();
		// css 
		jQuery('button.account-new-show').addClass('active');
		jQuery('button.account-existing-show').removeClass('active');
		jQuery('account-installation-complete').removeClass('active');
	});
	// 
	jQuery('.account-existing-show').click( function() {
		// divs 
		jQuery('#account-existing').show();
		jQuery('#account-new').hide();
		jQuery('#installation-complete').hide();
		// buttons
		jQuery('#buttons').show();
		// css 
		jQuery('button.account-new-show').removeClass('active');
		jQuery('button.account-existing-show').addClass('active');
		jQuery('account-installation-complete').removeClass('active');
	});	
	// 
	jQuery('.account-installation-complete').click( function() {
		// divs 
		jQuery('#account-existing').hide();
		jQuery('#account-new').hide();
		jQuery('#installation-complete').show();
		// buttons
		jQuery('#buttons').hide();
		// css 
		jQuery('button.account-new-show').removeClass('active');
		jQuery('button.account-existing-show').removeClass('active');
		jQuery('account-installation-complete').addClass('active');
	});	
	
	// language selector
	jQuery('#content-footer-language-selector').click( function() {
		// 
		if(jQuery("#content-footer-language-selection").is(":visible")) {
			jQuery("#content-footer-language-selection").hide();
		} else {
			jQuery("#content-footer-language-selection").show();
		}
	});
	
	// language selector :hover 
	jQuery('.languages-selector-rounded-div').hover( function() {
		jQuery(this).addClass('languages-selector-rounded-div-hover');
	},
	function() {
		jQuery(this).removeClass('languages-selector-rounded-div-hover');
	}
	
	);

	jQuery('.wrapper .button-signUp .Open.Dashboard.disabled').click( function(ev) {
		ev.preventDefault();
	});
	jQuery('.wrapper #visitor_analytics_site_id').keyup( function() {
		if(jQuery(this).val() == "")
			jQuery('.wrapper .websiteid .input-box.button-saveid').hide();
		else
			jQuery('.wrapper .websiteid .input-box.button-saveid').show();
	});
	jQuery('.wrapper .update-website-id').click( function() {
		console.log('here1');
		jQuery(this).hide();
		jQuery('.wrapper .success-saved').hide();
		jQuery('.wrapper .button-verify').hide();
		jQuery('.wrapper .success-icon').hide();
		jQuery('.wrapper .enter-website-id').show();
		jQuery('.wrapper .button-saveid').show();
		jQuery('.wrapper .enter-website-icon').removeClass("hide-icon");
		jQuery('.wrapper .bullet.tracking').removeClass("success-error-icon");
		jQuery('.wrapper .Open.Dashboard').addClass("disabled");
		jQuery('.wrapper .Open.Dashboard').attr('href', '#')
	});
});
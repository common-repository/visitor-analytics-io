<?php

// let script not be called out of context 
defined('ABSPATH') or die();

// extract values from the previous installation 
$visaIoJson = json_decode(get_option('visitor_analytics_io'));
$visaIoWid = '';
if(is_object($visaIoJson)){
	$visaIoUid = $visaIoJson->uid;
	$visaIoWid = $visaIoJson->wid;
}

// update the website id with the one from the former API solution 
$migration_done = FALSE;
$visitor_analytics_migration_done = get_option('visitor_analytics_migration_done');
if(esc_attr(get_option('visitor_analytics_site_id')) == '' && (!$visitor_analytics_migration_done || $visitor_analytics_migration_done != TRUE)) {
	// update website id 
	update_option('visitor_analytics_site_id', $visaIoWid);
	// set flag that migration is done
	$migration_done = TRUE;
	update_option('visitor_analytics_migration_done', $migration_done); 
}

// get current locale 
$wpLocale = substr(get_locale(), 0, 2);

// 
$visaLocales = array('en', 'de', 'es', 'pt', 'it', 'fr');
$thisVisaLocale = 'en';

// 
if(isset($_GET['visaLocale']) && $_GET['visaLocale'] && in_array($_GET['visaLocale'], $visaLocales)) {
	//
	$thisVisaLocale = $_GET['visaLocale'];
} else {
	// 
	if(in_array($wpLocale, $visaLocales)) {
		$thisVisaLocale = $wpLocale;
	}
}


// LIVE 
$i18nUrl = 'https://cdn.twipla.com/translations/plugins/'.$thisVisaLocale.'.json';
// get json content 
$i18n = json_decode(getCurl($i18nUrl));


// get $visitor_analytics_site_id
$visitor_analytics_site_id = esc_attr(get_option('visitor_analytics_site_id'));
if($visitor_analytics_site_id != '') {
	$visitor_analytics_site_id_isset = true;
}

?>

<?php /* MIGRATION DONE MESSAGE */ ?> 
<?php if($migration_done): ?>
<div id="message" class="notice notice-success is-dismissible">
	<p><?php echo parseI18n($i18n->messages->upgradeToLatestVersionSuccessful); ?></p>
</div>
<?php endif; ?>

<?php /* MESSAGES */ ?> 
<?php if(isset($_GET['settings-updated'])): ?>
    <?php if(esc_attr(get_option('visitor_analytics_site_id')) == ''): ?>
        <div id="message" class="notice notice-warning is-dismissible">
            <p><?php _e('TWIPLA script is disabled.', 'VisitorAnalytics'); ?></p>
        </div>
    <?php else: ?>
        <div id="message" class="notice notice-success is-dismissible">
                <p>
				<?php echo parseI18n($i18n->messages->installationSuccessful); ?> <b><?php echo htmlspecialchars($visitor_analytics_site_id, ENT_QUOTES, 'UTF-8'); ?></b> 
				&raquo; 
				<a href="<?php echo 'https://app.twipla.com/website/'.htmlspecialchars($visitor_analytics_site_id, ENT_QUOTES, 'UTF-8').'/settings/tracking-code'; ?>" target="_blank">
					<?php echo parseI18n($i18n->textLinks->verifyInstallation); ?>
				</a>
				<?php /*
				<br/>
				<?php 
					echo sprintf( 
						__(parseI18n('TWIPLA has been installed for website ID <b>successfully</b> "%s" &raquo; <a href="%s" target="_blank">Click here to verify your install</a>.'), 
						'VisitorAnalytics'), 
						get_option('visitor_analytics_site_id'), 
						'https://app.twipla.com/website/'.get_option('visitor_analytics_site_id').'/settings/tracking-code'); 
				?>
				*/ ?>
				</p>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php
	$visitor_analytics_site_id_valid = false;
	if($visitor_analytics_site_id != ""){
		$visitor_analytics_site_id_valid = isValidUuid($visitor_analytics_site_id);
	}
?>

<div id="wp_visa_body">
	<!-- wp_visa_header --> 
	<div id="wp_visa_header" class="top header">
		<div class="desktop heading">
			<h1><?php echo parseI18n($i18n->wordpress->main->headline); ?></h1>
			<h2 class="desktop-show"><?php echo parseI18n($i18n->wordpress->main->subtitle); ?></h2>
			<h2 class="mobile-show">Complete Website Intelligence</h2>
		</div>
		<hr class="header-line" />
	</div>
	
	<?php // if(!$visitor_analytics_site_id_isset): ?>
	<div class="wrapper">
		<div class="clearfix">
			<div class="alert-days">
				<div class="one"></div>
				<div class="one"></div>
				<div class="one"></div>
				<!-- <img src="<?php echo plugins_url( '../static/images/animation.gif', __FILE__ ); ?>"> -->
			</div>
		</div>
		<div class="row">
        	<div class="tracking access">
				<h2 class="topbar"><?php echo parseI18n($i18n->wordpress->heading); ?></h2>
			</div>
    	</div>
		<div class="input-box">
			<div class="bullet first">
				<span>1</span>
			</div>
			<p class="text register"><?php echo parseI18n($i18n->wordpress->step1->text1); ?></p>
		</div>
		<div class="input-box button-signUp">
			<a href="<?php echo parseI18n($i18n->registrationFormLink->{$thisVisaLocale}); ?>" target="_blank" class="input-box button SignUp"><?php echo parseI18n($i18n->wordpress->step1->button1); ?></a>
		</div>
		<div class="account aready">
			<div class="text tracking">
				<h3 class="tracking"><b><?php echo parseI18n($i18n->wordpress->step1->text2); ?></b></h3>
				<div class="input-box button-signin">
					<a href="<?php echo parseI18n($i18n->highlightWebsiteIdUrl->{$thisVisaLocale}); ?>" target="_blank" class="input-box button SignUp in"><?php echo parseI18n($i18n->wordpress->step1->button2); ?></a>
				</div>
			</div>
		</div>
		<div class="input-box setting">
			<div class="bullet first">
				<span>2</span>
			</div>
			<p class="text website setting tracking"><?php echo parseI18n($i18n->wordpress->step2->text1); ?> <a href="<?php echo parseI18n($i18n->highlightWebsiteIdUrl->{$thisVisaLocale}); ?>" target="_blank"><b> <?php echo parseI18n($i18n->wordpress->step2->text2); ?></b></a> <?php echo parseI18n($i18n->wordpress->step2->text3); ?></p>
      </div>
		<form method="post" action="options.php">
			<?php 
				settings_fields('visitor_analytics');
				do_settings_sections('visitor_analytics_site_id'); 
			?>
			<div class="websiteid">
      			<div class="text tracking">
					<div class="bullet tracking<?php echo $visitor_analytics_site_id != "" ? " success-error-icon" : ""; ?>">
						<img class="enter-website-icon<?php echo $visitor_analytics_site_id != "" ? " hide-icon" : ""; ?>" src="<?php echo plugins_url( '../static/images/enter-id.png', __FILE__ ); ?>">
			<?php	if($visitor_analytics_site_id_valid){ ?>
						<img class="success-icon" src="<?php echo plugins_url( '../static/images/success.png', __FILE__ ); ?>">
			<?php	}
					else if($visitor_analytics_site_id != "" && !$visitor_analytics_site_id_valid){ ?>
						<img class="error-icon" src="<?php echo plugins_url( '../static/images/error.png', __FILE__ ); ?>">
			<?php	} ?>
						
    				</div>
					<!-- working-->
					<div class="website text">
						<div class="input-box button-saveid<?php echo $visitor_analytics_site_id == "" || $visitor_analytics_site_id_valid ? " hide-button" : "";  ?>">
							<input type="submit" value="<?php echo parseI18n($i18n->wordpress->step3->button1); ?>">
						</div>
						<div class="input-box button-verify<?php echo $visitor_analytics_site_id == "" || !$visitor_analytics_site_id_valid ? " hide-button" : "";  ?>">
							<a href="<?php echo 'https://app.twipla.com/website/'.htmlspecialchars($visitor_analytics_site_id, ENT_QUOTES, 'UTF-8').'/settings/tracking-code'; ?>" target="_blank" class="input-box button SignUp"><img class="verify-icon" src="<?php echo plugins_url( '../static/images/verify-icon.png', __FILE__ ); ?>"> <?php echo parseI18n($i18n->wordpress->step3->button2); ?></a>
						</div>

						<div class="enter-website-id<?php echo $visitor_analytics_site_id == "" || !$visitor_analytics_site_id_valid ? "" : " hide-text";  ?>">
							<b><?php echo parseI18n($i18n->wordpress->step3->text1); ?></b>
							<p class="input-cont">
								<input type="text" name="visitor_analytics_site_id" id="visitor_analytics_site_id" placeholder="<?php echo parseI18n($i18n->wordpress->step3->text2); ?>" value="<?php echo htmlspecialchars($visitor_analytics_site_id, ENT_QUOTES, 'UTF-8'); ?>" >
							</p>
						</div>
						<div class="success-saved<?php echo $visitor_analytics_site_id_valid ? "" : " hide-text";  ?>">
							<p><?php echo parseI18n($i18n->wordpress->step3->success); ?></p>
						</div>
					</div>
				</div>
			</div>
		</form>
<?php	if(!$visitor_analytics_site_id_valid){ ?>
			<p class="invalid-text"><?php echo parseI18n($i18n->wordpress->step3->error); ?></p>
<?php	} ?>
<?php	if($visitor_analytics_site_id_valid){ ?>
		<div class="update-website-id">
			<a>
				<img src="<?php echo plugins_url( '../static/images/update-website-id.png', __FILE__ ); ?>">
				<?php echo parseI18n($i18n->wordpress->step3->update); ?>
			</a>
		</div>
<?php	} ?>
		<div class="input-box button-signUp button-open-dashboard">
			<a target="_blank" href="<?php echo $visitor_analytics_site_id_valid ? 'https://app.twipla.com/website/'.htmlspecialchars($visitor_analytics_site_id, ENT_QUOTES, 'UTF-8').'/dashboard/overview' : "#"; ?>" class="input-box button SignUp Open Dashboard<?php echo $visitor_analytics_site_id_valid ? "" : " disabled"; ?>"><?php echo parseI18n($i18n->wordpress->bottom->button1); ?></a>
		</div>
		<div class="input-box button-support">
			<a href="<?php echo parseI18n($i18n->supportCenterLinks->{$thisVisaLocale}); ?>" class="input box button support">
				<img class="icon" src="<?php echo plugins_url( '../static/images/support.svg', __FILE__ ); ?>"><?php echo parseI18n($i18n->wordpress->bottom->button2); ?>
			</a>
			<a href="<?php echo parseI18n($i18n->supportContactLinks->{$thisVisaLocale}); ?>" class="input box button support">
				<img class="icon" src="<?php echo plugins_url( '../static/images/user.svg', __FILE__ ); ?>"><?php echo parseI18n($i18n->wordpress->bottom->button3); ?>
			</a>
		</div>
		<div class="copyright text">
			<h3><?php echo parseI18n($i18n->footer->copyrightText); ?></h3>
		</div>
	</div>
	<!-- content-footer-language-selector --> 
	<div id="language-selector">
		
		<!-- content-footer-language-selector --> 
		<div id="content-footer-language-selector">
			<div class="content-footer-language-selector-container">
			<?php foreach($visaLocales as $visaLocale): ?>	
				<?php if($visaLocale == $thisVisaLocale): ?>
				<img src="<?php echo plugins_url( '../static/images/flags-round/'.$visaLocale.'.svg', __FILE__ ); ?>" />
				<?php endif; ?>
			<?php endforeach; ?>
			</div>
		</div>
		
		<!-- content-footer-language-selection -->
		<div id="content-footer-language-selection" style="display:none;">
			<div class="header">
				<?php echo parseI18n($i18n->languages->title); ?>
			</div>
			<div class="languages">
				<ul class="language-selector">
				<?php foreach($visaLocales as $visaLocale): ?>
					<li>
						<div class="languages-selector-rounded-div">
							<a href="<?php echo getAddress($visaLocale); ?>">
								<span class="language-icon">
									<img src="<?php echo plugins_url( '../static/images/flags-round/'.$visaLocale.'.svg', __FILE__ ); ?>" />
								</span>
								<span class="language-name">
									<?php echo parseI18n($i18n->languages->{$visaLocale}); ?>
									<?php // echo $visaLocale; ?>
								</span>
								<span class="language-radio">
									<?php if($visaLocale == $thisVisaLocale): ?>
									<img src="<?php echo plugins_url( '../static/images/radio-on.svg', __FILE__ ); ?>" />
									<?php else: ?>
									<img src="<?php echo plugins_url( '../static/images/radio-off.svg', __FILE__ ); ?>" />
									<?php endif; ?>
								</span>
							</a>
						</div>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</div>

		
	</div>
	<div class="fc"></div>
			
	<!-- content-footer-copyright --> 
	<div id="content-footer-copyright">
		<?php if(isset($_GET['debug']) && $_GET['debug'] == 1): ?>
			<br/>
			<a class="account-installation-complete">
				<?php echo parseI18n('showInsta'); ?></a> | <a class="account-new-show">
			<?php echo parseI18n('leaveInsta'); ?></a>
		<?php endif; ?>
	</div>
	
</div>

<?php 

/**
*/
function parseI18n($label) {
	// 
	// global $visaLocale;
	// echo '$visaLocale='.$visaLocale.'<br/>';
	
	//
	$search = array(
		'{currentYear}',
		'{visitorAnalytics}', 
	);
	$replace = array(
		date('Y'),
		'Visitor Analytics', 
	);
	// 
	// return str_replace($search, $replace, $label).' ('.$visaLocale.')';
	return str_replace($search, $replace, $label);
}

/**
*/
function getAddress($visaLocale = '') {
    $protocol = @$_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
	// 
	if($visaLocale == '') {
		return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	} else {
		return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&visaLocale='.$visaLocale;
	}
}

/**
*/
function getCurl($url) {
	// initialize cURL
	$ch = curl_init();

	// set the URL to access
	// $url = "https://google.com";
	curl_setopt($ch, CURLOPT_URL, $url);

	// set cURL to return as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	// execute cURL and store the result
	$output = curl_exec($ch);

	// close cURL after use
	curl_close($ch);
	
	// return $output
	return $output;
}

function isValidUuid( $uuid ) {
	if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
		return false;
	}

	return true;
}

?>
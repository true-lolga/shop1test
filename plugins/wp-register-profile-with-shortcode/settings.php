<?php
class register_settings {
	
	function __construct() {
		$this->load_settings();
	}
	
	function register_widget_afo_save_settings(){
		if(isset($_POST['option']) and sanitize_text_field($_POST['option']) == "register_widget_afo_save_settings"){
			if ( ! isset( $_POST['register_widget_afo_save_action_field'] ) || ! wp_verify_nonce( $_POST['register_widget_afo_save_action_field'], 'register_widget_afo_save_action' ) ) {
			   wp_die( 'Sorry, your nonce did not verify.');
			} 
			
			update_option( 'thank_you_page_after_registration_url', sanitize_text_field($_POST['thank_you_page_after_registration_url']) );
			
			update_option( 'password_in_registration', sanitize_text_field($_POST['password_in_registration']) );
			
			update_option( 'firstname_in_registration', sanitize_text_field($_POST['firstname_in_registration']) );
			update_option( 'firstname_in_profile', sanitize_text_field($_POST['firstname_in_profile']) );
			update_option( 'is_firstname_required', sanitize_text_field($_POST['is_firstname_required']) );
			
			update_option( 'lastname_in_registration', sanitize_text_field($_POST['lastname_in_registration']) );
			update_option( 'lastname_in_profile', sanitize_text_field($_POST['lastname_in_profile']) );
			update_option( 'is_lastname_required', sanitize_text_field($_POST['is_lastname_required']) );
			
			update_option( 'displayname_in_registration', sanitize_text_field($_POST['displayname_in_registration']) );
			update_option( 'displayname_in_profile', sanitize_text_field($_POST['displayname_in_profile']) );
			update_option( 'is_displayname_required', sanitize_text_field($_POST['is_displayname_required']) );
			
			update_option( 'userdescription_in_registration', sanitize_text_field($_POST['userdescription_in_registration']) );
			update_option( 'userdescription_in_profile', sanitize_text_field($_POST['userdescription_in_profile']) );
			update_option( 'is_userdescription_required', sanitize_text_field($_POST['is_userdescription_required']) );
			
			update_option( 'userurl_in_registration', sanitize_text_field($_POST['userurl_in_registration']) );
			update_option( 'userurl_in_profile', sanitize_text_field($_POST['userurl_in_profile']) );
			update_option( 'is_userurl_required', sanitize_text_field($_POST['is_userurl_required']) );
			
			update_option( 'captcha_in_registration', sanitize_text_field($_POST['captcha_in_registration']) );
			update_option( 'force_login_after_registration', sanitize_text_field($_POST['force_login_after_registration']) );
			
			update_option( 'default_registration_form_hooks', sanitize_text_field($_POST['default_registration_form_hooks']) );
			
			$_SESSION['msg'] = 'Plugin data updated successfully.';
			$_SESSION['msg_class'] = 'success_msg_rp';
		}
		
		
	}
	
	
	private function error_message(){
		if(isset($_SESSION['msg']) and $_SESSION['msg']){
			echo '<div class="'.$_SESSION['msg_class'].'">'.$_SESSION['msg'].'</div>';
			unset($_SESSION['msg']);
			unset($_SESSION['msg_class']);
		}
	}
	
	
	function  register_widget_afo_options () {
	global $wpdb;
	
	$thank_you_page_after_registration_url = get_option('thank_you_page_after_registration_url');
	
	$password_in_registration = get_option( 'password_in_registration' );
	
	$firstname_in_registration = get_option( 'firstname_in_registration' );
	$firstname_in_profile = get_option( 'firstname_in_profile' );
	$is_firstname_required = get_option( 'is_firstname_required' );
	
	$lastname_in_registration = get_option( 'lastname_in_registration' );
	$lastname_in_profile = get_option( 'lastname_in_profile' );
	$is_lastname_required = get_option( 'is_lastname_required' );
	
	$displayname_in_registration = get_option( 'displayname_in_registration' );
	$displayname_in_profile = get_option( 'displayname_in_profile' );
	$is_displayname_required = get_option( 'is_displayname_required' );
	
	$userdescription_in_registration = get_option( 'userdescription_in_registration' );
	$userdescription_in_profile = get_option( 'userdescription_in_profile' );
	$is_userdescription_required = get_option( 'is_userdescription_required' );
	
	$userurl_in_registration = get_option( 'userurl_in_registration' );
	$userurl_in_profile = get_option( 'userurl_in_profile' );
	$is_userurl_required = get_option( 'is_userurl_required' );
	
	$captcha_in_registration = get_option( 'captcha_in_registration' );
	$force_login_after_registration = get_option( 'force_login_after_registration' );
	
	$default_registration_form_hooks = get_option( 'default_registration_form_hooks' );
	
	$this->wp_register_pro_add();
	$this->wp_user_subscription_add();
	$this->error_message();
	$this->help_support();
	$this->login_sidebar_widget_add();
	?>
	<form name="f" method="post" action="">
	<input type="hidden" name="option" value="register_widget_afo_save_settings" />
    <?php wp_nonce_field( 'register_widget_afo_save_action', 'register_widget_afo_save_action_field' ); ?>
	<table style="width:98%; margin:2px 0px;" border="0">
	  <tr>
		<td colspan="2"><h1>WP Register Profile Settings</h1></td>
	  </tr>
	  <tr>
		<td><strong>Thank You Page</strong></td>
		<td><?php
				$args = array(
				'depth'            => 0,
				'selected'         => $thank_you_page_after_registration_url,
				'echo'             => 1,
				'show_option_none' => '--',
				'id' 			   => 'thank_you_page_after_registration_url',
				'name'             => 'thank_you_page_after_registration_url'
				);
				wp_dropdown_pages( $args ); 
			?><br />
			<i>If selected user will be redirected to this page after successfull registration</i>
			</td>
	  </tr>
	   <tr>
		<td colspan="2"><h2>Form Fields</h2></td>
	  </tr>
	   <tr>
		<td colspan="2">
		
			<table width="100%" border="0" style="border:1px dotted #999999;" class="field_form_table">
			  <tr style="background-color:#FFFFFF;">
				<td width="10%"><h3>Field</h3></td>
				<td width="10%"><h3>Required</h3></td>
				<td width="40%"><h3>Show In Registration</h3></td>
				<td width="40%"><h3>Show In Profile</h3></td>
			  </tr>
			  <tr>
				<td><strong>User Name</strong></td>
				<td align="center"><input type="checkbox" checked="checked" disabled="disabled" /></td>
				<td><span>This field is required and cannot be removed.</span></td>
				<td><span>This field cannot be updated.</span></td>
			  </tr>
			 <tr style="background-color:#FFFFFF;">
				<td><strong>User Email</strong></td>
				<td align="center"><input type="checkbox" checked="checked" disabled="disabled" /></td>
				<td><span>This field is required and cannot be removed.</span></td>
				<td><span>This field cannot be updated.</span></td>
			  </tr>
			  <tr>
				<td><strong>Password Field </strong></td>
				<td align="center"><input type="checkbox" checked="checked" disabled="disabled" /></td>
				<td><input type="checkbox" name="password_in_registration" value="Yes" <?php echo $password_in_registration == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable password field in registration form. Otherwise the password will be auto generated and Emailed to user.</span></td>
				<td><span>Password can be updated from update password page. Use this shortcode <strong>[rp_update_password]</strong></span></td>
			  </tr>
			 <tr style="background-color:#FFFFFF;">
				<td><strong>First Name </strong></td>
				<td align="center"><input type="checkbox" name="is_firstname_required" value="Yes" <?php echo $is_firstname_required == 'Yes'?'checked="checked"':'';?>/></td>
				<td><input type="checkbox" name="firstname_in_registration" value="Yes" <?php echo $firstname_in_registration == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable first name in registration form.</span></td>
			  <td><input type="checkbox" name="firstname_in_profile" value="Yes" <?php echo $firstname_in_profile == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable first name in profile form.</span></td>
			  </tr>
			   <tr>
				<td><strong>Last Name </strong></td>
				<td align="center"><input type="checkbox" name="is_lastname_required" value="Yes" <?php echo $is_lastname_required == 'Yes'?'checked="checked"':'';?>/></td>
				<td><input type="checkbox" name="lastname_in_registration" value="Yes" <?php echo $lastname_in_registration == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable last name in registration form.</span></td>
				<td><input type="checkbox" name="lastname_in_profile" value="Yes" <?php echo $lastname_in_profile == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable last name in profile form.</span></td>
			  </tr>
			  <tr style="background-color:#FFFFFF;">
				<td><strong>Display Name </strong></td>
				<td align="center"><input type="checkbox" name="is_displayname_required" value="Yes" <?php echo $is_displayname_required == 'Yes'?'checked="checked"':'';?>/></td>
				<td><input type="checkbox" name="displayname_in_registration" value="Yes" <?php echo $displayname_in_registration == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable display name in registration form.</span></td>
			  	<td><input type="checkbox" name="displayname_in_profile" value="Yes" <?php echo $displayname_in_profile == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable display name in profile form.</span></td>
			  </tr>
			  <tr>
				<td><strong>About User </strong></td>
				<td align="center"><input type="checkbox" name="is_userdescription_required" value="Yes" <?php echo $is_userdescription_required == 'Yes'?'checked="checked"':'';?>/></td>
				<td><input type="checkbox" name="userdescription_in_profile" value="Yes" <?php echo $userdescription_in_profile == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable about user in profile form.</span></td>
			  </tr>
			 <tr style="background-color:#FFFFFF;">
				<td><strong>User Url </strong></td>
				<td align="center"><input type="checkbox" name="is_userurl_required" value="Yes" <?php echo $is_userurl_required == 'Yes'?'checked="checked"':'';?>/></td>
				<td><input type="checkbox" name="userurl_in_registration" value="Yes" <?php echo $userurl_in_registration == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable user url in registration form.</span></td>
				<td><input type="checkbox" name="userurl_in_profile" value="Yes" <?php echo $userurl_in_profile == 'Yes'?'checked="checked"':'';?>/><span>Check this to enable user url in profile form.</span></td>
			  </tr>
			</table>

		</td>
	  </tr>
      <tr>
		<td colspan="2">
       	 <table width="100%" border="0" style="background-color:#FFFFFF; padding:10px; border:1px dotted #999999;">
         	  <tr>
				<td>Make User Logged-In after successful registration <input type="checkbox" name="force_login_after_registration" value="Yes" <?php echo $force_login_after_registration == 'Yes'?'checked="checked"':'';?>/></td>
			  </tr>
			</table>
		</td>
	  </tr>
      <tr>
		<td colspan="2">
       	 <table width="100%" border="0" style="background-color:#FFFFFF; padding:10px; border:1px dotted #999999;">
         	  <tr>
				<td>Use CAPTCHA in Registration Form <input type="checkbox" name="captcha_in_registration" value="Yes" <?php echo $captcha_in_registration == 'Yes'?'checked="checked"':'';?>/></td>
			  </tr>
			</table>
		</td>
	  </tr>
      <tr>
		<td colspan="2">
		<table width="100%" border="0" style="background-color:#FFFFFF; padding:10px; border:1px dotted #999999;">
		   <tr>
				<td><strong>Enable default WordPress registration form hooks</strong>
				<input type="checkbox" name="default_registration_form_hooks" value="Yes" <?php echo $default_registration_form_hooks == 'Yes'?'checked="checked"':'';?> /><p>Check to <strong>Enable</strong> default WordPress registration form hooks. This will make the registration form compatible with other plugins. For example <strong>Enable</strong> this if you want to use CAPTCHA on registration, from another plugin. <strong>Disable</strong> this so that no other plugins can interfere with your registration process.</p></td>
			  </tr>
		</table>
		</td>
	  </tr>
      <tr>
		<td colspan="2">
       	 <table width="100%" border="0" style="background-color:#FFFFFF; padding:10px; border:1px dotted #999999;">
			  <tr>
				<td><input type="submit" name="submit" value="Save" class="button button-primary button-large" /></td>
			  </tr>
			</table>
		</td>
	  </tr>
	   <tr>
		<td colspan="2">
			<table width="100%" border="0" style="background-color:#FFFFFF; padding:10px; border:1px dotted #999999;">
			  <tr>
				<td><h2>Shortcodes</h2></td>
			  </tr>
			  <tr>
				<td>1. Use this <span style="color:#000066;">[rp_register_widget]</span> shortcode to display registration form in post or page.<br />
		 Example: <span style="color:#000066;">[rp_register_widget title="User Registration"]</span>
		 <br />
		 <br />
		 2. Use This shortcode to retrieve user data <span style="color:#000066;">[rp_user_data field="first_name" user_id="2"]</span>. user_id can be blank. if blank then the data is retrieve from currently loged in user. Or else you can use this function in your template file.
		 <span style="color:#000066;">&lt;?php rp_user_data_func("first_name","2"); ?&gt;</span>
		 <br />
		 <br />
		  3. Use this shortcode for user profile page <span style="color:#000066;">[rp_profile_edit]</span>. Logged in usres can edit profile data from this page.
		 <br />
		 <br />
		 4. Use this shortcode to display Update Password form <span style="color:#000066;">[rp_update_password]</span>.
		 <br />
		 </td>
			  </tr>
			</table>
		</td>
	  </tr>
	 
	</table>
	</form>
	<?php
	$this->donate();
	}
	
	function wp_register_profile_text_domain(){
		load_plugin_textdomain('wp-register-profile-with-shortcode', FALSE, basename( dirname( __FILE__ ) ) .'/languages');
	}
	
	function register_widget_afo_menu () {
		add_options_page( 'Register Widget', 'WP Register Settings', 'activate_plugins', 'register_widget_afo', array( $this,'register_widget_afo_options' ));
	}
	
	function load_settings(){
		add_action( 'admin_menu' , array( $this, 'register_widget_afo_menu' ) );
		add_action( 'admin_init', array( $this, 'register_widget_afo_save_settings' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
		add_action( 'plugins_loaded',  array( $this, 'wp_register_profile_text_domain' ) );
	}
	
	public function register_plugin_styles() {
		wp_enqueue_style( 'style_register_widget', plugins_url( 'wp-register-profile-with-shortcode/style_register_widget.css' ) );
	}
	
	function help_support(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px 0px;">
	  <tr>
		<td align="right"><a href="http://www.aviplugins.com/support.php" target="_blank">Help and Support</a> <a href="http://www.aviplugins.com/rss/news.xml" target="_blank"><img src="<?php echo  plugin_dir_url( __FILE__ ) . '/images/rss.png';?>" style="vertical-align: middle;" alt="RSS"></a></td>
	  </tr>
	</table>
	<?php
	}

	function login_sidebar_widget_add(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; margin:2px 0px;">
  <tr>
    <td><p><strong>WP Register Profile</strong> recommends you to download and activate <a href="https://wordpress.org/plugins/login-sidebar-widget/" target="_blank">Login Widget With Shortcode</a> from <a href="https://wordpress.org/" target="_blank">wordpress.org</a>, so that users can login after successful registration. The plugin will enable user login widget for your site.</p></td>
  </tr>
</table>
	<?php }
	
	function wp_register_pro_add(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px 0px;">
  <tr>
    <td><p>There is a PRO version of this plugin that supports custom user profile fields and other additional options. You can get it <a href="http://aviplugins.com/wp-register-profile-pro/" target="_blank">here</a> in <strong>USD 2.00</strong> </p></td>
  </tr>
</table>
	<?php }
	
	function wp_user_subscription_add(){ ?>
	<table width="98%" border="0" style="background-color:#FFFFD2; border:1px solid #E6DB55; padding:0px 0px 0px 10px; margin:2px 0px;">
  <tr>
    <td><strong>WP User Subscription</strong> 
	<p>Get paid when user registers in your site. Create subscription packages. Restrict page/ post contents from general members of the site. Configure payment options. PayPal Standard, PayPal Advanced (Credit/ Debit Card) payment methods are available by default. You can get it <a href="http://aviplugins.com/wp-user-subscription/" target="_blank">here</a> in <strong>USD 2.50</strong></p></td>
  </tr>
</table>
	<?php }
	
	function donate(){	?>
	<table width="98%" border="0" style="background-color:#FFF; border:1px solid #ccc; margin:2px 0px; padding-right:10px;">
	 <tr>
	 <td align="right"><a href="http://www.aviplugins.com/donate/" target="_blank">Donate</a> <img src="<?php echo  plugin_dir_url( __FILE__ ) . '/images/paypal.png';?>" style="vertical-align: middle;" alt="PayPal"></td>
	  </tr>
	</table>
	<?php
	}
}

new register_settings;
<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php wc_print_notices(); ?>

<?php do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

<div class="u-columns col2-set" id="customer_login">

	<div class="u-column1 col-1">

<?php endif; ?>

		<h2><?php _e( 'Login', 'woocommerce' ); ?></h2>

		<form method="post" class="login">

			<?php do_action( 'woocommerce_login_form_start' ); ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="username"><?php _e( 'Username or email address', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
			</p>
			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" />
			</p>

			<?php do_action( 'woocommerce_login_form' ); ?>

			<p class="form-row">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="login" value="<?php esc_attr_e( 'Login', 'woocommerce' ); ?>" />
				<label for="rememberme" class="inline">
					<input class="woocommerce-Input woocommerce-Input--checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
				</label>
			</p>
			<p class="woocommerce-LostPassword lost_password">
				<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
			</p>

			<?php do_action( 'woocommerce_login_form_end' ); ?>

		</form>

<?php if ( get_option( 'woocommerce_enable_myaccount_registration' ) === 'yes' ) : ?>

	</div>

	<div class="u-column2 col-2">

		<h2><?php _e( 'Register', 'woocommerce' ); ?></h2>

		<form method="post" class="register">

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<label for="reg_username"><?php _e( 'Username', 'theshopier' ); ?> <span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" value="<?php if ( ! empty( $_POST['username'] ) ) echo esc_attr( $_POST['username'] ); ?>" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="reg_email"><?php _e( 'Email address', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" value="<?php if ( ! empty( $_POST['email'] ) ) echo esc_attr( $_POST['email'] ); ?>" />
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
					<label for="reg_password"><?php _e( 'Password', 'theshopier' ); ?> <span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" />
				</p>

			<?php endif; ?>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-first">
				<label for="reg_billing_first_name"><?php _e( 'First Name', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) echo esc_attr( $_POST['billing_first_name'] ); ?>" />
			</p>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-last">
				<label for="reg_billing_last_name"><?php _e( 'Last Name', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) echo esc_attr( $_POST['billing_last_name'] ); ?>" />
			</p>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-first">
				<label for="reg_billing_phone"><?php _e( 'Phone', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="tel" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) echo esc_attr( $_POST['billing_phone'] ); ?>" />
			</p>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-last">
				<label for="reg_birthday"><?php _e( 'Birthday', 'theshopier' ); ?></label>
				<input type="text" class="woocommerce-Input nth-datepicker input-text " name="birthday" id="reg_birthday" value="<?php if ( ! empty( $_POST['birthday'] ) ) echo esc_attr( $_POST['birthday'] ); ?>" />
			</p>

			<div class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="reg_billing_postcode"><?php _e( 'Postcode', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text" name="billing_postcode" id="reg_billing_postcode" value="<?php if ( ! empty( $_POST['billing_postcode'] ) ) echo esc_attr( $_POST['billing_postcode'] ); ?>" />
				<input type="button" onclick="sample3_execDaumPostcode()" value="<?php esc_attr_e('Address Search', 'theshopier')?>">

				<div id="reg_postcode_search_wrap" style="display:none;border:1px solid;margin:5px 0;position:relative; min-height: 250px; max-height: 300px">
					<img src="//i1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-20px;z-index:1" onclick="foldDaumPostcode()" alt="?? ??">
				</div>
			</div>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row form-row-wide">
				<label for="reg_billing_address_1"><?php _e( 'Address', 'theshopier' ); ?> <span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_1" id="reg_billing_address_1" placeholder="<?php esc_attr_e('Street address', 'theshopier')?>" value="<?php if ( ! empty( $_POST['billing_address_1'] ) ) echo esc_attr( $_POST['billing_address_1'] ); ?>" />
			</p>

			<p class="woocommerce-FormRow woocommerce-FormRow--wide form-row">
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_address_2" id="reg_billing_address_2" placeholder="<?php esc_attr_e('Apartment, suite, unit etc. (optional)', 'theshopier')?>" value="<?php if ( ! empty( $_POST['billing_address_2'] ) ) echo esc_attr( $_POST['billing_address_2'] ); ?>" />
				<input type="hidden" class="woocommerce-Input woocommerce-Input--text input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) echo esc_attr( $_POST['billing_city'] ); ?>" />
			</p>

			<script src='https://www.google.com/recaptcha/api.js'></script>

			<div class="g-recaptcha" data-sitekey="6LfwRiUTAAAAAC9Im74VW3Hzo5jqzcg0v82kZEZ_" style="margin-bottom: 15px"></div>

			<!-- Spam Trap -->
			<div style="<?php echo ( ( is_rtl() ) ? 'right' : 'left' ); ?>: -999em; position: absolute;"><label for="trap"><?php _e( 'Anti-spam', 'theshopier' ); ?></label><input type="text" name="email_2" id="trap" tabindex="-1" /></div>

			<?php do_action( 'woocommerce_register_form' ); ?>
			<?php do_action( 'register_form' ); ?>

			<p class="woocomerce-FormRow form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<input type="submit" class="woocommerce-Button button" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>" />
			</p>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>

	</div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>



<script src="https://cantinhodacegonha.com.br/js/postcodev2.js"></script>
<script>
	var element_wrap = document.getElementById('reg_postcode_search_wrap');

	function foldDaumPostcode() {
		element_wrap.style.display = 'none';
	}

	function sample3_execDaumPostcode() {

		var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
		new daum.Postcode({
			oncomplete: function(data) {

				var fullAddr = data.address;
				var extraAddr = '';

				if(data.addressType === 'R'){

					if(data.bname !== ''){
						extraAddr += data.bname;
					}

					if(data.buildingName !== ''){
						extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
					}

					if(extraAddr.length > 0) extraAddr = '('+extraAddr+')';
				}

				document.getElementById('reg_billing_postcode').value = data.zonecode;
				document.getElementById('reg_billing_address_1').value = fullAddr;
				document.getElementById('reg_billing_address_2').value = extraAddr;
				document.getElementById('reg_billing_city').value = data.sido;

				element_wrap.style.display = 'none';

				document.body.scrollTop = currentScroll;
				console.log(data);
			},

			onresize : function(size) {
				element_wrap.style.height = size.height+'px';
			},
			width : '100%',
			height : '100%'
		}).embed(element_wrap);

		element_wrap.style.display = 'block';
	}
</script>

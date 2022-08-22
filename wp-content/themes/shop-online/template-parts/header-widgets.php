<?php
if ( is_active_sidebar( 'header-widgets' ) ) {
?>
<div class="header-widgets">
<div class="container"> 
<div class="row">

	<br />
<?php	
 dynamic_sidebar( 'header-widgets' );
?>
	</div>
</div>
</div>
<?php
}
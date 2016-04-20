<script>
	jQuery(document).ready( function($) {
		//$( "#draggable" ).draggable();
	});
</script>
<div class="wrap">
	<header class="navbar">
		<nav class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sltgNavbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo admin_url( 'admin.php?page=sltg-main-page'); ?>">Salatiga</a>
			</div>
			<div class="collapse navbar-collapse" id="sltgNavbar">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">UKM <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="<?php echo admin_url( 'admin.php?page=sltg-personal' ); ?>">Founder/Creator</a></li>
							<li><a href="<?php echo admin_url( 'admin.php?page=sltg-ukm' ); ?>">UKM</a></li>
							<li><a href="<?php echo admin_url( 'admin.php?page=sltg-product' ); ?>">Product</a></li>
							<li class="divider"></li>
							<li><a href="<?php echo admin_url( 'admin.php?page=sltg-katprodukukm' ); ?>">Kategori</a></li>
						</ul>
					</li>
					<li><a href="#">Other</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right"></ul>
			</div>
		</nav>
	</header>
	<div class="plugin-content">
		<?php echo $attributes; ?>
	</div>
</div>
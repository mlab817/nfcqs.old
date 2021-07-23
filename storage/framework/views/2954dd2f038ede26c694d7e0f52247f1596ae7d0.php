<div id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('img/da-logo.png')); ?>" />
        <h1>NFCQS</h1>
	</div>
    <ul class="sidebar-nav">
		<?php if(auth()->guard()->check()): ?>
			<?php if(auth()->user()->isAdmin()): ?>
				<li>
					<a href="<?php echo e(route('users.index')); ?>">
						<span class="menu-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
						<span class="menu-text">System Users</span>
					</a>
				</li>
			<?php endif; ?>
			<li>
				<a href="<?php echo e(url('commodities')); ?>">
					<span class="menu-icon"><i class="fa fa-list" aria-hidden="true"></i></span>
					<span class="menu-text">Commodities</span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('commodities/add')); ?>" class="open-popup">
					<span class="menu-icon"><i class="fa fa-leaf" aria-hidden="true"></i></span>
					<span class="menu-text">Forecast Input</span>
				</a>
			</li>
				<li>
					<a href="<?php echo e(url('commodities/add')); ?>">
						<span class="menu-icon"><i class="fa fa-leaf" aria-hidden="true"></i></span>
						<span class="menu-text">Upload Data</span>
					</a>
				</li>
			<li>
				<a href="<?php echo e(url('map-control')); ?>" class="open-popup">
					<span class="menu-icon"><i class="fa fa-map" aria-hidden="true"></i></span>
					<span class="menu-text">Map Dashboard</span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('reports/list')); ?>">
					<span class="menu-icon"><i class="fa fa-file" aria-hidden="true"></i></span>
					<span class="menu-text">Project Reports</span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('reports/upload')); ?>" title="Upload Project Reports" class="open-popup">
					<span class="menu-icon"><i class="fas fa-file-upload"></i></span>
					<span class="menu-text">Upload Report</span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('change-password')); ?>" class="open-popup">
					<span class="menu-icon"><i class="fas fa-key"></i></span>
					<span class="menu-text">New Password</span>
				</a>
			</li>
			<li>
				<a href="<?php echo e(url('logout')); ?>">
					<span class="menu-icon"><i class="fas fa-sign-out-alt"></i></span>
					<span class="menu-text">Sign Out</span>
				</a>
			</li>
		<?php endif; ?>
	</ul>
</div>
<?php /**PATH /home/vagrant/nfcqs/resources/views/partials/sidebar.blade.php ENDPATH**/ ?>
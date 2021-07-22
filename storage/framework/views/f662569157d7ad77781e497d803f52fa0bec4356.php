<div id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('img/da-logo.png')); ?>" />
        <h1>NFCQS</h1>
	</div>
    <ul class="sidebar-nav">
    	
		<?php if(@Auth::user()->user_type == 0): ?>
			<li>
				<a href="<?php echo e(url('users')); ?>">
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
	</ul>
</div>

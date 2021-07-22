<div id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('img/denr-logo.png')); ?>" />
        <h1>i P M I S</h1>
	</div>
    <ul class="sidebar-nav">
    	<li>
			<a href="<?php echo e(url('dashboard')); ?>">
				<span class="menu-icon"><i class="fas fa-chart-pie"></i></span>
    	        <span class="menu-text">Dashboard</span>
    	    </a>
		</li>
		<li>
			<a href="<?php echo e(url('po-list')); ?>">
				<span class="menu-icon"><i class="fa fa-list-ul" aria-hidden="true"></i></span>
				<span class="menu-text">PO List</span>
			</a>
		</li>
		<li>
			<a href="<?php echo e(url('profile-po')); ?>">
				<span class="menu-icon"><i class="fa fa-registered" aria-hidden="true"></i></span>
				<span class="menu-text">Register PO</span>
			</a>
		</li>
		<li>
			<a href="<?php echo e(url('project-list')); ?>">
				<span class="menu-icon"><i class="fa fa-list-ul" aria-hidden="true"></i></span>
				<span class="menu-text">Project List</span>
			</a>
		</li>
		<li>
			<a href="<?php echo e(url('profile-project')); ?>">
				<span class="menu-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>
				<span class="menu-text">New Project</span>
			</a>
		</li>
		<li>
			<a href="<?php echo e(url('procured-goods/list')); ?>">
				<span class="menu-icon"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
				<span class="menu-text">Procured Goods</span>
			</a>
		</li>
    	<li>
			<a href="<?php echo e(url('contracts')); ?>">
				<span class="menu-icon"><i class="fas fa-address-book"></i></span>
				<span class="menu-text">Contracts</span>
			</a>
		</li>
		<li>
			<a href="<?php echo e(url('contract')); ?>">
				<span class="menu-icon"><i class="fas fa-file-alt"></i></span>
				<span class="menu-text">Add Contract</span>
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

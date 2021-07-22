<div id="sidebar-wrapper">
    <div class="sidebar-brand">
        <img src="<?php echo e(asset('img/denr-logo.png')); ?>" />
        <h1>INREMP</h1>
    </div>
    <ul class="sidebar-nav">
    	<li>
    	    <a href="<?php echo e(url('dashboard')); ?>">
    	        <i class="fas fa-chart-pie"></i>
    	        <span>Dashboard</span>
    	    </a>
    	</li>
    	<?php if(@Auth::user()->user_type == 0 OR @Auth::user()->user_type == 2): ?>
	        <li>
	            <a href="<?php echo e(url('contracts')); ?>">
	                <i class="far fa-address-book"></i>
	                <span>Contracts</span>
	            </a>
	        </li>
	        <li>
	            <a href="<?php echo e(url('contract')); ?>">
	                <i class="far fa-file-alt"></i>
	                <span>Add Contract</span>
	            </a>
	        </li>
	    <?php else: ?>
	    	<li>
	    	    <a href="<?php echo e(url('projects')); ?>">
	    	        <i class="fas fa-cart-arrow-down"></i>
	    	        <span>Proc. Status</span>
	    	    </a>
	    	</li>
	    	<li>
	    	    <a href="<?php echo e(url('project')); ?>">
	    	        <i class="far fa-file-alt"></i>
	    	        <span>New Proc.</span>
	    	    </a>
	    	</li>
	    <?php endif; ?>
        <li>
            <a href="<?php echo e(url('change-password')); ?>" class="open-popup">
                <i class="fas fa-key"></i>
                <span>New Password</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(url('logout')); ?>">
                <i class="fas fa-sign-out-alt"></i>
                <span>Sign out</span>
            </a>
		</li>
		<li class="more-menu-icon-wrapper">
            <a href="<?php echo e(url('more')); ?>" class="open-more-menu">
                <i class="fas fa-dot-circle"></i>
                <span>More</span>
            </a>
        </li>
    </ul>
</div>

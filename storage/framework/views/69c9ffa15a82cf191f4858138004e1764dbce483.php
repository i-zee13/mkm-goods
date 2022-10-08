<div class="sidebarblue" id="sidebarblue">


    <?php if($controller != "StockManagmentController"): ?>
    <?php if( $controller != "OrderSheetController"): ?>
    <div class="aside-primary">
        <div class="sell360">
            <a href="/"><img alt="Sourcecode Academia" src="/images/Sourcecode-Academia-BE.png"></a>
        </div>
        <div class="main-links">
            <ul id="parentModulesUl">
            </ul>
        </div>
        <div class="_user-nav">
            <a href="/ViewAllNotifications"><img src="/images/bell-icon-2.svg" alt="Notification" title="Notification" /><span style="display: none" class="badge"><?php echo e(sizeof($notif_data)); ?></span></a>
            <a href="/Profile" class="userIMG"><img src="<?php echo e(Auth::user()->picture ? str_replace('./', '/', Auth::user()->picture) : '/images/avatar.svg'); ?>" alt="" /></a>
            <a href="/manage_settings" class="float-right"><img src="/images/setting-icon.svg" alt="Setting" title="Setting" /></a>
        </div>
        <div class="sidebar-BL">
            <ul>



                <li>
                    <a href="/logout"><img src="/images/logout-icon.svg" alt="Employee" /> Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <?php if($controller == "StockManagmentController" && $action == "transferStock"): ?>

    <div class="aside-primary">
        <div class="sell360">
            <a href="/"><img alt=" Sourcecode Academia" src="/images/Sourcecode-Academia-BE.png"> Academia</a>
        </div>
        <div class="main-links">
            <ul id="parentModulesUl">
            </ul>
        </div>
        <div class="_user-nav">
            <a href="/ViewAllNotifications"><img src="/images/bell-icon-2.svg" alt="Notification" title="Notification" /><span style="display: none" class="badge"><?php echo e(sizeof($notif_data)); ?></span></a>
            <a href="/Profile" class="userIMG"><img src="<?php echo e(Auth::user()->picture ? str_replace('./', '/', Auth::user()->picture) : '/images/avatar.svg'); ?>" alt="" /></a>
            <a href="/manage_settings" class="float-right"><img src="/images/setting-icon.svg" alt="Setting" title="Setting" /></a>
        </div>
        <div class="sidebar-BL">
            <ul>
                <li>
                    <a href="/Tasks"><img src="/images/task-icon.svg" alt="" /> Tasks <span class="badge"><?php echo e(sizeof($tasks)); ?></span></a>
                </li>
                <li>
                    <a href="/logout"><img src="/images/logout-icon.svg" alt="Employee" /> Logout</a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>


</div>
<div id="_subNav-id">
    <div class="_subNav"> <a id="SN-close" class="SN-close-btn"><i class="fa fa-arrow-left snCloseBtn"></i></a>
        <h2 id="subNavHeader"></h2>
        <ul id="subNavItems">
        </ul>
    </div>
</div><?php /**PATH C:\xampp\htdocs\Lms\Sourcecode-Academia-BE\resources\views/includes/nav-new.blade.php ENDPATH**/ ?>
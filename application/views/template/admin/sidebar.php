<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        
        <div class="sidebar-brand">
            <a class="font-weight-bold float-left ml-4 mt-2" href="<?= base_url(); ?>">
                <img src="https://majoo.id/assets/img/main-logo.png" alt="majoo" width="120">
            </a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?= base_url(); ?>">
                <img src="https://majoo.id/favicon.png" class="mt-3 img-fluid px-1" width="35">
            </a>
        </div>
        <ul class="sidebar-menu">
            <?php foreach ($auth->menus as $menu): ?>
                <?php if ($menu->parent): ?>
                    <li class="dropdown <?= in_array($this->uri->segment(1), $menu->url) ? 'active' : '' ?>">
                        <a class="nav-link has-dropdown" data-toggle="dropdown" href="#">
                            <i class="<?=$menu->icon?>"></i> <span><?=$menu->parent?></span>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($menu->children as $children): ?>
                                <li class="<?= $this->uri->segment(1) == $children->url ? 'active' : ''; ?>">
                                    <a class="nav-link" href="<?= base_url($children->url); ?>">
                                        <i class="<?=$children->icon?>"></i> <?= $children->alias; ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <?php foreach ($menu->children as $children): ?>
                        <li class="<?= $this->uri->segment(1) == $children->url ? 'active' : ''; ?>">
                            <a class="nav-link" href="<?= base_url($children->url); ?>">
                                <i class="<?=$children->icon?>"></i> <span><?=$children->alias;?></span>
                            </a>
                        </li>
                    <?php endforeach ?>
                <?php endif ?>
            <?php endforeach ?>
        </ul>

    </aside>
</div>

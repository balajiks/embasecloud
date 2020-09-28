<aside class="bg-<?php echo e(get_option('sidebar_theme')); ?> aside-md b-r <?php echo e(settingEnabled('hide_sidebar') ? 'nav-xs' : ''); ?> hidden-print hidden-xs" id="nav">
    <section class="vbox">
        
        <?php /*?><header class="header bg-dark text-center clearfix">

            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-{{ get_option('theme_color') }}" title="Language">@icon('solid/lightbulb')</button>
                <div class="btn-group hidden-nav-xs">
                  <button type="button" class="btn btn-sm btn-{{ get_option('theme_color') }} dropdown-toggle" data-toggle="dropdown">
                    @langapp('quick_links')
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu text-left">
                    <li>
                        @modactive('projects')
                        @can('projects_create')
                        <a href="{{ route('projects.create') }}">@icon('solid/play', 'text-muted') @langapp('start_project')</a>
                        @endcan
                        @endmod
                        @modactive('tickets')
                        @can('tickets_create')
                        <a href="{{ route('tickets.create') }}">@icon('solid/life-ring', 'text-muted') @langapp('new_ticket')</a>
                        @endcan
                        @endmod
                    </li>
                    
                  </ul>
                </div>
              </div>

           
        </header><?php */?>
        <section class="w-f scrollable">
            <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="5px">
                
                <nav class="nav-primary hidden-xs">
                    <ul class="nav">
					
					<?php
						/*print '<pre>';
						print_r(mainMenu());
						exit; */
						?>
						

                        <?php $__currentLoopData = mainMenu(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
						



                    <?php if(count($menu['children']) > 0): ?>

                        <li class="nav-w-children <?php echo e($page == langapp($menu['name']) && (in_array($menu['module'], array_pluck($menu['children'], 'parent'))) ? 'active'  : ''); ?>" id="<?php echo e($menu['module']); ?>">
                            <a href="<?php echo e(site_url($menu['route'])); ?>">
                                <i class="<?php echo e($menu['icon']); ?> icon">
                                    <b class="bg-<?php echo e(get_option('theme_color')); ?>"></b>
                                </i>
                                <span class="pull-right">
                                    <i class="fas fa-angle-down text"></i>
                                    <i class="fas fa-angle-up text-active"></i>
                                </span>
                                <span>
                                    <?php echo trans('app.'.$menu['name']); ?> 
                                </span>
                            </a>
                            <ul class="nav lt">
                                <?php $__currentLoopData = $menu['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(Auth::user()->can($submenu['module'])): ?>
                                   <li class="<?php echo e($page == langapp($submenu['name']) ? 'active' : ''); ?>">
                                    <a href="<?php echo e(site_url($submenu['route'])); ?>">
                                        <i class="<?php echo e($submenu['icon']); ?> icon">
                                            <b class="bg-<?php echo e(get_option('theme_color')); ?>"></b>
                                        </i>
                                        <span>
                                            <?php echo trans('app.'.$submenu['name']); ?> 
                                        </span>
                                    </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                        <?php else: ?>
                        <li class="<?php echo e($page === langapp($menu['name']) ? 'active' : ''); ?>">
                            <a href="<?php echo e(site_url($menu['route'])); ?>">
                                <i class="<?php echo e($menu['icon']); ?> icon">
                                    <b class="bg-<?php echo e(get_option('theme_color')); ?>"></b>
                                </i>
                                <span>
                                    <?php echo trans('app.'.$menu['name']); ?> 
                                </span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </nav>
                <div class="wrapper clearfix small p-10">
                    <?php $__currentLoopData = quickAccess(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $entity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="text-center-folded">
                        <span class="hidden-folded">
                            <a class="text-ellipsis" href="<?php echo e($entity['url']); ?>">
                                <?php echo e(str_limit($entity['name'], 25)); ?>

                            </a>
                        </span>
                    </div>
                    <div class="progress progress-xxs m-t-xs dk">
                        <div class="progress-bar progress-bar-success" data-placement="top" data-rel="tooltip" style="width: <?php echo e($entity['progress']); ?>%;" title="<?php echo e($entity['progress']); ?>%">
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </section>
        
    </section>
</aside>

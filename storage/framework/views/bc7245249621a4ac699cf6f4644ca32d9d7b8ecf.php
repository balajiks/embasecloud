<aside class="b-l bg" id="">
            <ul class="dashmenu text-uc text-muted no-border no-radius">
                <?php if (moduleActive('projects')) { ?>
                <li class="<?php echo e($dashboard == 'projects' ? 'active' : ''); ?>"><a href="<?php echo e(route('dashboard.index', ['dashboard' => 'projects'])); ?>"><?php echo e(svg_image('solid/clock')); ?> <?php echo trans('app.'.'projects'); ?></a></li>
                <?php } ?>
                <?php if (moduleActive('tickets')) { ?>
                <li class="<?php echo e($dashboard == 'tickets' ? 'active' : ''); ?>"><a href="<?php echo e(route('dashboard.index', ['dashboard' => 'tickets'])); ?>"><?php echo e(svg_image('solid/life-ring')); ?> <?php echo trans('app.'.'ticketing'); ?></a></li>
                <?php } ?>
            </ul>
            
                <section class="scrollable">
                    <div class="slim-scroll" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                        <section class="padder">
                            
                            <?php echo $__env->make('dashboard::_includes.'.$dashboard, \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            
                            
                        </section>
                    </div>
                </section>
                
            </aside>

            <aside class="aside-lg b-l">
                <section class="vbox">
                    
                    <section class="scrollable" id="feeds">

                    <div class="slim-scroll padder" data-color="#333333" data-disable-fade-out="true" data-distance="0" data-height="auto" data-size="3px">
                    
                        <?php echo $__env->make('dashboard::_sidebar.'.$dashboard, \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    
                    </div>

                </section>
                    
                </section>
            </aside>
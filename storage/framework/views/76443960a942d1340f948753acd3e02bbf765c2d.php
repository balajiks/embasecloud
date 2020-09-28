<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header btn-default" style="display:block;">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title"><?php echo trans('app.'.'metaheader'); ?></h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-12"><?php echo trans('app.'.'itemtitle'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->article); ?></code></pre>
      </div>
    </div>
    <div class="row">
	<div class="col-sm-3"><?php echo trans('app.'.'publ'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->publ); ?></code></pre>
      </div>
	  <div class="col-sm-3"><?php echo trans('app.'.'Abstract'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->abs); ?></code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'puititle'); ?> :
        <pre><code class="text-info"><?php echo e(str_replace('_pui ','',$jobmetainfo[0]->pui)); ?></code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'unittitle'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->unitid); ?></code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'ordertitle'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->orderid); ?></code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'parceltitle'); ?> :
        <pre><code class="text-info">None</code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'suppliertitle'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->unitid); ?></code></pre>
      </div>
      <div class="col-sm-3"><?php echo trans('app.'.'cartitle'); ?> :
        <pre><code class="text-info"><?php echo e($jobmetainfo[0]->carid); ?></code></pre>
      </div>
    </div>
  </div>
</div>

<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header btn-default" style="display:block;">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">@langapp('metaheader')</h4>
  </div>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-12">@langapp('itemtitle') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->article }}</code></pre>
      </div>
    </div>
    <div class="row">
	<div class="col-sm-3">@langapp('publ') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->publ }}</code></pre>
      </div>
	  <div class="col-sm-3">@langapp('Abstract') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->abs }}</code></pre>
      </div>
      <div class="col-sm-3">@langapp('puititle') :
        <pre><code class="text-info">{{ str_replace('_pui ','',$jobmetainfo[0]->pui) }}</code></pre>
      </div>
      <div class="col-sm-3">@langapp('unittitle') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->unitid }}</code></pre>
      </div>
      <div class="col-sm-3">@langapp('ordertitle') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->orderid }}</code></pre>
      </div>
      <div class="col-sm-3">@langapp('parceltitle') :
        <pre><code class="text-info">None</code></pre>
      </div>
      <div class="col-sm-3">@langapp('suppliertitle') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->unitid }}</code></pre>
      </div>
      <div class="col-sm-3">@langapp('cartitle') :
        <pre><code class="text-info">{{ $jobmetainfo[0]->carid }}</code></pre>
      </div>
    </div>
  </div>
</div>

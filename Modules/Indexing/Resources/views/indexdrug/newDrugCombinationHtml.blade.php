
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>

<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('drugcombination')</div>
      <div class="panel-body card">
        <div class="col-sm-12">
  <div class="row" id="druglink_drugcombination">
	
	<div class="col-lg-12">
 	<select class="select2-option form-control" id="drugcombination" name="drugcombination[]" multiple="multiple">
	 @foreach($data['drugcombination'] as $drugcombination)
     <option value="{{ $drugcombination->drugterm }}">{{ $drugcombination->drugterm }}</option>
	 @endforeach
     </select>
	</div>							  
  </div>
</div>
        <div class="form-group"><br />
          <div class="col-sm-10">
            <button type="submit" id="savebtn" class="btn btn-info"><i class="fas fa-paper-plane"></i>&nbsp;Add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function () {
    
	$("#drugcombination").select2({
		placeholder: "Select ..",
		allowClear: true,
		
    });
	
	
	$('#drugcombination').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});

</script>

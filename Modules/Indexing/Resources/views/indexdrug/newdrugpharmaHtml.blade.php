
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>

<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('drugpharma')</div>
      <div class="panel-body card">
        <div class="col-sm-121">
  <div class="row" id="druglink_druginteraction">
	<div class="col-lg-12">
	  <label class="control-label" for="fname">@langapp('specialsitutation'):</label>
	  
	  <select class="select2-option form-control" id="specialsitutation" name="specialsitutation[]" multiple="multiple">
	 @foreach($data['specialpharma'] as $specialpharma)
     <option value="{{ $specialpharma->name }}">{{ $specialpharma->name }}</option>
	 @endforeach
     </select>
	  
	</div>
	<div class="col-lg-12">
	<label class="control-label" for="fname">@langapp('unexpectedoutcome'):</label>
 	<select class="select2-option form-control" id="unexpectedoutcome" name="unexpectedoutcome[]" multiple="multiple">
	 @foreach($data['drugtreatment'] as $drugtreatment)
     <option value="{{ $drugtreatment->name }}">{{ $drugtreatment->name }}</option>
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
	$("#specialsitutation").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#specialsitutation').val([ <?php echo $data['tblindex_drugspecialpharma']; ?> ]).trigger('change');
	
	
	$("#unexpectedoutcome").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#unexpectedoutcome').val([ <?php echo $data['tblindex_drugunexpecteddrugtreatment']; ?> ]).trigger('change');
	
	
});

</script>

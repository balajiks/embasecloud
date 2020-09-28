
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('drugcomparison')</div>
      <div class="panel-body card">
        <div class="col-sm-12">
          <div class="row" id="druglink_drugcomparison">
            <div class="col-lg-12">
              <select class="select2-option form-control" id="drugcomparison" name="drugcomparison[]" multiple="multiple">
                
                
	 @foreach($data['drugcomparison'] as $drugcomparison)
     
                
                <option value="{{ $drugcomparison->drugterm }}">{{ $drugcomparison->drugterm }}</option>
                
                
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
    
	$("#drugcomparison").select2({
		placeholder: "Select ..",
		allowClear: true,
		
    });
	
	
	$('#drugcomparison').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});

</script>

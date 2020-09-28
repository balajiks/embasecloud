
<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('druginteraction')</div>
      <div class="panel-body card">
        <div class="col-sm-121">
  <div class="row" id="druglink_druginteraction">
	<div class="col-lg-12">
	  <label class="control-label" for="fname">@langapp('druginteraction'):</label>
	  <input type="text" class="form-control" id="txtdruginteraction" placeholder="@langapp('indexterm')" name="txtdruginteraction" value="{{ @$data['txtdruginteraction']}}" >
	</div>
	<div class="col-lg-12">
	<label class="control-label" for="fname">Indexed Drug Terms:</label>
 	<select class="select2-option form-control" id="druginteraction" name="druginteraction[]" multiple="multiple">
	 @foreach($data['druginteraction'] as $medical_term)
     <option value="{{ $medical_term->drugterm }}">{{ $medical_term->drugterm }}</option>
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
	$("#druginteraction").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#druginteraction').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});

</script>

<input type="hidden" name="selecteddrugid" id="selecteddrugid" value="{{ $data['selecteddrugid'] }}"/>
<input type="hidden" name="field" value="{{ $data['field'] }}"/>
<div class="col-lg-121">
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">@langapp('adversedrug')</div>
      <div class="panel-body card">
        <div class="col-sm-121">
          <div class="row" id="druglink_adversedrug">
            <div class="col-lg-12">
              <label class="control-label" for="fname">@langapp('indexterm'):</label>
              <input type="text" class="form-control" id="txtadversedrug" placeholder="@langapp('indexterm')" name="txtadversedrug" value="{{ @$data['txtadversedrug']}}">
            </div>
            <div class="col-lg-12">
              <label class="control-label" for="fname">Indexed Medical Terms:</label>
              <select class="select2-option form-control" id="adversedrug" name="adversedrug[]" multiple="multiple">
                
	 @foreach($data['indexed_medical_term'] as $medical_term)
     
                <option value="{{ $medical_term->medicalterm }}">{{ $medical_term->medicalterm }}</option>
                
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
	$("#adversedrug").select2({
		placeholder: "Select ..",
		allowClear: true,
    });
	$('#adversedrug').val([ <?php echo $data['tblindex_drug']; ?> ]).trigger('change');
});

</script>

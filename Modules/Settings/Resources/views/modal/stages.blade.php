<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">{{  langapp('selectjob') }}</h4>
        </div>
        {!! Form::open(['route' => 'settings.stages.selectedjobs', 'class' => 'bs-example form-horizontal', 'id' => 'saveStage']) !!}
        <input type="hidden1" name="module" value="{{ $module }}">
        <input type="hidden1" name="color" value="info">
        <input type="hidden1" name="active" value="1">
        
        <div class="modal-body">
            

            
            
        </div>
        <div class="modal-footer">

            {!! closeModalButton() !!}
            {!! renderAjaxButton('save') !!}

        </div>

    {!! Form::close() !!}
</div>

</div>

@push('pagescript')
<script src="{{ getAsset('plugins/sortable/jquery-sortable.js') }}"></script>
    <script>
    $('#saveStage').on('submit', function(e) {
        $(".formSaving").html('Processing..<i class="fas fa-spin fa-spinner"></i>');

        e.preventDefault();
        var tag, data;
        tag = $(this);
        data = tag.serialize();


        axios.post('{{ route('settings.stages.selectedjobs') }}', data)
          .then(function (response) {
            $('#stageList').append(response.data.html);
                toastr.info( response.data.message , '@langapp('response_status') ');
                $(".formSaving").html('<i class="fas fa-paper-plane"></i> @langapp('send') </span>');
                tag[0].reset();
          })
          .catch(function (error) {
            var errors = error.response.data.errors;
            var errorsHtml= '';
            $.each( errors, function( key, value ) {
                errorsHtml += '<li>' + value[0] + '</li>'; 
            });
            toastr.error( errorsHtml , '@langapp('response_status') ');
            $(".formSaving").html('<i class="fas fa-sync"></i> Try Again</span>');
        });
        

    });


    $('body').on('click', '.deleteStage', function (e) {
        e.preventDefault();
        var tag, id;

        tag = $(this);
        id = tag.data('stage-id');

        if(!confirm('Do you want to delete this message?')) {
            return false;
        }
        axios.post('{{ route('settings.stages.delete') }}', {
            "id":id
        })
          .then(function (response) {
                toastr.warning( response.data.message , '@langapp('response_status') ');
                $('#stage-' + id).hide(500, function () {
                    $(this).remove();
                });
          })
          .catch(function (error) {
            toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
        });

        
    });
        
$(function  () {
  $("ul#stageList").sortable({
    placeholder: '<li class="placeholder list-group-item"/>',
    serialize: function ($parent, $children, parentIsContainer) {
      var result = $.extend({}, {id:$parent.attr('id')});
      if(parentIsContainer)
        return $children;
      else if ($children[0]) 
        result.children = $children;
      return result;

    }, 
    onDrop: function ($item, container, _super) {
        $item.removeClass("dragged").removeAttr("style");
        $("body").removeClass("dragging");

        var dataToSend = $("ul#stageList").sortable("serialize").get();

        axios.post('{{ route('settings.stages.order') }}', {
            "sortedList":dataToSend
        })
          .then(function (response) {
                toastr.info( response.data.message , '@langapp('response_status') ');
          })
          .catch(function (error) {
                toastr.error('Oops! Request failed to complete.', '@langapp('response_status') ');
        });
    }
  });
});      
    </script>
@endpush

@stack('pagescript')
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">@langapp('next_stage')</h4>
        </div>
        @php
        $nextStage = $indexing->nextStage() ? $indexing->nextStage() : App\Entities\Category::indexing()->max('order');
        @endphp
        {!! Form::open(['route' => ['indexing.api.next.stage', $indexing->id], 'class' => 'bs-example form-horizontal ajaxifyForm']) !!}
        <input type="hidden" name="id" value="{{  $indexing->id  }}">
        <input type="hidden" name="url" value="{{ url()->previous() }}">
        <div class="modal-body">
            <input type="hidden" value="{{ App\Entities\Category::indexing()->whereOrder($nextStage)->first()->id }}" name="stage">
            <div class="padder m-b-lg">
                @langapp('indexing_next_stage_message', ['name' => $indexing->name, 'from' => $indexing->status->name, 'to' => App\Entities\Category::indexing()->whereOrder($nextStage)->first()->name])
            </div>
            <div class="modal-footer">
                
                {!! closeModalButton() !!}
                {!! renderAjaxButton()  !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@include('partial.ajaxify')
<div class="col-lg-12">
    <section class="m-xs">
        <section class="comment-list block">


            <article class="comment-item" id="comment-form">
                <a class="pull-left thumb-sm avatar">
                    <img src="{{ avatar() }}" class="img-circle">
                </a>
                <span class="arrow left"></span>
                <section class="comment-body">
                    <section class="panel panel-default">

                        @widget('Comments\CreateWidget', ['commentable_type' => 'indexing' , 'commentable_id' => $indexing->id])
                        
            
                    </section>
                </section>
            </article>


            @widget('Comments\ShowComments', ['comments' => $indexing->comments])

            

        </section>
    </section>
</div>

@include('comments::_ajax.ajaxify')
<?php

namespace Modules\Indexing\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexingsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => \Modules\Indexing\Transformers\IndexingResource::collection($this->collection),
        ];
    }
}

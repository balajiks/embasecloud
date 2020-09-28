<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowCtn extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingctn' 		=> [],
		'user_id' 			=> [],
		'jobid' 			=> [],
		'orderid' 			=> [],
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['indexingctn'] 		= $this->config['indexingctn'];
		$data['user_id'] 			= $this->config['user_id'];
		$data['jobid'] 				= $this->config['jobid'];
		$data['orderid'] 			= $this->config['orderid'];

        return view(
            'widgets.indexing.show_ctn', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

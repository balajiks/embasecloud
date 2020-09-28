<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowDrugTradeName extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingdrugtrade' => [],
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
		
        $data['indexingdrugtrade'] 	= $this->config['indexingdrugtrade'];
		$data['user_id'] 			= $this->config['user_id'];
		$data['jobid'] 				= $this->config['jobid'];
		$data['orderid'] 			= $this->config['orderid'];

        return view(
            'widgets.indexing.show_drugtradename', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

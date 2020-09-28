<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowDeviceTradeName extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingdevicetrade' 	=> [],
		'user_id' 				=> [],
		'jobid' 				=> [],
		'orderid' 				=> [],
		'selecteddeviceid' 		=> [],
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
		
        $data['indexingdevicetrade'] 	= $this->config['indexingdevicetrade'];
		$data['user_id'] 			= $this->config['user_id'];
		$data['jobid'] 				= $this->config['jobid'];
		$data['orderid'] 			= $this->config['orderid'];
		$data['selecteddeviceid']		= $this->config['selecteddeviceid'];

        return view(
            'widgets.indexing.show_devicetradename', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

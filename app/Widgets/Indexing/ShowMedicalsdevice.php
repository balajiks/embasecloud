<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowMedicalsdevice extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingmedicalsdevice' 	=> [],
		'user_id' 					=> [],
		'jobid' 					=> [],
		'orderid' 					=> [],
		'pui' 						=> [],
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['indexingmedicalsdevice'] 	= $this->config['indexingmedicalsdevice'];
		$data['user_id'] 					= $this->config['user_id'];
		$data['jobid'] 						= $this->config['jobid'];
		$data['orderid'] 					= $this->config['orderid'];
		$data['pui'] 						= $this->config['pui'];

        return view(
            'widgets.indexing.show_medicalsdevice', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

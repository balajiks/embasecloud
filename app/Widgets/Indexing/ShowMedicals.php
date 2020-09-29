<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowMedicals extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingmedicals' 	=> [],
		'user_id' 			=> [],
		'jobid' 			=> [],
		'pui' 				=> [],
		'orderid' 			=> [],
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['indexingmedicals'] 	= $this->config['indexingmedicals'];
		$data['user_id'] 			= $this->config['user_id'];
		$data['jobid'] 				= $this->config['jobid'];
		$data['pui'] 				= $this->config['pui'];
		$data['orderid'] 			= $this->config['orderid'];

        return view(
            'widgets.indexing.show_medicals', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

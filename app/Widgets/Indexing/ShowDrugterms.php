<?php

namespace App\Widgets\Indexing; 

use Arrilot\Widgets\AbstractWidget;

class ShowDrugterms extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'indexingdrugterms' => [],
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
        $data['indexingdrugterms'] 	= $this->config['indexingdrugterms'];
		$data['user_id'] 			= $this->config['user_id'];
		$data['jobid'] 				= $this->config['jobid'];
		$data['orderid'] 			= $this->config['orderid'];

        return view(
            'widgets.indexing.show_drugterms', [
            'config' => $this->config,
            ]
        )->with($data);
    }
}

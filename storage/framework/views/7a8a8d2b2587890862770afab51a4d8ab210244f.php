<?php echo app('arrilot.widget')->run('Activities\Feed', ['activities' => Modules\Activity\Entities\Activity::where('actionable_type', Modules\Projects\Entities\Project::class)->with('user:id,username,name')->latest()->take(50)->get(), 'view' => 'dashboard']); ?>
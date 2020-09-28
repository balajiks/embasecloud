@component('mail::message')
{{-- Share Embase with friend --}}
Hello,  
I thought you'd be interested in using Embase Workflow to easily clients,manage your projects.
@component('mail::button', ['url' => 'http://google.com', 'color' => 'blue'])
I'm Interested
@endcomponent

@endcomponent
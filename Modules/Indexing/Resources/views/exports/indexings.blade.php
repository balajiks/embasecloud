<table>
    <thead>
    <tr>
        <th>@langapp('name')</th>
        <th>@langapp('job_title')</th>
        <th>@langapp('company')</th>
        <th>@langapp('source')</th>
        <th>@langapp('indexing_score')</th>
        <th>@langapp('stage')</th>
        <th>@langapp('email')</th>
        <th>@langapp('phone')</th>
        <th>@langapp('mobile')</th>
        <th>@langapp('address1')</th>
        <th>@langapp('address2')</th>
        <th>@langapp('city')</th>
        <th>@langapp('state')</th>
        <th>@langapp('zipcode')</th>
        <th>@langapp('country')</th>
        <th>@langapp('timezone')</th>
        <th>@langapp('website')</th>
        <th>Skype</th>
        <th>Facebook</th>
        <th>Twitter</th>
        <th>LinkedIn</th>
        <th>@langapp('sales_rep')</th>
        <th>@langapp('indexing_value')</th>
        <th>@langapp('created_at')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($indexings as $indexing)
        <tr>
            <td>{{ $indexing->name }}</td>
            <td>{{ $indexing->job_title }}</td>
            <td>{{ $indexing->company }}</td>
            <td>{{ $indexing->AsSource->name }}</td>
            <td>{{ $indexing->score }}</td>
            <td>{{ $indexing->status->name }}</td>
            <td>{{ $indexing->email }}</td>
            <td>{{ formatPhoneNumber($indexing->phone) }}</td>
            <td>{{ $indexing->mobile }}</td>
            <td>{{ $indexing->address1 }}</td>
            <td>{{ $indexing->address2 }}</td>
            <td>{{ $indexing->city }}</td>
            <td>{{ $indexing->state }}</td>
            <td>{{ $indexing->zip_code }}</td>
            <td>{{ $indexing->country }}</td>
            <td>{{ $indexing->timezone }}</td>
            <td>{{ $indexing->website }}</td>
            <td>{{ $indexing->skype }}</td>
            <td>{{ $indexing->facebook }}</td>
            <td>{{ $indexing->twitter }}</td>
            <td>{{ $indexing->linkedin }}</td>
            <td>{{ $indexing->agent->name }}</td>
            <td>{{ formatCurrency(get_option('default_currency'), $indexing->indexing_value) }}</td>
            <td>{{ $indexing->created_at->toIso8601String() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
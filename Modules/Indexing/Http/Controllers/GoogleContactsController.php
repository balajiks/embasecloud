<?php

namespace Modules\Indexing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Modules\Indexing\Entities\Indexing;

class GoogleContactsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importGoogleContacts(Request $request)
    {
        $code = $request->code;
        $googleService = \OAuth::consumer('Google');
        if (! is_null($code)) {
            $token = $googleService->requestAccessToken($code);
            $result = json_decode($googleService->request('https://www.google.com/m8/feeds/contacts/default/full?alt=json&max-results=1500'), true);
           
           
            foreach ($result['feed']['entry'] as $contact) {
                if (isset($contact['gd$email'])) {
                    $data = [];
                    $data['name'] = isset($contact['title']['$t']) ? $contact['title']['$t'] : '';
                    $data['indexing_source'] = 'Google Contacts';
                    $data['stage'] = get_option('default_indexing_stage');
                    $data['job_title'] = isset($contact['gd$organization'][0]['gd$orgTitle']['$t']) ? $contact['gd$organization'][0]['gd$orgTitle']['$t'] : '';
                    $data['company'] = isset($contact['gd$organization'][0]['gd$orgName']['$t']) ? $contact['gd$organization'][0]['gd$orgName']['$t'] : '';
                    $data['phone_number'] = isset($contact['gd$phoneNumber'][0]['$t']) ? $contact['gd$phoneNumber'][0]['$t'] : '';
                    $data['email'] = $contact['gd$email'][0]['address'];
                    $data['address1'] = isset($contact['gd$postalAddress'][0]['$t']) ? $contact['gd$postalAddress'][0]['$t'] : '';
                    $data['city'] = isset($contact['gd$structuredPostalAddress'][0]['gd$city']) ? $contact['gd$structuredPostalAddress'][0]['gd$city'] : '';
                    $data['state'] = isset($contact['gd$structuredPostalAddress'][0]['gd$region']) ? $contact['gd$structuredPostalAddress'][0]['gd$region'] : '';
                    $data['country'] = isset($contact['gd$structuredPostalAddress'][0]['gd$country']) ? $contact['gd$structuredPostalAddress'][0]['gd$country'] : '';
                    $data['sales_rep'] = get_option('default_sales_rep');
                    Indexing::updateOrCreate(
                        [
                            'email' => $contact['gd$email'][0]['address']
                        ],
                        $data
                    );
                }
            }
                
            toastr()->info('Indexing created from Google contacts', langapp('response_status'));

            return redirect()->route('indexing.index');
        } else {
            $url = $googleService->getAuthorizationUri();
            return redirect((string)$url);
        }
    }
}

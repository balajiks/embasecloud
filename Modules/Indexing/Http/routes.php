<?php

Route::group(
    ['middleware' => 'web', 'prefix' => 'indexing', 'namespace' => 'Modules\Indexing\Http\Controllers'],
    function () {
        //Route::get('/', 'IndexingCustomController@index')->name('indexing.index')->middleware('can:menu_indexing');
		Route::get('/', 'IndexingCustomController@index')->name('indexing.index')->middleware('can:menu_indexing');
        Route::get('/create', 'IndexingCustomController@create')->name('indexing.create');
        Route::get('/view/{indexing}/{tab?}/{option?}', 'IndexingCustomController@view')->name('indexing.view');
        Route::get('/delete/{indexing}', 'IndexingCustomController@delete')->name('indexing.delete')->middleware('can:indexing_delete');
		Route::get('/add/{tab?}/{option?}', 'IndexingCustomController@addindexing')->name('indexing.addindexing');
		
		Route::get('/showmeta/{indexing}', 'IndexingCustomController@showmeta')->name('indexing.showmeta');
		Route::get('/showsource/{indexing}', 'IndexingCustomController@showsource')->name('indexing.showsource');
		Route::get('/showemtree/{indexing}', 'IndexingCustomController@showemtree')->name('indexing.showemtree');
		Route::get('/ajaxapivalidation/{indexing}', 'IndexingCustomController@ajaxapivalidation')->name('indexing.ajaxapivalidation');
		
		
		Route::get('/sectioncreate', 'IndexingCustomController@sectioncreate')->name('indexing.sectioncreate');

        Route::get('/next-stage/{indexing}', 'IndexingCustomController@nextStage')->name('indexing.nextstage')->middleware('can:indexing_update');
        Route::get('/edit/{indexing}', 'IndexingCustomController@edit')->name('indexing.edit')->middleware('can:indexing_update');

        Route::post('bulk-delete', 'IndexingCustomController@bulkDelete')->name('indexing.bulk.delete')->middleware('can:indexing_delete');
        Route::post('bulk-email', 'IndexingCustomController@bulkEmail')->name('indexing.bulk.email')->middleware('can:indexing_update');
        Route::post('bulk-send', 'IndexingCustomController@sendBulk')->name('indexing.bulk.send');

        Route::get('/import', 'IndexingCustomController@import')->name('indexing.import')->middleware('can:indexing_create');
        Route::get('import/callback', 'IndexingCustomController@importGoogleContacts')->name('indexing.import.callback')->middleware('can:indexing_create');
        Route::get('/export', 'IndexingCustomController@export')->name('indexing.export')->middleware('can:menu_indexing');
        Route::post('csvmap', 'IndexingCustomController@parseImport')->name('indexing.csvmap')->middleware('can:indexing_create');
        Route::post('csvprocess', 'IndexingCustomController@processImport')->name('indexing.csvprocess')->middleware('can:indexing_create');

        Route::post('table-json', 'IndexingCustomController@tableData')->name('indexing.data')->middleware('can:menu_indexing');

        Route::get('/convert/{indexing}', 'IndexingCustomController@convert')->name('indexing.convert')->middleware('can:deals_create');

        Route::get('/consent/{indexing}', 'IndexingCustomController@sendConsent')->name('indexing.consent')->middleware('can:indexing_create');
        Route::get('/whatsapp-consent/{indexing}', 'IndexingCustomController@sendWhatsappConsent')->name('indexing.consent.whatsapp')->middleware('can:indexing_create');
        Route::get('/consent-accept/{token}', 'IndexingConsentController@accept')->name('indexing.consent.accept');
        Route::get('/consent-decline/{token}', 'IndexingConsentController@decline')->name('indexing.consent.decline');

        Route::post('/email-delete', 'IndexingCustomController@ajaxDeleteMail')->name('indexing.email.delete');
        Route::post('/email/{indexing}', 'IndexingCustomController@email')->name('indexing.email');
        Route::post('/emails/reply', 'IndexingCustomController@replyEmail')->name('indexing.emailReply');
    }
);

<?php

Route::group(
    ['middleware' => 'auth:api', 'prefix' => 'api/v1', 'namespace' => 'Modules\Indexing\Http\Controllers\Api\v1'],
    function () {
        Route::get('indexing/{id}/calls', 'indexingApiController@calls')->name('indexing.api.calls')->middleware('can:menu_indexing');
        Route::get('indexing/{id}/todos', 'indexingApiController@todos')->name('indexing.api.todos')->middleware('can:menu_indexing');
        Route::get('indexing/{id}/comments', 'indexingApiController@comments')->name('indexing.api.comments')->middleware('can:menu_indexing');
        Route::post('indexing/{id}/nextstage', 'indexingApiController@nextStage')->name('indexing.api.next.stage')->middleware('can:indexing_update');
        Route::post('indexing/{id}/movestage', 'indexingApiController@moveStage')->name('indexing.api.movestage')->middleware('can:indexing_update');
        Route::post('indexing/{id}/convert', 'indexingApiController@convert')->name('indexing.api.convert')->middleware('can:deals_create');
        Route::get('indexing', 'indexingApiController@index')->name('indexing.api.index')->middleware('can:menu_indexing');
        Route::get('indexing/{id}', 'indexingApiController@show')->name('indexing.api.show')->middleware('can:menu_indexing');
       // Route::post('indexing', 'indexingApiController@save')->name('indexing.api.save')->middleware('can:indexing_create');
        Route::put('indexing/{id}', 'indexingApiController@update')->name('indexing.api.update')->middleware('can:indexing_update');
        Route::delete('indexing/{id}', 'indexingApiController@delete')->name('indexing.api.delete')->middleware('can:indexing_delete');
		
		
		Route::post('indexing/savesection', 'indexingApiController@savesection')->name('indexing.api.savesection');
		Route::post('indexing/savemedical', 'indexingApiController@savemedical')->name('indexing.api.savemedical');
		Route::post('indexing/savedrug', 'indexingApiController@savedrug')->name('indexing.api.savedrug');
		Route::post('indexing/savedruglinks', 'indexingApiController@savedruglinks')->name('indexing.api.savedruglinks');
		Route::post('indexing/savedrugtradename', 'indexingApiController@savedrugtradename')->name('indexing.api.savedrugtradename');
		Route::post('indexing/savedevicetradename', 'indexingApiController@savedevicetradename')->name('indexing.api.savedevicetradename');
		
		Route::post('indexing/savemedicaldeviceindexing', 'indexingApiController@savemedicaldeviceindexing')->name('indexing.api.savemedicaldeviceindexing');
		
		Route::post('indexing/savectn', 'indexingApiController@savectn')->name('indexing.api.savectn');
		
		Route::get('indexing/getsectiondata/{id}', 'indexingApiController@getsectiondata')->name('indexing.api.getsectiondata');
		Route::get('indexing/getmedicaldata/{id}', 'indexingApiController@getmedicaldata')->name('indexing.api.getmedicaldata');
		
		
		Route::post('indexing/ajax/classification', 'indexingApiController@classification')->name('indexing.api.classification')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/terms', 'indexingApiController@terms')->name('indexing.api.terms')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/termdrug', 'indexingApiController@termdrug')->name('indexing.api.termdrug')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/termemmans', 'indexingApiController@termemmans')->name('indexing.api.termemmans')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/termcountry', 'indexingApiController@termcountry')->name('indexing.api.termcountry')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/tradenamedata', 'indexingApiController@tradenamedata')->name('indexing.api.tradenamedata')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/devicetradenamedata', 'indexingApiController@devicetradenamedata')->name('indexing.api.devicetradenamedata')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/termdevice', 'indexingApiController@termdevice')->name('indexing.api.termdevice')->middleware('can:menu_indexing');
		
		Route::post('indexing/ajax/sublink', 'indexingApiController@sublink')->name('indexing.api.sublink')->middleware('can:menu_indexing');
		
		Route::delete('indexing/{id}/sectionindex', 'indexingApiController@deletesection')->name('indexing.api.deletesection')->middleware('can:indexing_delete');
		Route::post('indexing/sectiondeleteall', 'indexingApiController@sectiondeleteall')->name('indexing.api.sectiondeleteall')->middleware('can:menu_indexing');
		
		
		
		Route::delete('indexing/{id}/medicaltermindex', 'indexingApiController@deletemedical')->name('indexing.api.deletemedical')->middleware('can:indexing_delete');
		Route::delete('indexing/{id}/medicalchecktagtermindex', 'indexingApiController@deletemedicalchecktag')->name('indexing.api.deletemedicalchecktag')->middleware('can:indexing_delete');
		
		Route::delete('indexing/{id}/drugctnindex', 'indexingApiController@deletectn')->name('indexing.api.deletectn')->middleware('can:indexing_delete');
		
		Route::delete('indexing/{id}/drugtrademanufacture', 'indexingApiController@drugtrademanufacture')->name('indexing.api.drugtrademanufacture')->middleware('can:indexing_delete');
		
		Route::delete('indexing/{id}/{value}/deletedrugtradename', 'indexingApiController@deletedrugtradename')->name('indexing.api.deletedrugtradename')->middleware('can:indexing_delete');
		
		Route::delete('indexing/{id}/{value}/deletedevicetradename', 'indexingApiController@deletedevicetradename')->name('indexing.api.deletedevicetradename')->middleware('can:indexing_delete');
		
		Route::delete('indexing/{id}/deletemedicaldevicetradename', 'indexingApiController@deletemedicaldevicetradename')->name('indexing.api.deletemedicaldevicetradename')->middleware('can:indexing_delete');
		
		Route::post('indexing/frmdrugotherfield', 	'indexingApiController@frmdrugotherfield')->name('indexing.api.frmdrugotherfield');
		Route::post('indexing/frmdrugtherapy', 	'indexingApiController@frmdrugtherapy')->name('indexing.api.frmdrugtherapy');
		Route::post('indexing/frmdrugdoseinfo', 	'indexingApiController@frmdrugdoseinfo')->name('indexing.api.frmdrugdoseinfo');
		Route::post('indexing/frmrouteofdrug', 	'indexingApiController@frmrouteofdrug')->name('indexing.api.frmrouteofdrug');
		Route::post('indexing/frmdosefrequency', 	'indexingApiController@frmdosefrequency')->name('indexing.api.frmdosefrequency');
		Route::post('indexing/frmdrugcombination', 'indexingApiController@frmdrugcombination')->name('indexing.api.frmdrugcombination');
		Route::post('indexing/frmadversedrug', 	'indexingApiController@frmadversedrug')->name('indexing.api.frmadversedrug');
		Route::post('indexing/frmdrugcomparison', 	'indexingApiController@frmdrugcomparison')->name('indexing.api.frmdrugcomparison');
		Route::post('indexing/frmdrugdosage', 		'indexingApiController@frmdrugdosage')->name('indexing.api.frmdrugdosage');
		Route::post('indexing/frmdruginteraction', 'indexingApiController@frmdruginteraction')->name('indexing.api.frmdruginteraction');
		Route::post('indexing/frmdrugpharma', 		'indexingApiController@frmdrugpharma')->name('indexing.api.frmdrugpharma');
		Route::post('indexing/frmdrugtradename', 	'indexingApiController@frmdrugtradename')->name('indexing.api.frmdrugtradename');		
		Route::post('indexing/savemedicalindexing', 'indexingApiController@savemedicalindexing')->name('indexing.api.savemedicalindexing');
		
		Route::delete('indexing/{id}/{jobid}/{orderid}/medicaldevicetermindex', 'indexingApiController@deletemedicaldevice')->name('indexing.api.deletemedicaldevice')->middleware('can:indexing_delete');
		
		Route::post('indexing/ajax/esvsentences', 'indexingApiController@esvsentences')->name('indexing.api.esvsentences')->middleware('can:menu_indexing');
		Route::post('indexing/ajax/emtreefindterm', 'indexingApiController@emtreefindterm')->name('indexing.api.emtreefindterm')->middleware('can:menu_indexing');
		Route::post('indexing/saveesvdata', 'indexingApiController@saveesvdata')->name('indexing.api.saveesvdata');
		
		Route::post('indexing/ajaxdatview', 'indexingApiController@ajaxdatview')->name('indexing.api.ajaxdatview');
		
		Route::post('indexing/ajax/termemtree', 'indexingApiController@termemtree')->name('indexing.api.termemtree')->middleware('can:menu_indexing');
		
		Route::post('indexing/ajax/callapiemtree', 'indexingApiController@callapiemtree')->name('indexing.api.callapiemtree')->middleware('can:menu_indexing');
		
		Route::post('indexing/apicompletejob', 'indexingApiController@apicompletejob')->name('indexing.api.apicompletejob')->middleware('can:menu_indexing');
		
		Route::post('indexing/ajax/getclassificationdetails', 'indexingApiController@getclassificationdetails')->name('indexing.api.getclassificationdetails')->middleware('can:menu_indexing');
		
		Route::post('indexing/ajax/getmedicaldiseasesdetails', 'indexingApiController@getmedicaldiseasesdetails')->name('indexing.api.getmedicaldiseasesdetails')->middleware('can:menu_indexing');
		
		
		
		
		Route::post('indexing/deleteclassification', 'indexingApiController@deleteClassification')->name('indexing.api.deleteClassification')->middleware('can:indexing_delete');
		
		Route::post('indexing/deletediseases', 'indexingApiController@deletediseases')->name('indexing.api.deletediseases')->middleware('can:indexing_delete');
		
		
    }
);

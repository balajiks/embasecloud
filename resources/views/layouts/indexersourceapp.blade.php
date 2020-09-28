<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ get_option('rtl') == 'TRUE' ? 'rtl' : 'ltr' }}" class="app">
<head>
<meta charset="utf-8"/>
<meta name="author" content="{{ get_option('site_author') }}">
<meta name="keywords" content="{{ get_option('site_keywords') }}">
<meta name="description" content="{{ get_option('site_desc') }}">
<?php $favicon = get_option('site_favicon');
    $ext = substr($favicon, -4); ?>
@if ($ext == '.ico')
<link rel="shortcut icon" href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon')) }}">
@endif
    @if ($ext == '.png')
<link rel="icon" type="image/png" href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon')) }}">
@endif
    @if ($ext == '.jpg' || $ext == 'jpeg')
<link rel="icon" type="image/jpeg" href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_favicon')) }}">
@endif
    @if (get_option('site_appleicon') != '')
<link rel="apple-touch-icon" href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}"/>
<link rel="apple-touch-icon" sizes="72x72"
              href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}"/>
<link rel="apple-touch-icon" sizes="114x114"
              href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}"/>
<link rel="apple-touch-icon" sizes="144x144"
              href="{{ get_option('site_url') }}{{ getStorageUrl(config('system.media_dir').'/'.get_option('site_appleicon')) }}"/>
@endif
<meta name="userId" content="{{ Auth::check() ? Auth::id() : '' }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ count(Auth::user()->unreadNotifications) > 0 ? '('.count(Auth::user()->unreadNotifications).')' : '' }} {{ get_option('company_name') }} - {{ $page }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" href="{{ getAsset('css/theme.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ getAsset('plugins/apps/pace.css') }}" type="text/css"/>
@if(config('system.material_design'))
<link rel="stylesheet" href="{{ getAsset('css/propeller.min.css') }}" type="text/css"/>
@endif
    @isset($sign)
<link href="//fonts.googleapis.com/css?family=Mr+Dafoe" rel="stylesheet">
@endisset
    @isset($help)
<link rel="stylesheet" href="{{ getAsset('plugins/intro/introjs.min.css')  }}" type="text/css"/>
@endisset
    @isset($signature)
<link href="//fonts.googleapis.com/css?family=Dawning+of+a+New+Day" rel="stylesheet">
@endisset
    @if (config('system.drift_enabled'))
        @include('partial.drift')
    @endif
    @if (config('system.crisp_enabled'))
        @include('partial.crisp')
    @endif
    @if (config('system.enable_onesignal'))
        @include('partial.onesignal')
    @endif

    @if (config('system.enable_tawk'))
        @include('partial.tawk')
    @endif


    @stack('pagestyle')
<link rel="stylesheet" href="{{ getAsset('css/app.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ getAsset('storage/css/style.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ getAsset('css/lato.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ getAsset('css/style.min.css') }}" type="text/css"/>
<link rel="stylesheet" href="{{ getAsset('js/dist/themes/default/style.min.css') }}" />
@include('partial.custom')
<?php
    $family = 'Default';
    $font = get_option('system_font');
    switch ($font) {
        case 'open_sans':
            $family = 'Open Sans';
            echo "<link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=latin,latin-ext,greek-ext,cyrillic-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'open_sans_condensed':
            $family = 'Open Sans Condensed';
            echo "<link href='//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'roboto':
            $family = 'Roboto';
            echo "<link href='//fonts.googleapis.com/css?family=Roboto:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'roboto_condensed':
            $family = 'Roboto Condensed';
            echo "<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'ubuntu':
            $family = 'Ubuntu';
            echo "<link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,500,700&subset=latin,greek-ext,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'lato':
            $family = 'Lato';
            echo "<link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'oxygen':
            $family = 'Oxygen';
            echo "<link href='//fonts.googleapis.com/css?family=Oxygen:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'pt_sans':
            $family = 'PT Sans';
            echo "<link href='//fonts.googleapis.com/css?family=PT+Sans:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'source_sans':
            $family = 'Source Sans Pro';
            echo "<link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>";
            break;
        case 'muli':
            $family = 'Muli';
            echo "<link href='//fonts.googleapis.com/css?family=Muli' rel='stylesheet'>";
            break;
        case 'miriam':
            $family = 'Miriam Libre';
            echo "<link href='//fonts.googleapis.com/css?family=Miriam+Libre' rel='stylesheet'>";
            break;
    }
    ?>
<style type="text/css">
        body {
            font-family: '{{ $family }}';
        }
        h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
            font-family: '{{ $family }}', sans-serif;
        }
        .inv-bg { background-color: {{ get_option('invoice_color') }}; }
        .est-bg { background-color: {{ get_option('estimate_color') }}; color: #fff; }

/*
PDFObject appends the classname "pdfobject-container" to the target element.
This enables you to style the element differently depending on whether the embed was successful.
In this example, a successful embed will result in a large box.
A failed embed will not have dimensions specified, so you don't see an oddly large empty box.
*/

.pdfobject-container {
	width: 100%;
	height: 600px;
	margin: 2em 0;
}

.pdfobject { border: solid 1px #666; }
#results { padding: 1rem; }
.hidden { display: none; }
.success { color: #4F8A10; background-color: #DFF2BF; }
.fail { color: #D8000C; background-color: #FFBABA; }		
		
.pdfobject-com {
	position: absolute;
	top: 0;
	left: 0;
	z-index: 2016;
}

.pdfobject-com a:link, .pdfobject-com a:visited {
	color: #fff;
	font-weight: bold;
	display: block;
	padding: .25rem 1rem;
	background: #6699FF;
	text-decoration: none;
}

.pdfobject-com a:hover, .pdfobject-com a:visited:hover {
	color: #FFF;
	background: #FF3366;
	text-decoration: none;
}

.pdfobject-com a:before {
     content: "\2190";
     margin-right: .25rem;
}
    </style>
<!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head><body>
@include('cookie_consent')
<section class="vbox" id="app"> @include('partial.top_header')
  <section class="">
    <section class="hbox stretch"> @yield('content')
      @include('partial.notifier') </section>
  </section>
</section>
<script src="{{ getAsset('js/app.js') }}"></script>
<script src="{{ getAsset('js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ getAsset('js/jstree.min.js') }}"></script>
@push('pagescript')
<script>
$(function () {
	$('#tree').jstree({
	  "core" : {
		"themes" : {
		  "variant" : "medium"
		}
	  },
	  "checkbox" : {
		"keep_selected_style" : false
	  },
	  "plugins" : [  "checkbox","contextmenu" ],
	  "contextmenu":{         
			"items": function($node) {
			
				var tree = $("#tree").jstree(true);
				var selectedkeyterm = $node.li_attr.title;
				
			if($node.parent == 'elsevierterm'){
			
		
			
			return {
					"Create": {
						"separator_before": false,
						"separator_after": false,
						"label": "Add "+selectedkeyterm,
						"action": function (obj) {
						
						 		var data = {};
								data['jobid'] 	= $('#jobid').val();
								data['pui'] 	= $('#pui').val();
								data['orderid']	= $('#orderid').val();
								data['termtype']= $($node.text).children('div').html();
								data['term']	= $($node.text).children('span').html();
								data['type']	= selectedkeyterm.toLowerCase();
								data['term_added']		= 'elsevier';
							axios.post('{{ route('indexing.api.saveesvdata') }}', data)
								.then(function (response) {
								$("#tree").jstree(true).set_icon($node.id, "https://img.icons8.com/cotton/2x/tree.png");
										alert(response.data.message);
										
										
										
										return false;				
										
										console.log(response);
										toastr.success( response.data.message , '@langapp('response_status') ');
										$(".formSaving").html('<i class="fas fa-save"></i> @langapp('save') </span>');
										tag[0].reset();
								})
								.catch(function (error) {
									var errors = error.response.data.errors;
									var errorsHtml= '';
									$.each( errors, function( key, value ) {
									errorsHtml += '<li>' + value[0] + '</li>';
									});
									toastr.error( errorsHtml , '@langapp('response_status') ');
									$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
							});
						}
					}
				};
			
			
			} else {
				return {
					"Create": {
						"separator_before": false,
						"separator_after": false,
						"label": "Add Major",
						"action": function (obj) {
						
						 		var data = {};
								data['jobid'] 	= $('#jobid').val();
								data['pui'] 	= $('#pui').val();
								data['orderid']	= $('#orderid').val();
								data['termtype']= $($node.text).children('div').html();
								data['term']	= $($node.text).children('span').html();
								data['type']	= 'major';
								data['term_added']		= 'esv';
							axios.post('{{ route('indexing.api.saveesvdata') }}', data)
								.then(function (response) {
								$("#tree").jstree(true).set_icon($node.id, "https://img.icons8.com/cotton/2x/tree.png");
										alert(response.data.message);
										return false;				
										
										console.log(response);
										toastr.success( response.data.message , '@langapp('response_status') ');
										$(".formSaving").html('<i class="fas fa-save"></i> @langapp('save') </span>');
										tag[0].reset();
								})
								.catch(function (error) {
									var errors = error.response.data.errors;
									var errorsHtml= '';
									$.each( errors, function( key, value ) {
									errorsHtml += '<li>' + value[0] + '</li>';
									});
									toastr.error( errorsHtml , '@langapp('response_status') ');
									$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
							});
						}
					},
					"Rename": {
						"separator_before": false,
						"separator_after": false,
						"label": "Add Minor",
						"action": function (obj) { 
							var data = {};
								data['jobid'] 	= $('#jobid').val();
								data['pui'] 	= $('#pui').val();
								data['orderid']	= $('#orderid').val();
								data['termtype']= $($node.text).children('div').html();
								data['term']	= $($node.text).children('span').html();
								data['type']	= 'minor';
								data['term_added']		= 'esv';
							axios.post('{{ route('indexing.api.saveesvdata') }}', data)
								.then(function (response) {
										alert(response.data.message);
										return false;				
										
										console.log(response);
										toastr.success( response.data.message , '@langapp('response_status') ');
										$(".formSaving").html('<i class="fas fa-save"></i> @langapp('save') </span>');
										tag[0].reset();
								})
								.catch(function (error) {
									var errors = error.response.data.errors;
									var errorsHtml= '';
									$.each( errors, function( key, value ) {
									errorsHtml += '<li>' + value[0] + '</li>';
									});
									toastr.error( errorsHtml , '@langapp('response_status') ');
									$(".formSaving").html('<i class="fas fa-sync"></i> Try Again');
							});
						}
					}
				};
				
			}	
			
			
				
				
			}
		}
	}).bind("loaded	.jstree",
    function (e, data) {
        alert("Checked: " + data.node.id);
        alert("Parent: " + data.node.parent); 
        alert(JSON.stringify(data));
    });
});














</script>
{!! Toastr::message() !!}
    @endpush
    @stack('pagescript')
</body>
</html>

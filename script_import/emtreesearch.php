<html lang="en" dir="ltr" style="height: 100%;">
<head>
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta charset="utf-8">
<meta content="width=device-width" name="viewport">
<title>Embase</title>
<meta content="no-cache" http-equiv="Pragma">
<script type="text/javascript" src="https://bam.nr-data.net/1/3c836f97d2?a=631471793&amp;v=1169.7b094c0&amp;to=blRRMUVQC0JWVhJaV1ceYBFFRBFCdlYSWldXHlAKWh8AXURQEFpdSx9fEEBQDh9WRRZAFlxcUQREVEtCUkcQX11NQh0LVkcMVlZBD1xWF3NSBlxTCl9ScQNVWUxdRyRURQxeWQ%3D%3D&amp;rst=2075&amp;ck=1&amp;ref=https://www.embase.com/&amp;ap=2&amp;be=960&amp;fe=1500&amp;dc=1200&amp;perf=%7B%22timing%22:%7B%22of%22:1593150117544,%22n%22:0,%22u%22:887,%22r%22:2,%22ue%22:906,%22re%22:579,%22f%22:583,%22dn%22:583,%22dne%22:583,%22c%22:583,%22ce%22:583,%22rq%22:603,%22rp%22:886,%22rpe%22:886,%22dl%22:887,%22di%22:1171,%22ds%22:1200,%22de%22:1200,%22dc%22:1499,%22l%22:1499,%22le%22:1502%7D,%22navigation%22:%7B%22rc%22:1%7D%7D&amp;jsonp=NREUM.setToken"></script>
<script src="https://js-agent.newrelic.com/nr-1169.min.js"></script>
<script async="" src="https://cdn.pendo.io/agent/static/4d0dfb3d-9fc0-428d-7e95-939e53338845/pendo.js"></script>
<script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={licenseKey:"3c836f97d2",applicationID:"631471793"};window.NREUM||(NREUM={}),__nr_require=function(e,n,t){function r(t){if(!n[t]){var i=n[t]={exports:{}};e[t][0].call(i.exports,function(n){var i=e[t][1][n];return r(i||n)},i,i.exports)}return n[t].exports}if("function"==typeof __nr_require)return __nr_require;for(var i=0;i&lt;t.length;i++)r(t[i]);return r}({1:[function(e,n,t){function r(){}function i(e,n,t){return function(){return o(e,[u.now()].concat(f(arguments)),n?null:this,t),n?void 0:this}}var o=e("handle"),a=e(4),f=e(5),c=e("ee").get("tracer"),u=e("loader"),s=NREUM;"undefined"==typeof window.newrelic&amp;&amp;(newrelic=s);var p=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit","addRelease"],l="api-",d=l+"ixn-";a(p,function(e,n){s[n]=i(l+n,!0,"api")}),s.addPageAction=i(l+"addPageAction",!0),s.setCurrentRouteName=i(l+"routeName",!0),n.exports=newrelic,s.interaction=function(){return(new r).get()};var m=r.prototype={createTracer:function(e,n){var t={},r=this,i="function"==typeof n;return o(d+"tracer",[u.now(),e,t],r),function(){if(c.emit((i?"":"no-")+"fn-start",[u.now(),r,i],t),i)try{return n.apply(this,arguments)}catch(e){throw c.emit("fn-err",[arguments,this,e],t),e}finally{c.emit("fn-end",[u.now()],t)}}}};a("actionText,setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,n){m[n]=i(d+n)}),newrelic.noticeError=function(e,n){"string"==typeof e&amp;&amp;(e=new Error(e)),o("err",[e,u.now(),!1,n])}},{}],2:[function(e,n,t){function r(e,n){var t=e.getEntries();t.forEach(function(e){"first-paint"===e.name?c("timing",["fp",Math.floor(e.startTime)]):"first-contentful-paint"===e.name&amp;&amp;c("timing",["fcp",Math.floor(e.startTime)])})}function i(e,n){var t=e.getEntries();t.length&gt;0&amp;&amp;c("lcp",[t[t.length-1]])}function o(e){if(e instanceof s&amp;&amp;!l){var n,t=Math.round(e.timeStamp);n=t&gt;1e12?Date.now()-t:u.now()-t,l=!0,c("timing",["fi",t,{type:e.type,fid:n}])}}if(!("init"in NREUM&amp;&amp;"page_view_timing"in NREUM.init&amp;&amp;"enabled"in NREUM.init.page_view_timing&amp;&amp;NREUM.init.page_view_timing.enabled===!1)){var a,f,c=e("handle"),u=e("loader"),s=NREUM.o.EV;if("PerformanceObserver"in window&amp;&amp;"function"==typeof window.PerformanceObserver){a=new PerformanceObserver(r),f=new PerformanceObserver(i);try{a.observe({entryTypes:["paint"]}),f.observe({entryTypes:["largest-contentful-paint"]})}catch(p){}}if("addEventListener"in document){var l=!1,d=["click","keydown","mousedown","pointerdown","touchstart"];d.forEach(function(e){document.addEventListener(e,o,!1)})}}},{}],3:[function(e,n,t){function r(e,n){if(!i)return!1;if(e!==i)return!1;if(!n)return!0;if(!o)return!1;for(var t=o.split("."),r=n.split("."),a=0;a&lt;r.length;a++)if(r[a]!==t[a])return!1;return!0}var i=null,o=null,a=/Version\/(\S+)\s+Safari/;if(navigator.userAgent){var f=navigator.userAgent,c=f.match(a);c&amp;&amp;f.indexOf("Chrome")===-1&amp;&amp;f.indexOf("Chromium")===-1&amp;&amp;(i="Safari",o=c[1])}n.exports={agent:i,version:o,match:r}},{}],4:[function(e,n,t){function r(e,n){var t=[],r="",o=0;for(r in e)i.call(e,r)&amp;&amp;(t[o]=n(r,e[r]),o+=1);return t}var i=Object.prototype.hasOwnProperty;n.exports=r},{}],5:[function(e,n,t){function r(e,n,t){n||(n=0),"undefined"==typeof t&amp;&amp;(t=e?e.length:0);for(var r=-1,i=t-n||0,o=Array(i&lt;0?0:i);++r&lt;i;)o[r]=e[n+r];return o}n.exports=r},{}],6:[function(e,n,t){n.exports={exists:"undefined"!=typeof window.performance&amp;&amp;window.performance.timing&amp;&amp;"undefined"!=typeof window.performance.timing.navigationStart}},{}],ee:[function(e,n,t){function r(){}function i(e){function n(e){return e&amp;&amp;e instanceof r?e:e?c(e,f,o):o()}function t(t,r,i,o){if(!l.aborted||o){e&amp;&amp;e(t,r,i);for(var a=n(i),f=v(t),c=f.length,u=0;u&lt;c;u++)f[u].apply(a,r);var p=s[y[t]];return p&amp;&amp;p.push([b,t,r,a]),a}}function d(e,n){h[e]=v(e).concat(n)}function m(e,n){var t=h[e];if(t)for(var r=0;r&lt;t.length;r++)t[r]===n&amp;&amp;t.splice(r,1)}function v(e){return h[e]||[]}function g(e){return p[e]=p[e]||i(t)}function w(e,n){u(e,function(e,t){n=n||"feature",y[t]=n,n in s||(s[n]=[])})}var h={},y={},b={on:d,addEventListener:d,removeEventListener:m,emit:t,get:g,listeners:v,context:n,buffer:w,abort:a,aborted:!1};return b}function o(){return new r}function a(){(s.api||s.feature)&amp;&amp;(l.aborted=!0,s=l.backlog={})}var f="nr@context",c=e("gos"),u=e(4),s={},p={},l=n.exports=i();l.backlog=s},{}],gos:[function(e,n,t){function r(e,n,t){if(i.call(e,n))return e[n];var r=t();if(Object.defineProperty&amp;&amp;Object.keys)try{return Object.defineProperty(e,n,{value:r,writable:!0,enumerable:!1}),r}catch(o){}return e[n]=r,r}var i=Object.prototype.hasOwnProperty;n.exports=r},{}],handle:[function(e,n,t){function r(e,n,t,r){i.buffer([e],r),i.emit(e,n,t)}var i=e("ee").get("handle");n.exports=r,r.ee=i},{}],id:[function(e,n,t){function r(e){var n=typeof e;return!e||"object"!==n&amp;&amp;"function"!==n?-1:e===window?0:a(e,o,function(){return i++})}var i=1,o="nr@id",a=e("gos");n.exports=r},{}],loader:[function(e,n,t){function r(){if(!x++){var e=E.info=NREUM.info,n=d.getElementsByTagName("script")[0];if(setTimeout(s.abort,3e4),!(e&amp;&amp;e.licenseKey&amp;&amp;e.applicationID&amp;&amp;n))return s.abort();u(y,function(n,t){e[n]||(e[n]=t)}),c("mark",["onload",a()+E.offset],null,"api");var t=d.createElement("script");t.src="https://"+e.agent,n.parentNode.insertBefore(t,n)}}function i(){"complete"===d.readyState&amp;&amp;o()}function o(){c("mark",["domContent",a()+E.offset],null,"api")}function a(){return O.exists&amp;&amp;performance.now?Math.round(performance.now()):(f=Math.max((new Date).getTime(),f))-E.offset}var f=(new Date).getTime(),c=e("handle"),u=e(4),s=e("ee"),p=e(3),l=window,d=l.document,m="addEventListener",v="attachEvent",g=l.XMLHttpRequest,w=g&amp;&amp;g.prototype;NREUM.o={ST:setTimeout,SI:l.setImmediate,CT:clearTimeout,XHR:g,REQ:l.Request,EV:l.Event,PR:l.Promise,MO:l.MutationObserver};var h=""+location,y={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-1169.min.js"},b=g&amp;&amp;w&amp;&amp;w[m]&amp;&amp;!/CriOS/.test(navigator.userAgent),E=n.exports={offset:f,now:a,origin:h,features:{},xhrWrappable:b,userAgent:p};e(1),e(2),d[m]?(d[m]("DOMContentLoaded",o,!1),l[m]("load",r,!1)):(d[v]("onreadystatechange",i),l[v]("onload",r)),c("mark",["firstbyte",f],null,"api");var x=0,O=e(6)},{}],"wrap-function":[function(e,n,t){function r(e){return!(e&amp;&amp;e instanceof Function&amp;&amp;e.apply&amp;&amp;!e[a])}var i=e("ee"),o=e(5),a="nr@original",f=Object.prototype.hasOwnProperty,c=!1;n.exports=function(e,n){function t(e,n,t,i){function nrWrapper(){var r,a,f,c;try{a=this,r=o(arguments),f="function"==typeof t?t(r,a):t||{}}catch(u){l([u,"",[r,a,i],f])}s(n+"start",[r,a,i],f);try{return c=e.apply(a,r)}catch(p){throw s(n+"err",[r,a,p],f),p}finally{s(n+"end",[r,a,c],f)}}return r(e)?e:(n||(n=""),nrWrapper[a]=e,p(e,nrWrapper),nrWrapper)}function u(e,n,i,o){i||(i="");var a,f,c,u="-"===i.charAt(0);for(c=0;c&lt;n.length;c++)f=n[c],a=e[f],r(a)||(e[f]=t(a,u?f+i:i,o,f))}function s(t,r,i){if(!c||n){var o=c;c=!0;try{e.emit(t,r,i,n)}catch(a){l([a,t,r,i])}c=o}}function p(e,n){if(Object.defineProperty&amp;&amp;Object.keys)try{var t=Object.keys(e);return t.forEach(function(t){Object.defineProperty(n,t,{get:function(){return e[t]},set:function(n){return e[t]=n,n}})}),n}catch(r){l([r])}for(var i in e)f.call(e,i)&amp;&amp;(n[i]=e[i]);return n}function l(n){try{e.emit("internal-error",n)}catch(t){}}return e||(e=i),t.inPlace=u,t.flag=a,t}},{}]},{},["loader"]);</script>
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-57x57.png?269" sizes="57x57" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-60x60.png?269" sizes="60x60" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-72x72.png?269" sizes="72x72" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-76x76.png?269" sizes="76x76" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-114x114.png?269" sizes="114x114" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-120x120.png?269" sizes="120x120" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-144x144.png?269" sizes="144x144" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-152x152.png?269" sizes="152x152" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/apple-touch-icon-180x180.png?269" sizes="180x180" rel="apple-touch-icon">
<link href="https://www.embase.com/webfiles/images/favicon-192.png?269" sizes="192x192" type="image/png" rel="icon">
<link href="https://www.embase.com/webfiles/images/favicon-32.png?269" sizes="32x32" type="image/png" rel="icon">
<link href="https://www.embase.com/webfiles/images/favicon-96.png?269" sizes="96x96" type="image/png" rel="icon">
<link href="https://www.embase.com/webfiles/images/favicon-16.png?269" sizes="16x16" type="image/png" rel="icon">
<link rel="stylesheet" href="https://www.embase.com/webfiles/css/embase.css?269" type="text/css">
<!--[if IE 9]>
        <link type="text/css" href="https://www.embase.com/webfiles/css/embase_ie9.css?269" rel="stylesheet" />
        <![endif]-->
<!--[if IE 7]>
			<link type="text/css" href="https://www.embase.com/webfiles/css/embase_ie7.css?269" rel="stylesheet" />
			<link rel='stylesheet' href='https://www.embase.com/webfiles/css/ie.css?269' />
		<![endif]-->
<!--[if IE 8]>
			<link type="text/css" href="https://www.embase.com/webfiles/css/embase_ie8.css?269" rel="stylesheet" />
			<link rel='stylesheet' href='https://www.embase.com/webfiles/css/ie.css?269' />
		<![endif]-->
<link media="print" title="printNormal" rel="stylesheet prefetch" href="https://www.embase.com/webfiles/css/print.css?269" type="text/css">
<link media="print" title="printDialog" rel="stylesheet alternate prefetch" href="https://www.embase.com/webfiles/css/print-dialog.css?269" type="text/css">
<link rel="stylesheet subresource" href="https://www.embase.com/webfiles/css/jquery-ui-1.12.1.min.css?269" type="text/css">
<link rel="stylesheet subresource" href="https://www.embase.com/webfiles/css/daterangepicker.css?269" type="text/css">
<!--[if lt IE 9]>
        <script type="text/javascript">
            document.createElement('header');
            document.createElement('nav');
            document.createElement('section');
            document.createElement('article');
            document.createElement('aside');
            document.createElement('footer');
        </script>
        <![endif]-->
<script type="text/javascript">
            var buildVersion = "269";
            window.require = { waitSeconds: 60 };
        </script>
<script src="//assets.adobedtm.com/376c5346e33126fdb6b2dbac81e307cbacfd7935/satelliteLib-97d6536432981efa1bde691c96ad3ab3adb27fdc.js"></script>
<script src="https://assets.adobedtm.com/extensions/EP7b1fa4581fb94dd0961a981af9997765/AppMeasurement.min.js" async=""></script>
<script src="https://assets.adobedtm.com/extensions/EP7b1fa4581fb94dd0961a981af9997765/AppMeasurement_Module_ActivityMap.min.js" async=""></script>
<script>
function targetPageParams() {
  var env = {
    prod: {"at_property": "PROD"},
    dev:  {"at_property": "DEV"}
  }
  return (_satellite &amp;&amp; _satellite.buildInfo &amp;&amp; _satellite.buildInfo.environment &amp;&amp;
          _satellite.buildInfo.environment == 'production') ? env.prod : env.dev;
}

function targetPageParamsAll() {
  var dataElements = [
    "Page - Name",
    "Page - Product Name",
    "Page - Business Unit",
    "Page - Type",
    "Page - Language",
    "Search - Type",
    "Search - Total Results",
    "Search - Sort Type",
    "Search - Feature Used",
    "Visitor - User ID",
    "Visitor - Access Type",
    "Visitor - Account ID",
    "Visitor - Account Name"
  ];
  var targetParams = {};

  for(var i=0; i&lt;dataElements.length; i++) {
    try {
      var ele = _satellite.getVar(dataElements[i]);
      if(ele) {
        targetParams[dataElements[i]] = ele;
      }
    } catch(e){}
  }

  return targetParams;
}
</script>
<script>
document.addEventListener(adobe.target.event.REQUEST_SUCCEEDED, function(e) {
  try {
    window.targetData = window.targetData || {};
    if(!(e.detail &amp;&amp; e.detail.responseTokens)) {
      return;
    }

    e.detail.responseTokens.forEach(function(token) {
      window.targetData[token["activity.id"]] = token;
    });
  } catch(ex) {
    _satellite.logger.log(ex.getMessage());
  }
});
</script>
<script>
(function(apiKey){
    (function(p,e,n,d,o){var v,w,x,y,z;o=p[d]=p[d]||{};o._q=[];
    v=['initialize','identify','updateOptions','pageLoad'];for(w=0,x=v.length;w&lt;x;++w)(function(m){
        o[m]=o[m]||function(){o._q[m===v[0]?'unshift':'push']([m].concat([].slice.call(arguments,0)));};})(v[w]);
        y=e.createElement(n);y.async=!0;y.src='https://cdn.pendo.io/agent/static/'+apiKey+'/pendo.js';
        z=e.getElementsByTagName(n)[0];z.parentNode.insertBefore(y,z);})(window,document,'script','pendo');
})('4d0dfb3d-9fc0-428d-7e95-939e53338845');
</script>
<script>
var pageDataTracker = {
    eventCookieName: 'eventTrack',
    debugCookie: 'els-aa-debugmode',
    debugCounter: 1,
    warnings: [],
    measures: {},
    timeoffset: 0

    ,trackPageLoad: function(data) {
        if (window.pageData &amp;&amp; ((pageData.page &amp;&amp; pageData.page.noTracking == 'true') || window.pageData_isLoaded)) {
            return false;
        }

        if (data) {
            window.pageData = data;
        }

        this.initWarnings();
        if(!(window.pageData &amp;&amp; pageData.page &amp;&amp; pageData.page.name)) {
            console.error('pageDataTracker.trackPageLoad() called without pageData.page.name being defined!');
            return;
        }

        this.processIdPlusData(window.pageData);

        if(document.readyState !== 'loading') {
            this.warnings.push('dtm2');
        } else {
            if(window.pageData &amp;&amp; pageData.page &amp;&amp; !pageData.page.loadTime) {
                pageData.page.loadTime = performance ? Math.round((performance.now())).toString() : '';
            }
        }

        if(window.pageData &amp;&amp; pageData.page) {
            var localTime = new Date().getTime();
            if(pageData.page.loadTimestamp) {
                // calculate timeoffset
                var serverTime = parseInt(pageData.page.loadTimestamp);
                if(!isNaN(serverTime)) {
                    this.timeoffset = pageData.page.loadTimestamp - localTime;
                }
            } else {
                pageData.page.loadTimestamp = localTime;
            }
        }

        this.validateData(window.pageData);

        // measures
        try {
            var resources = performance.getEntriesByType("resource");
            var f = true;
            var dtotal = 0;
            for (var j = 0; j &lt; resources.length; j++) {
                var d = resources[j].duration;
                if (resources[j].name.indexOf('satelliteLib') !== -1) {
                    if(d) {
                        dtotal = dtotal + d;
                    }
                }
                if((resources[j].name.indexOf('satellite-') !== -1) &amp;&amp; d &amp;&amp; f) {
                    f = false;
                    dtotal = dtotal + d;
                }
            }
            this.measures['du'] = Math.round(dtotal).toString();
            this.measures['lt'] = Math.round((performance.now())).toString();
        } catch(e) {
            this.warnings.push('dtm4');
        }

        try {
            var cookieTest = 'a73bp32';
            this.setCookie(cookieTest, cookieTest);
            if(this.getCookie(cookieTest) != cookieTest) {
                this.warnings.push('dtm5');
            }
            this.deleteCookie(cookieTest);
        } catch(e){
            this.warnings.push('dtm5');
        }

        this.registerCallbacks();
        this.setAnalyticsData();

        // handle any cookied event data
        this.getEvents();

        window.pageData_isLoaded = true;

        this.debugMessage('Init - trackPageLoad()', window.pageData);

        _satellite.track('pageLoad');
    }

    ,trackEvent: function(event, data, callback) {
        if(!window.pageData_isLoaded) {
            if(this.isDebugEnabled()) {
                console.log('[AA] pageDataTracker.trackEvent() called without calling trackPageLoad() first.');
            }
            return false;
        }
        if (window.pageData &amp;&amp; pageData.page &amp;&amp; pageData.page.noTracking == 'true') {
            return false;
        }

        if (event) {
            this.initWarnings();
            if(document.readyState !== 'complete') {
                this.warnings.push('dtm3');
            }
            if(event === 'newPage') {
                // auto fillings
                if(data.page &amp;&amp; !data.page.loadTimestamp) {
                    data.page.loadTimestamp = ''+(new Date().getTime() + this.timeoffset);
                }
                this.processIdPlusData(data);
            }

            window.eventData = data ? data : {};
            window.eventData.eventName = event;
            this.handleEventData(event, data);

            if(event === 'newPage') {
                this.validateData(window.pageData);
            }
            this.debugMessage('Event: ' + event, data);

            _satellite.track('eventDispatcher', JSON.stringify({
                eventName: event,
                eventData: window.eventData,
                pageData: window.pageData
            }));
        }

        if (typeof(callback) == 'function') {
            callback.call();
        }
    }

    ,processIdPlusData: function(data) {
        if(data &amp;&amp; data.visitor &amp;&amp; data.visitor.idPlusData) {
            var idPlusFields = ['userId', 'accessType', 'accountId', 'accountName'];
            for(var i=0; i &lt; idPlusFields.length; i++) {
                if(typeof data.visitor.idPlusData[idPlusFields[i]] !== 'undefined') {
                    data.visitor[idPlusFields[i]] = data.visitor.idPlusData[idPlusFields[i]];
                }
            }
            data.visitor.idPlusData = undefined;
        }
    }

    ,validateData: function(data) {
        if(!data) {
            this.warnings.push('dv0');
            return;
        }

        // top 5
        if(!(data.visitor &amp;&amp; data.visitor.accessType)) {
            this.warnings.push('dv1');
        }
        if(data.visitor &amp;&amp; (data.visitor.accountId || data.visitor.accountName)) {
            if(!data.visitor.accountName) {
                this.warnings.push('dv2');
            }
            if(!data.visitor.accountId) {
                this.warnings.push('dv3');
            }
        }
        if(!(data.page &amp;&amp; data.page.productName)) {
            this.warnings.push('dv4');
        }
        if(!(data.page &amp;&amp; data.page.businessUnit)) {
            this.warnings.push('dv5');
        }
        if(!(data.page &amp;&amp; data.page.name)) {
            this.warnings.push('dv6');
        }

        // rp mandatory
        if(data.page &amp;&amp; data.page.businessUnit &amp;&amp; (data.page.businessUnit.toLowerCase().indexOf('els:rp:') !== -1 || data.page.businessUnit.toLowerCase().indexOf('els:rap:') !== -1)) {
            if(!(data.page &amp;&amp; data.page.loadTimestamp)) {
                this.warnings.push('dv7');
            }
            if(!(data.page &amp;&amp; data.page.loadTime)) {
                this.warnings.push('dv8');
            }
            if(!(data.visitor &amp;&amp; data.visitor.ipAddress)) {
                this.warnings.push('dv9');
            }
            if(!(data.page &amp;&amp; data.page.type)) {
                this.warnings.push('dv10');
            }
            if(!(data.page &amp;&amp; data.page.language)) {
                this.warnings.push('dv11');
            }
        }

        // other
        if(data.page &amp;&amp; data.page.environment) {
            var env = data.page.environment.toLowerCase();
            if(!(env === 'dev' || env === 'cert' || env === 'prod')) {
                this.warnings.push('dv12');
            }
        }
        if(data.content &amp;&amp; data.content.constructor !== Array) {
            this.warnings.push('dv13');
        }
    }

    ,initWarnings: function() {
        this.warnings = [];
        try {
            var hdn = document.head.childNodes;
            var libf = false;
            for(var i=0; i&lt;hdn.length; i++) {
                if(hdn[i].src &amp;&amp; (hdn[i].src.indexOf('satelliteLib') !== -1 || hdn[i].src.indexOf('launch') !== -1)) {
                    libf = true;
                    break;
                }
            }
            if(!libf) {
                this.warnings.push('dtm1');
            }
        } catch(e) {
        }
    }

    ,getMessages: function() {
        return this.warnings.join('|');
    }
    ,addMessage: function(message) {
        this.warnings.push(message);
    }

    ,getPerformance: function() {
        var copy = {};
        for (var attr in this.measures) {
            if(this.measures.hasOwnProperty(attr)) {
                copy[attr] = this.measures[attr];
            }
        }

        this.measures = {};
        return copy;
    }

    ,dtmCodeDesc: {
        dtm1: 'satellite-lib must be placed in the &lt;head&gt; section',
        dtm2: 'trackPageLoad() must be placed and called before the closing &lt;/body&gt; tag',
        dtm3: 'trackEvent() must be called at a stage where Document.readyState=complete (e.g. on the load event or a user event)',
        dv1: 'visitor.accessType not set but mandatory',
        dv2: 'visitor.accountName not set but mandatory',
        dv3: 'visitor.accountId not set but mandatory',
        dv4: 'page.productName not set but mandatory',
        dv5: 'page.businessUnit not set but mandatory',
        dv6: 'page.name not set but mandatory',
        dv7: 'page.loadTimestamp not set but mandatory',
        dv8: 'page.loadTime not set but mandatory',
        dv9: 'visitor.ipAddress not set but mandatory',
        dv10: 'page.type not set but mandatory',
        dv11: 'page.language not set but mandatory',
        dv12: 'page.environment must be set to \'prod\', \'cert\' or \'dev\'',
        dv13: 'content must be of type array of objects'
    }

    ,debugMessage: function(event, data) {
        if(this.isDebugEnabled()) {
            console.log('[AA] --------- [' + (this.debugCounter++) + '] Web Analytics Data ---------');
            console.log('[AA] ' + event);
            console.groupCollapsed("[AA] AA Data: ");
            if(window.eventData) {
                console.log("[AA] eventData:\n" + JSON.stringify(window.eventData, true, 2));
            }
            if(window.pageData) {
                console.log("[AA] pageData:\n" + JSON.stringify(window.pageData, true, 2));
            }
            console.groupEnd();
            if(this.warnings.length &gt; 0) {
                console.groupCollapsed("[AA] Warnings ("+this.warnings.length+"): ");
                for(var i=0; i&lt;this.warnings.length; i++) {
                    var error = this.dtmCodeDesc[this.warnings[i]] ? this.dtmCodeDesc[this.warnings[i]] : 'Error Code: ' + this.warnings[i];
                    console.log('[AA] ' + error);
                }
                console.log('[AA] More can be found here: https://confluence.cbsels.com/display/AA/AA+Error+Catalog');
                console.groupEnd();
            }
            console.log("This mode can be disabled by calling 'pageDataTracker.disableDebug()'");
        }
    }

    ,getTrackingCode: function() {
        return window.sessionStorage ? sessionStorage.getItem('dgcid') : '';
    }

    ,isDebugEnabled: function() {
        if(typeof this.debug === 'undefined') {
            this.debug = (document.cookie.indexOf(this.debugCookie) !== -1) || (window.pageData &amp;&amp; pageData.page &amp;&amp; pageData.page.environment &amp;&amp; pageData.page.environment.toLowerCase() === 'dev');
            //this.debug = (document.cookie.indexOf(this.debugCookie) !== -1);
        }
        return this.debug;
    }

    ,enableDebug: function(expire) {
        if (typeof expire === 'undefined') {
            expire = 86400;
        }
        console.log('You just enabled debug mode for Adobe Analytics tracking. This mode will persist for 24h.');
        console.log("This mode can be disabled by calling 'pageDataTracker.disableDebug()'");
        this.setCookie(this.debugCookie, 'true', expire, document.location.hostname);
        this.debug = true;
    }

    ,disableDebug: function() {
        console.log('Debug mode is now disabled.');
        this.deleteCookie(this.debugCookie);
        this.debug = false;
    }

    ,setAnalyticsData: function() {
        if(!(window.pageData &amp;&amp; pageData.page &amp;&amp; pageData.page.productName &amp;&amp; pageData.page.name)) {
            return;
        }
        pageData.page.analyticsPagename = pageData.page.productName + ':' + pageData.page.name;

        var pageEls = pageData.page.name.indexOf(':') &gt; -1 ? pageData.page.name.split(':') : [pageData.page.name];
        pageData.page.sectionName = pageData.page.productName + ':' + pageEls[0];
    }

    ,getEvents: function() {
        pageData.savedEvents = {};
        pageData.eventList = [];

        var val = this.getCookie(this.eventCookieName);
        if (val) {
            pageData.savedEvents = val;
        }

        this.deleteCookie(this.eventCookieName);
    }

    ,handleEventData: function(event, data) {
        var val;
        switch(event) {
            case 'newPage':
                if (data &amp;&amp; typeof(data) === 'object') {
                    for (var x in data) {
                        if(data.hasOwnProperty(x) &amp;&amp; data[x] instanceof Array) {
                            pageData[x] = data[x];
                        } else if(data.hasOwnProperty(x) &amp;&amp; typeof(data[x]) === 'object') {
                            if(!pageData[x]) {
                                pageData[x] = {};
                            }
                            for (var y in data[x]) {
                                if(data[x].hasOwnProperty(y)) {
                                    pageData[x][y] = data[x][y];
                                }
                            }
                        }
                    }
                }
                this.setAnalyticsData();
            case 'saveSearch':
            case 'searchResultsUpdated':
                if (data) {
                    // overwrite page-load object
                    if (data.search &amp;&amp; typeof(data.search) == 'object') {
                        window.eventData.search.resultsPosition = '';
                        pageData.search = pageData.search || {};
                        var fields = ['advancedCriteria', 'criteria', 'currentPage', 'dataFormCriteria', 'facets', 'resultsByType', 'resultsPerPage', 'sortType', 'totalResults', 'type', 'database',
                            'suggestedClickPosition','suggestedLetterCount','suggestedResultCount', 'autoSuggestCategory', 'autoSuggestDetails','typedTerm','selectedTerm', 'channel',
                            'facetOperation', 'details'];
                        for (var i=0; i&lt;fields.length; i++) {
                            if (data.search[fields[i]]) {
                                pageData.search[fields[i]] = data.search[fields[i]];
                            }
                        }
                    }
                }
                this.setAnalyticsData();
                break;
            case 'navigationClick':
                if (data &amp;&amp; data.link) {
                    window.eventData.navigationLink = {
                        name: ((data.link.location || 'no location') + ':' + (data.link.name || 'no name'))
                    };
                }
                break;
            case 'autoSuggestClick':
                if (data &amp;&amp; data.search) {
                    val = {
                        autoSuggestSearchData: (
                            'letterct:' + (data.search.suggestedLetterCount || 'none') +
                            '|resultct:' + (data.search.suggestedResultCount || 'none') +
                            '|clickpos:' + (data.search.suggestedClickPosition || 'none')
                        ).toLowerCase(),
                        autoSuggestSearchTerm: (data.search.typedTerm || ''),
                        autoSuggestTypedTerm: (data.search.typedTerm || ''),
                        autoSuggestSelectedTerm: (data.search.selectedTerm || ''),
                        autoSuggestCategory: (data.search.autoSuggestCategory || ''),
                        autoSuggestDetails: (data.search.autoSuggestDetails || '')
                    };
                }
                break;
            case 'linkOut':
                if (data &amp;&amp; data.content &amp;&amp; data.content.length &gt; 0) {
                    window.eventData.linkOut = data.content[0].linkOut;
                    window.eventData.referringProduct = _satellite.getVar('Page - Product Name') + ':' + data.content[0].id;
                }
                break;
            case 'socialShare':
                if (data &amp;&amp; data.social) {
                    window.eventData.sharePlatform = data.social.sharePlatform || '';
                }
                break;
            case 'contentInteraction':
                if (data &amp;&amp; data.action) {
                    window.eventData.action.name = pageData.page.productName + ':' + data.action.name;
                }
                break;
            case 'searchWithinContent':
                if (data &amp;&amp; data.search) {
                    window.pageData.search = window.pageData.search || {};
                    pageData.search.withinContentCriteria = data.search.withinContentCriteria;
                }
                break;
            case 'contentShare':
                if (data &amp;&amp; data.content) {
                    window.eventData.sharePlatform = data.content[0].sharePlatform;
                }
                break;
            case 'contentLinkClick':
                if (data &amp;&amp; data.link) {
                    window.eventData.action = { name: pageData.page.productName + ':' + (data.link.type || 'no link type') + ':' + (data.link.name || 'no link name') };
                }
                break;
            case 'contentWindowLoad':
            case 'contentTabClick':
                if (data &amp;&amp; data.content) {
                    window.eventData.tabName = data.content[0].tabName || '';
                    window.eventData.windowName = data.content[0].windowName || '';
                }
                break;
            case 'userProfileUpdate':
                if (data &amp;&amp; data.user) {
                    if (Object.prototype.toString.call(data.user) === "[object Array]") {
                        window.eventData.user = data.user[0];
                    }
                }
                break;
            case 'videoStart':
                if (data.video) {
                    data.video.length = parseFloat(data.video.length || '0');
                    data.video.position = parseFloat(data.video.position || '0');
                    s.Media.open(data.video.id, data.video.length, s.Media.playerName);
                    s.Media.play(data.video.id, data.video.position);
                }
                break;
            case 'videoPlay':
                if (data.video) {
                    data.video.position = parseFloat(data.video.position || '0');
                    s.Media.play(data.video.id, data.video.position);
                }
                break;
            case 'videoStop':
                if (data.video) {
                    data.video.position = parseFloat(data.video.position || '0');
                    s.Media.stop(data.video.id, data.video.position);
                }
                break;
            case 'videoComplete':
                if (data.video) {
                    data.video.position = parseFloat(data.video.position || '0');
                    s.Media.stop(data.video.id, data.video.position);
                    s.Media.close(data.video.id);
                }
                break;
            case 'addWebsiteExtension':
                if(data &amp;&amp; data.page) {
                    val = {
                        wx: data.page.websiteExtension
                    }
                }
                break;
        }

        if (val) {
            this.setCookie(this.eventCookieName, val);
        }
    }

    ,registerCallbacks: function() {
        var self = this;
        if(window.usabilla_live) {
            window.usabilla_live('setEventCallback', function(category, action, label, value) {
                if(action == 'Campaign:Open') {
                    self.trackEvent('ctaImpression', {
                        cta: {
                            ids: ['usabillaid:' + label]
                        }
                    });
                } else if(action == 'Campaign:Success') {
                    self.trackEvent('ctaClick', {
                        cta: {
                            ids: ['usabillaid:' + label]
                        }
                    });
                }
            });
        }
    }

    ,getConsortiumAccountId: function() {
        var id = '';
        if (window.pageData &amp;&amp; pageData.visitor &amp;&amp; (pageData.visitor.consortiumId || pageData.visitor.accountId)) {
            id = (pageData.visitor.consortiumId || 'no consortium ID') + '|' + (pageData.visitor.accountId || 'no account ID');
        }

        return id;
    }

    ,getSearchClickPosition: function() {
        if (window.eventData &amp;&amp; eventData.search &amp;&amp; eventData.search.resultsPosition) {
            var pos = parseInt(eventData.search.resultsPosition), clickPos;
            if (!isNaN(pos)) {
                var page = pageData.search.currentPage ? parseInt(pageData.search.currentPage) : '', perPage = pageData.search.resultsPerPage ? parseInt(pageData.search.resultsPerPage) : '';
                if (!isNaN(page) &amp;&amp; !isNaN(perPage)) {
                    clickPos = pos + ((page - 1) * perPage);
                }
            }
            return clickPos ? clickPos.toString() : eventData.search.resultsPosition;
        }
        return '';
    }

    ,getSearchFacets: function() {
        var facetList = '';
        if (window.pageData &amp;&amp; pageData.search &amp;&amp; pageData.search.facets) {
            if (typeof(pageData.search.facets) == 'object') {
                for (var i=0; i&lt;pageData.search.facets.length; i++) {
                    var f = pageData.search.facets[i];
                    facetList += (facetList ? '|' : '') + f.name + '=' + f.values.join('^');
                }
            }
        }
        return facetList;
    }

    ,getSearchResultsByType: function() {
        var resultTypes = '';
        if (window.pageData &amp;&amp; pageData.search &amp;&amp; pageData.search.resultsByType) {
            for (var i=0; i&lt;pageData.search.resultsByType.length; i++) {
                var r = pageData.search.resultsByType[i];
                resultTypes += (resultTypes ? '|' : '') + r.name + (r.results || r.values ? '=' + (r.results || r.values) : '');
            }
        }
        return resultTypes;
    }

    ,getJournalInfo: function() {
        var info = '';
        if (window.pageData &amp;&amp; pageData.journal &amp;&amp; (pageData.journal.name || pageData.journal.specialty || pageData.journal.section || pageData.journal.issn || pageData.journal.issueNumber || pageData.journal.volumeNumber)) {
            var journal = pageData.journal;
            return (journal.name || 'no name') + '|' + (journal.specialty || 'no specialty') + '|' + (journal.section || 'no section') + '|' + (journal.issn || 'no issn') + '|' + (journal.issueNumber || 'no issue #') + '|' + (journal.volumeNumber || 'no volume #');
        }
        return info;
    }

    ,getBibliographicInfo: function(doc) {
        if (!doc || !(doc.publisher || doc.indexTerms || doc.publicationType || doc.publicationRights || doc.volumeNumber || doc.issueNumber || doc.subjectAreas || doc.isbn)) {
            return '';
        }

        var terms = doc.indexTerms ? doc.indexTerms.split('+') : '';
        if (terms) {
            terms = terms.slice(0, 5).join('+');
            terms = terms.length &gt; 100 ? terms.substring(0, 100) : terms;
        }

        var areas = doc.subjectAreas ? doc.subjectAreas.split('&gt;') : '';
        if (areas) {
            areas = areas.slice(0, 5).join('&gt;');
            areas = areas.length &gt; 100 ? areas.substring(0, 100) : areas;
        }

        var biblio	= (doc.publisher || 'none')
            + '^' + (doc.publicationType || 'none')
            + '^' + (doc.publicationRights || 'none')
            + '^' + (terms || 'none')
            + '^' + (doc.volumeNumber || 'none')
            + '^' + (doc.issueNumber || 'none')
            + '^' + (areas || 'none')
            + '^' + (doc.isbn || 'none');

        return this.stripProductDelimiters(biblio).toLowerCase();
    }

    ,getContentItem: function() {
        var docs = window.eventData &amp;&amp; eventData.content ? eventData.content : pageData.content;
        if (docs &amp;&amp; docs.length &gt; 0) {
            return docs[0];
        }
    }

    ,getFormattedDate: function(ts) {
        if (!ts) {
            return '';
        }

        var d = new Date(parseInt(ts) * 1000);

        // now do formatting
        var year = d.getFullYear()
            ,month = ((d.getMonth() + 1) &lt; 10 ? '0' : '') + (d.getMonth() + 1)
            ,date = (d.getDate() &lt; 10 ? '0' : '') + d.getDate()
            ,hours = d.getHours() &gt; 12 ? d.getHours() - 12 : d.getHours()
            ,mins = (d.getMinutes() &lt; 10 ? '0' : '') + d.getMinutes()
            ,ampm = d.getHours() &gt; 12 ? 'pm' : 'am';

        hours = (hours &lt; 10 ? '0' : '') + hours;
        return year + '-' + month + '-' + date;
    }

    ,getVisitorId: function() {
        var orgId = '4D6368F454EC41940A4C98A6@AdobeOrg';
        if(Visitor &amp;&amp; Visitor.getInstance(orgId)) {
            return Visitor.getInstance(orgId).getMarketingCloudVisitorID();
        } else {
            return ''
        }
    }

    ,setProductsVariable: function() {
        var prodList = window.eventData &amp;&amp; eventData.content ? eventData.content : pageData.content
            ,prods = [];
        if (prodList) {
            for (var i=0; i&lt;prodList.length; i++) {
                if (prodList[i].id || prodList[i].type || prodList[i].publishDate || prodList[i].onlineDate) {
                    if (!prodList[i].id) {
                        prodList[i].id = 'no id';
                    }
                    var prodName = (pageData.page.productName || 'xx').toLowerCase();
                    if (prodList[i].id.indexOf(prodName + ':') != 0) {
                        prodList[i].id = prodName + ':' + prodList[i].id;
                    }
                    prodList[i].id = this.stripProductDelimiters(prodList[i].id);
                    var merch = [];
                    if (prodList[i].format) {
                        merch.push('evar17=' + this.stripProductDelimiters(prodList[i].format.toLowerCase()));
                    }
                    if (prodList[i].type) {
                        var type = prodList[i].type;
                        if (prodList[i].accessType) {
                            type += ':' + prodList[i].accessType;
                        }
                        merch.push('evar20=' + this.stripProductDelimiters(type.toLowerCase()));
                    }
                    if(!prodList[i].title) {
                        prodList[i].title = prodList[i].name;
                    }
                    if (prodList[i].title) {
                        merch.push('evar75=' + this.stripProductDelimiters(prodList[i].title.toLowerCase()));
                    }
                    if (prodList[i].breadcrumb) {
                        merch.push('evar63=' + this.stripProductDelimiters(prodList[i].breadcrumb).toLowerCase());
                    }
                    var nowTs = new Date().getTime()/1000;
                    if (prodList[i].onlineDate &amp;&amp; !isNaN(prodList[i].onlineDate)) {
                        if(prodList[i].onlineDate &gt; 32503680000) {
                            prodList[i].onlineDate = prodList[i].onlineDate/1000;
                        }
                        merch.push('evar122=' + this.stripProductDelimiters(pageDataTracker.getFormattedDate(prodList[i].onlineDate)));
                        var onlineAge = Math.floor((nowTs - prodList[i].onlineDate) / 86400);
                        onlineAge = (onlineAge === 0) ? 'zero' : onlineAge;
                        merch.push('evar128=' + onlineAge);
                    }
                    if (prodList[i].publishDate &amp;&amp; !isNaN(prodList[i].publishDate)) {
                        if(prodList[i].publishDate &gt; 32503680000) {
                            prodList[i].publishDate = prodList[i].publishDate/1000;
                        }
                        merch.push('evar123=' + this.stripProductDelimiters(pageDataTracker.getFormattedDate(prodList[i].publishDate)));
                        var publishAge = Math.floor((nowTs - prodList[i].publishDate) / 86400);
                        publishAge = (publishAge === 0) ? 'zero' : publishAge;
                        merch.push('evar127=' + publishAge);
                    }
                    if (prodList[i].onlineDate &amp;&amp; prodList[i].publishDate) {
                        merch.push('evar38=' + this.stripProductDelimiters(pageDataTracker.getFormattedDate(prodList[i].onlineDate) + '^' + pageDataTracker.getFormattedDate(prodList[i].publishDate)));
                    }
                    if (prodList[i].mapId) {
                        merch.push('evar70=' + this.stripProductDelimiters(prodList[i].mapId));
                    }
                    if (prodList[i].relevancyScore) {
                        merch.push('evar71=' + this.stripProductDelimiters(prodList[i].relevancyScore));
                    }
                    if (prodList[i].status) {
                        merch.push('evar73=' + this.stripProductDelimiters(prodList[i].status));
                    }
                    if (prodList[i].previousStatus) {
                        merch.push('evar111=' + this.stripProductDelimiters(prodList[i].previousStatus));
                    }
                    if (prodList[i].entitlementType) {
                        merch.push('evar80=' + this.stripProductDelimiters(prodList[i].entitlementType));
                    }
                    if (prodList[i].recordType) {
                        merch.push('evar93=' + this.stripProductDelimiters(prodList[i].recordType));
                    }
                    if (prodList[i].exportType) {
                        merch.push('evar99=' + this.stripProductDelimiters(prodList[i].exportType));
                    }
                    if (prodList[i].importType) {
                        merch.push('evar142=' + this.stripProductDelimiters(prodList[i].importType));
                    }
                    if (prodList[i].section) {
                        merch.push('evar100=' + this.stripProductDelimiters(prodList[i].section));
                    }
                    if (prodList[i].detail) {
                        merch.push('evar104=' + this.stripProductDelimiters(prodList[i].detail.toLowerCase()));
                    } else if(prodList[i].details) {
                        merch.push('evar104=' + this.stripProductDelimiters(prodList[i].details.toLowerCase()));
                    }
                    if (prodList[i].position) {
                        merch.push('evar116=' + this.stripProductDelimiters(prodList[i].position));
                    }
                    if (prodList[i].publicationTitle) {
                        merch.push('evar129=' + this.stripProductDelimiters(prodList[i].publicationTitle));
                    }
                    if (prodList[i].specialIssueTitle) {
                        merch.push('evar130=' + this.stripProductDelimiters(prodList[i].specialIssueTitle));
                    }
                    if (prodList[i].specialIssueNumber) {
                        merch.push('evar131=' + this.stripProductDelimiters(prodList[i].specialIssueNumber));
                    }
                    if (prodList[i].referenceModuleTitle) {
                        merch.push('evar139=' + this.stripProductDelimiters(prodList[i].referenceModuleTitle));
                    }
                    if (prodList[i].referenceModuleISBN) {
                        merch.push('evar140=' + this.stripProductDelimiters(prodList[i].referenceModuleISBN));
                    }
                    if (prodList[i].volumeTitle) {
                        merch.push('evar132=' + this.stripProductDelimiters(prodList[i].volumeTitle));
                    }
                    if (prodList[i].publicationSection) {
                        merch.push('evar133=' + this.stripProductDelimiters(prodList[i].publicationSection));
                    }
                    if (prodList[i].publicationSpecialty) {
                        merch.push('evar134=' + this.stripProductDelimiters(prodList[i].publicationSpecialty));
                    }
                    if (prodList[i].issn) {
                        merch.push('evar135=' + this.stripProductDelimiters(prodList[i].issn));
                    }
                    if (prodList[i].id2) {
                        merch.push('evar159=' + this.stripProductDelimiters(prodList[i].id2));
                    }
                    if (prodList[i].id3) {
                        merch.push('evar160=' + this.stripProductDelimiters(prodList[i].id3));
                    }
                    if (prodList[i].provider) {
                        merch.push('evar164=' + this.stripProductDelimiters(prodList[i].provider));
                    }
                    if (prodList[i].citationStyle) {
                        merch.push('evar170=' + this.stripProductDelimiters(prodList[i].citationStyle));
                    }

                    var biblio = this.getBibliographicInfo(prodList[i]);
                    if (biblio) {
                        merch.push('evar28=' + biblio);
                    }

                    if (prodList[i].turnawayId) {
                        pageData.eventList.push('product turnaway');
                    }

                    var price = prodList[i].price || '', qty = prodList[i].quantity || '', evts = [];
                    if (price &amp;&amp; qty) {
                        qty = parseInt(qty || '1');
                        price = parseFloat(price || '0');
                        price = (price * qty).toFixed(2);

                        if (window.eventData &amp;&amp; eventData.eventName &amp;&amp; eventData.eventName == 'cartAdd') {
                            evts.push('event20=' + price);
                        }
                    }

                    var type = window.pageData &amp;&amp; pageData.page &amp;&amp; pageData.page.type ? pageData.page.type : '', evt = window.eventData &amp;&amp; eventData.eventName ? eventData.eventName : '';
                    if (type.match(/^CP\-/gi) !== null &amp;&amp; (!evt || evt == 'newPage' || evt == 'contentView')) {
                        evts.push('event181=1');
                    }
                    if (evt == 'contentDownload' || type.match(/^CP\-DL/gi) !== null) {
                        evts.push('event182=1');
                    }
                    if (evt == 'contentExport') {
                        evts.push('event184=1');
                    }
                    if (this.eventFires('recommendationViews')) {
                        evts.push('event264=1');
                    }

                    if(prodList[i].datapoints) {
                        evts.push('event239=' + prodList[i].datapoints);
                    }
                    if(prodList[i].documents) {
                        evts.push('event240=' + prodList[i].documents);
                    }
                    if(prodList[i].discountAmount) {
                        evts.push('event301=' + prodList[i].discountAmount);
                    }

                    prods.push([
                        ''					// empty category
                        ,prodList[i].id		// id
                        ,qty				// qty
                        ,price				// price
                        ,evts.join('|')		// events
                        ,merch.join('|')	// merchandising eVars
                    ].join(';'));
                }
            }
        }

        return prods.join(',');
    }
    ,eventFires: function(eventName) {
        var evt = window.eventData &amp;&amp; eventData.eventName ? eventData.eventName : '';
        if(evt == eventName) {
            return true;
        }
        // initial pageload and new pages
        if((!window.eventData || evt == 'newPage') &amp;&amp; window.pageData &amp;&amp; window.pageData.trackEvents) {
            var tEvents = window.pageData.trackEvents;
            for(var i=0; i&lt;tEvents.length; i++) {
                if(tEvents[i] == eventName) {
                    return true;
                }
            }
        }
        return false;
    }

    ,md5: function(s){function L(k,d){return(k&lt;&lt;d)|(k&gt;&gt;&gt;(32-d))}function K(G,k){var I,d,F,H,x;F=(G&amp;2147483648);H=(k&amp;2147483648);I=(G&amp;1073741824);d=(k&amp;1073741824);x=(G&amp;1073741823)+(k&amp;1073741823);if(I&amp;d){return(x^2147483648^F^H)}if(I|d){if(x&amp;1073741824){return(x^3221225472^F^H)}else{return(x^1073741824^F^H)}}else{return(x^F^H)}}function r(d,F,k){return(d&amp;F)|((~d)&amp;k)}function q(d,F,k){return(d&amp;k)|(F&amp;(~k))}function p(d,F,k){return(d^F^k)}function n(d,F,k){return(F^(d|(~k)))}function u(G,F,aa,Z,k,H,I){G=K(G,K(K(r(F,aa,Z),k),I));return K(L(G,H),F)}function f(G,F,aa,Z,k,H,I){G=K(G,K(K(q(F,aa,Z),k),I));return K(L(G,H),F)}function D(G,F,aa,Z,k,H,I){G=K(G,K(K(p(F,aa,Z),k),I));return K(L(G,H),F)}function t(G,F,aa,Z,k,H,I){G=K(G,K(K(n(F,aa,Z),k),I));return K(L(G,H),F)}function e(G){var Z;var F=G.length;var x=F+8;var k=(x-(x%64))/64;var I=(k+1)*16;var aa=Array(I-1);var d=0;var H=0;while(H&lt;F){Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=(aa[Z]| (G.charCodeAt(H)&lt;&lt;d));H++}Z=(H-(H%4))/4;d=(H%4)*8;aa[Z]=aa[Z]|(128&lt;&lt;d);aa[I-2]=F&lt;&lt;3;aa[I-1]=F&gt;&gt;&gt;29;return aa}function B(x){var k="",F="",G,d;for(d=0;d&lt;=3;d++){G=(x&gt;&gt;&gt;(d*8))&amp;255;F="0"+G.toString(16);k=k+F.substr(F.length-2,2)}return k}function J(k){k=k.replace(/rn/g,"n");var d="";for(var F=0;F&lt;k.length;F++){var x=k.charCodeAt(F);if(x&lt;128){d+=String.fromCharCode(x)}else{if((x&gt;127)&amp;&amp;(x&lt;2048)){d+=String.fromCharCode((x&gt;&gt;6)|192);d+=String.fromCharCode((x&amp;63)|128)}else{d+=String.fromCharCode((x&gt;&gt;12)|224);d+=String.fromCharCode(((x&gt;&gt;6)&amp;63)|128);d+=String.fromCharCode((x&amp;63)|128)}}}return d}var C=Array();var P,h,E,v,g,Y,X,W,V;var S=7,Q=12,N=17,M=22;var A=5,z=9,y=14,w=20;var o=4,m=11,l=16,j=23;var U=6,T=10,R=15,O=21;s=J(s);C=e(s);Y=1732584193;X=4023233417;W=2562383102;V=271733878;for(P=0;P&lt;C.length;P+=16){h=Y;E=X;v=W;g=V;Y=u(Y,X,W,V,C[P+0],S,3614090360);V=u(V,Y,X,W,C[P+1],Q,3905402710);W=u(W,V,Y,X,C[P+2],N,606105819);X=u(X,W,V,Y,C[P+3],M,3250441966);Y=u(Y,X,W,V,C[P+4],S,4118548399);V=u(V,Y,X,W,C[P+5],Q,1200080426);W=u(W,V,Y,X,C[P+6],N,2821735955);X=u(X,W,V,Y,C[P+7],M,4249261313);Y=u(Y,X,W,V,C[P+8],S,1770035416);V=u(V,Y,X,W,C[P+9],Q,2336552879);W=u(W,V,Y,X,C[P+10],N,4294925233);X=u(X,W,V,Y,C[P+11],M,2304563134);Y=u(Y,X,W,V,C[P+12],S,1804603682);V=u(V,Y,X,W,C[P+13],Q,4254626195);W=u(W,V,Y,X,C[P+14],N,2792965006);X=u(X,W,V,Y,C[P+15],M,1236535329);Y=f(Y,X,W,V,C[P+1],A,4129170786);V=f(V,Y,X,W,C[P+6],z,3225465664);W=f(W,V,Y,X,C[P+11],y,643717713);X=f(X,W,V,Y,C[P+0],w,3921069994);Y=f(Y,X,W,V,C[P+5],A,3593408605);V=f(V,Y,X,W,C[P+10],z,38016083);W=f(W,V,Y,X,C[P+15],y,3634488961);X=f(X,W,V,Y,C[P+4],w,3889429448);Y=f(Y,X,W,V,C[P+9],A,568446438);V=f(V,Y,X,W,C[P+14],z,3275163606);W=f(W,V,Y,X,C[P+3],y,4107603335);X=f(X,W,V,Y,C[P+8],w,1163531501);Y=f(Y,X,W,V,C[P+13],A,2850285829);V=f(V,Y,X,W,C[P+2],z,4243563512);W=f(W,V,Y,X,C[P+7],y,1735328473);X=f(X,W,V,Y,C[P+12],w,2368359562);Y=D(Y,X,W,V,C[P+5],o,4294588738);V=D(V,Y,X,W,C[P+8],m,2272392833);W=D(W,V,Y,X,C[P+11],l,1839030562);X=D(X,W,V,Y,C[P+14],j,4259657740);Y=D(Y,X,W,V,C[P+1],o,2763975236);V=D(V,Y,X,W,C[P+4],m,1272893353);W=D(W,V,Y,X,C[P+7],l,4139469664);X=D(X,W,V,Y,C[P+10],j,3200236656);Y=D(Y,X,W,V,C[P+13],o,681279174);V=D(V,Y,X,W,C[P+0],m,3936430074);W=D(W,V,Y,X,C[P+3],l,3572445317);X=D(X,W,V,Y,C[P+6],j,76029189);Y=D(Y,X,W,V,C[P+9],o,3654602809);V=D(V,Y,X,W,C[P+12],m,3873151461);W=D(W,V,Y,X,C[P+15],l,530742520);X=D(X,W,V,Y,C[P+2],j,3299628645);Y=t(Y,X,W,V,C[P+0],U,4096336452);V=t(V,Y,X,W,C[P+7],T,1126891415);W=t(W,V,Y,X,C[P+14],R,2878612391);X=t(X,W,V,Y,C[P+5],O,4237533241);Y=t(Y,X,W,V,C[P+12],U,1700485571);V=t(V,Y,X,W,C[P+3],T,2399980690);W=t(W,V,Y,X,C[P+10],R,4293915773);X=t(X,W,V,Y,C[P+1],O,2240044497);Y=t(Y,X,W,V,C[P+8],U,1873313359);V=t(V,Y,X,W,C[P+15],T,4264355552);W=t(W,V,Y,X,C[P+6],R,2734768916);X=t(X,W,V,Y,C[P+13],O,1309151649);Y=t(Y,X,W,V,C[P+4],U,4149444226);V=t(V,Y,X,W,C[P+11],T,3174756917);W=t(W,V,Y,X,C[P+2],R,718787259);X=t(X,W,V,Y,C[P+9],O,3951481745);Y=K(Y,h);X=K(X,E);W=K(W,v);V=K(V,g)}var i=B(Y)+B(X)+B(W)+B(V);return i.toLowerCase()}
    ,stripProductDelimiters: function(val) {
        if (val) {
            return val.replace(/\;|\||\,/gi, '-');
        }
    }

    ,setCookie: function(name, value, seconds, domain) {
        domain = document.location.hostname;
        var expires = '';
        var expiresNow = '';
        var date = new Date();
        date.setTime(date.getTime() + (-1 * 1000));
        expiresNow = "; expires=" + date.toGMTString();

        if (typeof(seconds) != 'undefined') {
            date.setTime(date.getTime() + (seconds * 1000));
            expires = '; expires=' + date.toGMTString();
        }

        var type = typeof(value);
        type = type.toLowerCase();
        if (type != 'undefined' &amp;&amp; type != 'string') {
            value = JSON.stringify(value);
        }

        // fix scoping issues
        // keep writing the old cookie, but make it expire
        document.cookie = name + '=' + value + expiresNow + '; path=/';

        // now just set the right one
        document.cookie = name + '=' + value + expires + '; path=/; domain=' + domain;
    }

    ,getCookie: function(name) {
        name = name + '=';
        var carray = document.cookie.split(';'), value;

        for (var i=0; i&lt;carray.length; i++) {
            var c = carray[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1, c.length);
            }
            if (c.indexOf(name) == 0) {
                value = c.substring(name.length, c.length);
                try {
                    value = JSON.parse(value);
                } catch(ex) {}

                return value;
            }
        }

        return null;
    }

    ,deleteCookie: function(name) {
        this.setCookie(name, '', -1);
        this.setCookie(name, '', -1, document.location.hostname);
    }

    ,mapAdobeVars: function(s) {
        var vars = {
            pageName		: 'Page - Analytics Pagename'
            ,channel		: 'Page - Section Name'
            ,campaign		: 'Campaign - ID'
            ,currencyCode	: 'Page - Currency Code'
            ,purchaseID		: 'Order - ID'
            ,prop1			: 'Visitor - Account ID'
            ,prop2			: 'Page - Product Name'
            ,prop4			: 'Page - Type'
            ,prop6			: 'Search - Type'
            ,prop7			: 'Search - Facet List'
            ,prop8			: 'Search - Feature Used'
            ,prop12			: 'Visitor - User ID'
            ,prop13			: 'Search - Sort Type'
            ,prop14			: 'Page - Load Time'
            ,prop15         : 'Support - Topic Name'
            ,prop16			: 'Page - Business Unit'
            ,prop21			: 'Search - Criteria'
            ,prop24			: 'Page - Language'
            ,prop25			: 'Page - Product Feature'
            ,prop28         : 'Support - Search Criteria'
            ,prop30			: 'Visitor - IP Address'
            ,prop33         : 'Page - Product Application Version'
            ,prop34         : 'Page - Website Extensions'
            ,prop60			: 'Search - Data Form Criteria'
            ,prop65         : 'Page - Online State'
            ,prop67         : 'Research Networks'

            ,eVar3			: 'Search - Total Results'
            ,eVar7			: 'Visitor - Account Name'
            ,eVar15			: 'Event - Search Results Click Position'
            ,eVar19			: 'Search - Advanced Criteria'
            ,eVar21			: 'Promo - Clicked ID'
            ,eVar22			: 'Page - Test ID'
            ,eVar27			: 'Event - AutoSuggest Search Data'
            ,eVar157		: 'Event - AutoSuggest Search Typed Term'
            ,eVar156		: 'Event - AutoSuggest Search Selected Term'
            ,eVar162		: 'Event - AutoSuggest Search Category'
            ,eVar163		: 'Event - AutoSuggest Search Details'
            ,eVar33			: 'Visitor - Access Type'
            ,eVar34			: 'Order - Promo Code'
            ,eVar39			: 'Order - Payment Method'
            ,eVar41			: 'Visitor - Industry'
            ,eVar42			: 'Visitor - SIS ID'
            ,eVar43			: 'Page - Error Type'
            ,eVar44			: 'Event - Updated User Fields'
            ,eVar48			: 'Email - Recipient ID'
            ,eVar51			: 'Email - Message ID'
            ,eVar52			: 'Visitor - Department ID'
            ,eVar53			: 'Visitor - Department Name'
            ,eVar60			: 'Search - Within Content Criteria'
            ,eVar61			: 'Search - Within Results Criteria'
            ,eVar62			: 'Search - Result Types'
            ,eVar74			: 'Page - Journal Info'
            ,eVar76			: 'Email - Broadlog ID'
            ,eVar78			: 'Visitor - Details'
            ,eVar80         : 'Visitor - Usage Path Info'
            ,eVar102		: 'Form - Name'
            ,eVar103        : 'Event - Conversion Driver'
            ,eVar105        : 'Search - Current Page'
            ,eVar106        : 'Visitor - App Session ID'
            ,eVar107        : 'Page - Secondary Product Name'
            ,eVar117        : 'Search - Database'
            ,eVar126        : 'Page - Environment'
            ,eVar141        : 'Search - Criteria Original'
            ,eVar143        : 'Page - Tabs'
            ,eVar161        : 'Search - Channel'
            ,eVar169        : 'Search - Facet Operation'
            ,eVar173        : 'Search - Details'
            ,eVar174        : 'Campaign - Spredfast ID'
            ,eVar175        : 'Visitor - TMX Device ID'
            ,eVar176        : 'Visitor - TMX Request ID'
            ,eVar148        : 'Visitor - Platform Name'
            ,eVar149        : 'Visitor - Platform ID'
            ,eVar152        : 'Visitor - Product ID'
            ,eVar153        : 'Visitor - Superaccount ID'
            ,eVar154        : 'Visitor - Superaccount Name'
            ,eVar177        : 'Page - Context Domain'
            ,eVar189    : 'Page - Experimentation User Id'
            ,eVar190    : 'Page - Identity User'

            ,list2			: 'Page - Widget Names'
            ,list3			: 'Promo - IDs'
        };

        for (var i in vars) {
            s[i] = s[i] ? s[i] : _satellite.getVar(vars[i]);
        }
    }
};

</script>
<script>_satellite["__runScript1"](function(event, target) {
// force deploy by change
if (window.pageDataTracker) {
    pageDataTracker.customAnalyticsData = function() {
        pendoData = {
            visitor: {},
            account: {}
        };

        if (pageData) {
            // visitor
            if (pageDataTracker) {
                pendoData.visitor.id = pageDataTracker.getVisitorId();
            }
            if (pageData.visitor &amp;&amp; pageData.visitor.userId) {
                pendoData.visitor.webuserID = pageData.visitor.userId;
            }
            if (pageData.visitor &amp;&amp; pageData.visitor.accessType) {
                pendoData.visitor.accessType = pageData.visitor.accessType;
            }
            if (pageData.page &amp;&amp; pageData.page.name &amp;&amp; pageData.page.productName) {
                pendoData.visitor.pageName = pageData.page.productName + ':' + pageData.page.name;
            }
            if (pageData.page &amp;&amp; pageData.page.type) {
                pendoData.visitor.pageType = pageData.page.type;
            }
            if (pageData.page &amp;&amp; pageData.page.productName) {
                pendoData.visitor.pageProduct = pageData.page.productName;
            }
            if (pageData.page &amp;&amp; pageData.page.language) {
                pendoData.visitor.pageLanguage = pageData.page.language;
            }
            if (pageData.page &amp;&amp; pageData.page.environment) {
                pendoData.visitor.pageEnvironment = pageData.page.environment;
            }

            // account
            if (pageData.visitor &amp;&amp; pageData.visitor.accountId) {
                pendoData.account.id = pageData.visitor.accountId;
            }
            if (pageData.visitor &amp;&amp; pageData.visitor.accountName) {
                pendoData.account.name = pageData.visitor.accountName;
            }
        }

        if (pendoData.visitor.id &amp;&amp; pendoData.visitor.pageName &amp;&amp; pendoData.visitor.pageProduct &amp;&amp; pendo) {
            pendo.initialize(pendoData);
            _satellite.notify('pendo initialized with pageData.');
        } else {
            _satellite.notify('couldn\'t initialize pendo.');
        }

    }
}
});</script>
<script defer="" type="text/javascript" data-main="https://www.embase.com/webfiles/javascript/application/app.concat.js?269" src="https://www.embase.com/webfiles/javascript/vendor/require-2.1.9.min.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="https://www.embase.com/webfiles/javascript/application/app.concat.js?269" src="https://www.embase.com/webfiles/javascript/application/app.concat.js?269"></script>
<style type="text/css">
.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
</style>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="https://www.embase.com/webfiles/javascript/vendor/d3.min.js" src="https://www.embase.com/webfiles/javascript/vendor/d3.min.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="pages/FragmentedSearchView" src="https://www.embase.com/webfiles/javascript/application/pages/FragmentedSearchView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/fragmentInput/FragmentInputView" src="https://www.embase.com/webfiles/javascript/application/components/fragmentInput/FragmentInputView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/fragmentInput/FragmentCollection" src="https://www.embase.com/webfiles/javascript/application/components/fragmentInput/FragmentCollection.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/fragmentInput/FragmentView" src="https://www.embase.com/webfiles/javascript/application/components/fragmentInput/FragmentView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/fragmentInput/FragmentModel" src="https://www.embase.com/webfiles/javascript/application/components/fragmentInput/FragmentModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/emtreeSuggestions/EmtreeSuggestionsView" src="https://www.embase.com/webfiles/javascript/application/components/emtreeSuggestions/EmtreeSuggestionsView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/emtreeSuggestions/EmtreeSuggestionsModel" src="https://www.embase.com/webfiles/javascript/application/components/emtreeSuggestions/EmtreeSuggestionsModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="components/emtreeSuggestions/EmtreeSuggestionView" src="https://www.embase.com/webfiles/javascript/application/components/emtreeSuggestions/EmtreeSuggestionView.js?269"></script>
<script src="https://assets.adobedtm.com/4a848ae9611a/7169cad3dbdd/2e323468fdbb/RCe4cc29d2d167492b8c088a4314c62022-source.min.js" async=""></script>
<link type="text/css" rel="stylesheet" charset="UTF-8" href="https://translate.googleapis.com/translate_static/css/translateelement.css">
<script type="text/javascript" charset="UTF-8" src="https://translate.googleapis.com/translate_static/js/element/main.js"></script>
<script type="text/javascript" charset="UTF-8" src="https://translate.googleapis.com/element/TE_20200506_00/e/js/element/element_main.js"></script>
<script src="https://assets.adobedtm.com/4a848ae9611a/7169cad3dbdd/2e323468fdbb/RCae399f9ba1584e1c8bc22f4475109d2f-source.min.js" async=""></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/browse/EmtreePageView" src="https://www.embase.com/webfiles/javascript/application/view/browse/EmtreePageView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/querybuilder/QueryBuilderView" src="https://www.embase.com/webfiles/javascript/application/view/querybuilder/QueryBuilderView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/querybuilder/AddToQueryBuilderView" src="https://www.embase.com/webfiles/javascript/application/view/querybuilder/AddToQueryBuilderView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/emtree/EmtreeWrapperView" src="https://www.embase.com/webfiles/javascript/application/view/emtree/EmtreeWrapperView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="model/querybuilder/QueryBuilderModel" src="https://www.embase.com/webfiles/javascript/application/model/querybuilder/QueryBuilderModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="model/querybuilder/AddToQueryBuilderModel" src="https://www.embase.com/webfiles/javascript/application/model/querybuilder/AddToQueryBuilderModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="model/emtree/EmtreeWrapperModel" src="https://www.embase.com/webfiles/javascript/application/model/emtree/EmtreeWrapperModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/emtree/FindTermView" src="https://www.embase.com/webfiles/javascript/application/view/emtree/FindTermView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="view/emtree/EmtreeWidgetView" src="https://www.embase.com/webfiles/javascript/application/view/emtree/EmtreeWidgetView.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="model/emtree/EmtreeWidgetModel" src="https://www.embase.com/webfiles/javascript/application/model/emtree/EmtreeWidgetModel.js?269"></script>
<script type="text/javascript" charset="utf-8" async="" data-requirecontext="_" data-requiremodule="model/emtree/FindTermModel" src="https://www.embase.com/webfiles/javascript/application/model/emtree/FindTermModel.js?269"></script>
</head>
<!--[if lt IE 7]>  <body class="ie ie6 lte9 lte8 lte7"> <![endif]-->
<!--[if IE 7]>     <body class="ie ie7 lte9 lte8"> <![endif]-->
<!--[if IE 8]>     <body class="ie ie8 lte9"> <![endif]-->
<!--[if IE 9]>     <body class="ie ie9"> <![endif]-->
<!--[if !IE]><!-->
<body style="position: relative; min-height: 100%; top: 0px;">
<!--<![endif]-->
<!-- access navigation -->
<div class="accessNav"><strong>Access navigation</strong>
  <ul>
    <li><a href="#mainWrapper">Go to the content</a></li>
    <li><a href="#navWrapper">Go to main navigation</a></li>
    <li><a href="#footerWrapper">Go to footer navigation</a></li>
  </ul>
</div>
<div id="headerBanner"></div>
<!--// access navigation -->
<div id="overlay" class="overlay"></div>
<div id="abxw"></div>
<div id="a2bxw"></div>
<!--  wrapper -->
<div id="wrapper">
  <div id="main">
    <div id="headerBlock">
      <header class="pageHeader">
        <div id="navWrapper">
          <h1 class="productLogo"><a title="Go to the homepage" href="/#search"><img width="109px" height="23px" alt="Embase" class="new-logo" src="https://www.embase.com/webfiles/images/EmbaseOrange.png"></a>
            <!--<a href="/#search" title="Go to the homepage"><strong>Embase</strong> <sup>&reg;</sup></a>-->
          </h1>
          <nav>
            <div role="navigation" class="mainNav">
              <button class="toggleEmbsNavPanel"><span class="embsNavButton ss-rows"></span></button>
              <div class="elss cf fl-r pos-r helpWrapper"><a title="Go to the helpfiles" href="https://service.elsevier.com/app/home/supporthub/embase/" target="_blank" data="" tabindex="7"><i class="ss-help"></i></a></div>
              <span class="notificationCenter">
              <ul class="notificationCenter">
                <li> <a title="Notifications" href="javascript:void(0)" class="notificationButton"><i class="icon-notification"></i>(1)</a>
                  <div class="flyout">
                    <h2>Notifications</h2>
                    <div class="notification">
                      <h3>Last Content Update</h3>
                      <p>26 Jun 2020 01:48:05 GMT</p>
                    </div>
                  </div>
                </li>
              </ul>
              </span>
              <div id="aePlaceholder">
                <link xmlns:cars="http://cars-services.elsevier.com/cars/server" xmlns:rb="http://RB-services.elsevier.com/resourceBundle/server" xmlns:apps="http://apps-services.elsevier.com/apps/server" href="https://acw.elsevier.com/SSOCore/css/cars/cars_common.css" media="all" type="text/css" rel="stylesheet">
                <div></div>
                <div id="login" class="clearfix">
                  <script type="text/javascript">function flipLogin(button,from){      				if(from == "loginbox"){      				  var inBox = document.getElementById('loginBox').style;      				  var inPlus = document.getElementById('loginPlus').style;      				  var inMinus = document.getElementById('loginMinus').style;      				  if (inBox.display == "none"){      				      inBox.display = 'block';      				      inPlus.display = 'none';      				      inMinus.display = 'block';      				      inPlus.attr('title','Close login');      				  }      				  else {            				inBox.display = 'none';            				inPlus.display = 'block';            				inMinus.display = 'none';            				inPlus.attr('title','Open login');        			  }    			        }			    if(from == "logoutbox"){        			var outBox = document.getElementById('logoutBox').style;        			var outPlus = document.getElementById('logoutPlus').style;        			var outMinus = document.getElementById('logoutMinus').style;        			if (outBox.display == "none"){        			    outBox.display = 'block';        			    outPlus.display = 'none';        			    outMinus.display = 'block';       				} else {       				     outBox.display = 'none';       				     outPlus.display = 'block';       				     outMinus.display = 'none';       				}    			   }			}</script>
                  <ul>
                    <li class="logout"> <span><span style="display:none;float:left;" id="logoutSocialPrContainer"><span id="loginDiv"></span></span><strong><span id="truncateDiv">Palani Elangovan</span></strong><span><a title="Open the Logout Box" class="plus" id="logoutPlus" href="#"><span><img alt="" src="https://www.embase.com/webfiles/images/icon-plus2.gif" id="plusGraphic"></span></a><a title="Close the Logout Box" style="display:none" class="minus" id="logoutMinus" href="#"><span><img alt="" src="https://www.embase.com/webfiles/images/icon-minus2.gif" id="minusGraphic"></span></a></span></span> </li>
                    <li>
                      <div style="display: block;" id="hasjs"> <a title="Logout" id="logoutJs" onclick="logoutServices();" href="javascript:void(0);">Logout</a> </div>
                      <script>						document.getElementById ( "hasjs" ).style.display = "block";					</script>
                      <noscript>
                      &lt;a href="/customer/terminate?http_method_name=DELETE&amp;amp;isClaimingRemoteAccess=false" id="logoutNojs" title="Logout"&gt;Logout&lt;/a&gt;
                      </noscript>
                    </li>
                    <li class="last">
                      <div id="specific_links" class="specific_links">
                        <logout_links xmlns="http://apps-services.elsevier.com/apps/server"> <a href="/customer/settings">Settings</a> </logout_links>
                      </div>
                    </li>
                  </ul>
                </div>
                <div xmlns="" style="display:none;margin-top:2px;" class="bg4" id="logoutBox">
                  <form method="delete" action="/customer/terminate" name="logOutForm">
                    <div class="orgName">
                      <p class="marginB5 Bold">EmbaseGeneral,						SPi</p>
                    </div>
                    <input type="hidden" value="DELETE" name="http_method_name">
                    <input type="hidden" value="FALSE" name="isClaimingRemoteAccess">
                  </form>
                  <p class="manraenabledtext"> <a title="Remote access activation" href="/customer/authenticate/manra?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9">Remote access activation</a> </p>
                  <script type="text/javascript">						if('' !=""){				gigya.socialize.showLoginUI({				height: 80				,width: 350				,showTermsLink:false 				,hideGigyaLink:true 				,buttonsStyle: 'standard' 				,enabledProviders:''				,showWhatsThis: false 				,containerID:'loginDiv'				,cid:''				,sessionExpiration:0				,redirectURL:''				,authCodeOnly:'true'				,authFlow:'redirect'				,onLoad:function(){logoutgigyaCheck();}				});			}			function logoutgigyaCheck(){					if('' !=""){						var social_divName = 'loginDiv';						var _gig_social_proName = '';						var x = document.getElementById(social_divName).innerHTML;						var y = x.replace('gigid','id');						document.getElementById(social_divName).innerHTML = '';						document.getElementById(social_divName).innerHTML = y;						if(document.getElementById(_gig_social_proName) || document.getElementById(_gig_social_proName.toLowerCase())){							document.getElementById(_gig_social_proName).id="logoutsocialProvider";							var z = document.getElementById("logoutsocialProvider").innerHTML.replace(new RegExp("&lt;div", "ig"), '&lt;div id="Logoutcustomid"');							document.getElementById(social_divName).innerHTML = '';							document.getElementById(social_divName).innerHTML = z;							var urlbg = document.getElementById('Logoutcustomid').style.							backgroundImage.replace('url(','').replace(')','').replace('"','');							urlbg = urlbg.replace('"','');							document.getElementById(social_divName).innerHTML = '';							document.getElementById(social_divName).innerHTML = '&lt;img src="'+urlbg+'" hieght="15px" width="15px"&gt;&lt;/div&gt;';							document.getElementById(social_divName).style.width = '15px';							document.getElementById(social_divName).style.height = '15px';							document.getElementById('logoutSocialPrContainer').style.display='block';							document.getElementById('loginDiv').style.cssFloat ='left';							document.getElementById('loginDiv').style.marginRight='5px';							checkEditProfileFunction();						}else{							window.setTimeout(logoutgigyaCheck,250);						}					}}					function checkEditProfileFunction(){						if(typeof gigyaLoadIcon == 'function'){								gigyaLoadIcon();							}					}										function logoutServices(){						document.logOutForm.submit();					}							</script>
                </div>
              </div>
              <ul class="standard">
                <li><a title="Search Embase" href="/#search" data="search" tabindex="2" class="menuItem searchContext">Search</a></li>
                <li><a title="Browse Emtree" href="/#emtreeSearch/default" data="emtreeSearch" class="menuItem active">Emtree</a></li>
                <li><a title="Browse Journals" href="/#journalsSearch/default" data="journalsSearch" class="menuItem">Journals</a></li>
                <li><a title="Session results page" href="/#advancedSearch/resultspage" data="resultSearch" tabindex="4" class="menuItem hasNoChildren searchContext">Results</a></li>
                <li><a title="Embase user tools" href="/#clipboard/default" data="tools" tabindex="5" class="menuItem">My tools</a></li>
              </ul>
            </div>
            <script type="text/javascript">var googleTranslateElementInit = function(){},embHeaderCallbacks = [];function asyncLoadGT(){var googleScripts = document.createElement('script');googleScripts.type = 'text/javascript';googleScripts.async = true;googleScripts.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";var pageBody = document.getElementsByTagName('body')[0];pageBody.appendChild(googleScripts);}function toggleGT() {if (window.location.pathname !== '/login' &amp;&amp; sessionStorage['googleTranslateEnabled'] !== 'false') {googleTranslateElementInit = function () {new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');};asyncLoadGT();}}embHeaderCallbacks.push(toggleGT);if (window.location.href.indexOf('viewrecord') !== -1) {toggleGT();}/*---------------------headerPanel----------------*/$(document).on('click','.toggleEmbsNavPanel', toggleEmbsNavPanel);$(document).on('click','.embsNavLinks a', toggleEmbsNavPanel);function toggleEmbsNavPanel() {var panel = $('.embsNavigationPanel'),gt;if (panel.is(':visible')) {panel.hide();gt = $('#google_translate_element').detach();$('#pageName').append(gt);}else {if (!$('.embsNavigationPanel').find('#google_translate_element').length) {gt = $('#google_translate_element').detach();$('.embsNavPanContent').append(gt);}panel.show();}}$(document).on('click', '.embsPanel-heading', function (e) {var element = $(e.currentTarget),content = element.siblings('.embsPanel-content'),button = element.find('.heading-button');if (content.is(':visible')) {content.hide();button.removeClass('rotate180');element.removeClass('active');}else {content.show();element.addClass('active');button.addClass('rotate180');}});$.getJSON("/rest/pagedata/visitor" + '?_=' + new Date().getTime(), function(data){if(data.firstName) {$('.embsNavigationPanel .userName').text(data.firstName + ' ' + data.lastName);$('.embsNavigationPanel .embsLogin').hide();}else if (data.accessType &amp;&amp; data.accessType.indexOf('SHIBBOLETH') !== -1) {$('.embsNavigationPanel .userName').text('Anonymous user');$('.embsNavigationPanel .embsLogin').hide();}else {$('.embsNavigationPanel .embsLogout').hide();}});/*----------------------------- Page title------------------------------*/$(function (){var PageNames;PageNames = {'search/results': 'Record Details','picoSearch': 'Pico Search','PVwizard/default': 'PV Wizard - Drug Name','drugName': 'PV Wizard - Drug Name','alternativeDrugNames': 'PV Wizard - Alternative Drug Names','adverseDrugReactions': 'PV Wizard - Adverse Drug Reactions','specialSituations': 'PV Wizard - Special Situations','humanLimit': 'PV Wizard - Human Limit','drugSearch': 'Drug Search','resultspage': 'Results','advancedSearch': 'Advanced Search','diseaseSearch': 'Disease Search','deviceSearch': 'Device Search','articleSearch': 'Article Search','emtreeSearch': 'Browse Emtree','journalsSearch': 'Browse Journals','authorsSearch': 'Author Search','search': 'Quick Search','quickSearch/default': 'Quick Search','savedclipboards': 'Saved Clipboards','clipboard/saved': 'Saved Clipboard','clipboard': 'Clipboard','alerts/upload': 'Email Alerts Import Status','alerts': 'Email Alerts','saved': 'Saved Searches'};var pageHashes = Object.keys(PageNames),pageLocation = location.hash || location.pathname,pageCount = pageHashes.length,pageHash,pageName='';for (p = 0; p &lt; pageCount; p++) {pageHash = pageHashes[p];if (pageLocation.indexOf(pageHash) !== -1) {pageName = PageNames[pageHash];break;}}if (pageName) {document.getElementById("embsPageTitle").innerHTML = pageName;var gt = $('#google_translate_element').detach();$('#pageName').append(gt);}else {document.getElementById("pageName").style = "display:none";}});</script>
          </nav>
        </div>
      </header>
      <div id="pageName" class="pageName clearfix"><span id="embsPageTitle" class="pageTitle">Browse Emtree</span>
        <div id="google_translate_element">
          <div class="skiptranslate goog-te-gadget" dir="ltr" style="">
            <div id=":0.targetLanguage" style="white-space: nowrap;" class="goog-te-gadget-simple"><img src="https://www.google.com/images/cleardot.gif" class="goog-te-gadget-icon" alt="" style="background-image: url(&quot;https://translate.googleapis.com/translate_static/img/te_ctrl3.gif&quot;); background-position: -65px 0px;"><span style="vertical-align: middle;"><a aria-haspopup="true" class="goog-te-menu-value" href="javascript:void(0)"><span>Select Language</span><img width="1" height="1" src="https://www.google.com/images/cleardot.gif" alt=""><span style="border-left: 1px solid rgb(187, 187, 187);">&#8203;</span><img width="1" height="1" src="https://www.google.com/images/cleardot.gif" alt=""><span style="color: rgb(118, 118, 118);" aria-hidden="true">▼</span></a></span></div>
          </div>
        </div>
      </div>
      <div id="horizontalNav">
        <div></div>
      </div>
      <div class="embsNavigationPanel">
        <aside class="embsNavPanContent">
          <header class="clearfix">
            <div class="userName">Palani Elangovan</div>
            <div class="toggleBtnContainer">
              <button class="toggleEmbsNavPanel"><span class="embsNavButton ss-columns"></span></button>
            </div>
          </header>
          <ul class="embsNavLinks">
            <li><a title="Login to Embase" href="/login" class="embsLogin" style="display: none;">Login</a></li>
            <div class="embsPanel">
              <div class="embsPanel-heading clearfix"><span class="heading-title">Search</span><span class="heading-button embs-icon embs-navigateDownWhite"></span></div>
              <div class="embsPanel-content">
                <ul class="embsNavLinks">
                  <li><a title="Quick search" href="/#search">Quick</a></li>
                  <li><a title="PICO search" href="/picoSearch/">PICO</a></li>
                  <li><a title="PV Wizard" href="/#PVwizard/default">PV Wizard</a></li>
                  <li><a title="Medical device" href="/search/medicalDevice">Medical device</a></li>
                  <li><a title="Advanced search" href="/#advancedSearch/default">Advanced</a></li>
                  <li><a title="Drug search" href="/#drugSearch/default">Drug</a></li>
                  <li><a title="Disease search" href="/#diseaseSearch/default">Disease</a></li>
                  <li><a title="Device search" href="/#deviceSearch/default">Device</a></li>
                  <li><a title="Article search" href="/search/article">Article</a></li>
                  <li><a title="Authors search" href="/#authorsSearch/default">Authors</a></li>
                </ul>
              </div>
            </div>
            <li><a title="Browse Emtree" href="/#emtreeSearch/default">Emtree</a></li>
            <li><a title="Browse Journals" href="/#journalsSearch/default">Journals</a></li>
            <li><a tabindex="4" title="Session results page" href="/#advancedSearch/resultspage">Results</a></li>
            <div class="embsPanel">
              <div class="embsPanel-heading clearfix"><span class="heading-title">My tools</span><span class="heading-button embs-icon embs-navigateDownWhite"></span></div>
              <div class="embsPanel-content">
                <ul class="embsNavLinks">
                  <li><a title="Clipboard page" href="/#clipboard/default">Clipboard</a></li>
                  <li><a title="Saved clipboard page" href="/#savedclipboards/default">Saved Clipboards</a></li>
                  <li><a title="Email alerts page" href="/#alerts/default">Email Alerts</a></li>
                  <li><a title="Saved searches page" href="/#saved/default">Saved Searches</a></li>
                  <li><a title="Preferences page" href="/preferences">Preferences</a></li>
                </ul>
              </div>
            </div>
            <li><a class="embsLogout" title="Logout" onclick="logoutServices();" href="javascript:void(0);">Logout</a></li>
          </ul>
        </aside>
      </div>
    </div>
    <!-- Format inner -->
    <div class="formatInner clearfix ">
      <!-- content -->
      <div class="content" id="contentBlock">
        <div class="feedbackBar" id="searchFeedback" style="display: none;"></div>
        <!-- Row1 -->
        <div id="searchResultSearchBLock" style="display: none;">
          <!-- Row2 -->
          <div class="colRightRow2 clearfix">
            <div id="resultsRightRow2" class="col">
              <div id="ppInteropWrapper" style="display: none;"></div>
            </div>
            <div id="resultsLeftRow2">
              <div id="resultBox" class="search-results clearfix"></div>
              <div class="search-results-footer"></div>
            </div>
          </div>
        </div>
        <div class="content-wrap" style="display: none;">
          <!-- START OF CONCRETE THING -->
          <div id="resultsTwoCol" class="columns cf">
            <!-- col1 -->
            <div id="filterBlock" class="filterBlock" style="display: none;">
              <div id="filters"></div>
            </div>
            <!--// col1 -->
            <!-- col2 -->
            <div id="resultsRight" class="columnCentered">
              <!--// Row1 -->
              <div class="resultsHistory sessionResults" id="searchHistoryBlock" style="display: none;"> </div>
              <!-- Row2 -->
              <div id="searchResultListBLock">
                <div id="ppInteropWrapper"></div>
                <div id="ResultList" class="" style="display: none;">
                  <ul id="recordsFound">
                  </ul>
                </div>
              </div>
            </div>
            <!--// col2 -->
          </div>
        </div>
        <div class="content-wrap notranslate" id="emtreePage">
          <article class="formWrapperCentered">
            <div class="formWrapper">
              <div id="queryBuilder">
                <fieldset style="margin-bottom: 20px;" class="searchQueryEmtree">
                <h3 style="margin-bottom: 5px; color: #202020"><a style="margin-left: 0;" class="textButton" id="toggleQueryBuilder">Query Builder</a>▼</h3>
                <label style="margin-bottom: 5px;" for="searchQuery">Build a multi-term search query</label>
                <div style="display: none;" id="queryBuilderContainer">
                  <textarea class="text emtreeSearchField" id="searchQuery"></textarea>
                  <a class="basebutton emb-btn-primary searchButtonRightMargin" id="searchQueryBtn"><span class="emb-button-text">Search</span></a><a class="basebutton emb-btn-secondary" id="takeQueryToSearchBtn"><span class="emb-button-text">Take to Advanced Search</span></a></div>
                </fieldset>
              </div>
              <div id="emtreeWrapper">
                <!-- Tabs -->
                <div class="clearfix">
                  <ul style="margin-bottom: 20px;" class="tabsNavEmtree">
                    <li class="selected"><a style="cursor: pointer;" data-tab="findTerm">Find Term</a></li>
                    <li><a style="cursor: pointer;" data-tab="browseFacet">Browse by Facet</a></li>
                  </ul>
                </div>
                <!-- Container for find term -->
                <div id="findTerm">
                  <div>Type word or phrase (without quotes)</div>
                  <div class="findInput">
                    <input type="text" autocomplete="off" value="" id="findTermInput">
                    <div class="findTermSuggestions">
                      <div class="emtreeSuggestionsView noFreeTerm"></div>
                    </div>
                    <button tabindex="-1" type="button" id="clean-findTerm-input" class="clearButton">X</button>
                  </div>
                  <div style="height: 36px" class="clearfix"><a class="emb-btn-primary basebutton emb-btn-disabled" id="findTermBtn"><span class="emb-button-text">Find Term</span></a></div>
                  <div style="margin-top: 25px;" class="findTermResults"></div>
                </div>
                <!-- Container for emtree widget -->
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
    <div id="footerWrapper" style="display: block;">
      <!-- Footer -->
      <footer id="pageFooter">
        <div class="textButtonFooter footerButton">Reed Elsevier</div>
        <div class="textButton footerCloseButton">Close</div>
        <div class="footerContent clearfix">
          <nav id="footerNav">
            <div>
              <h2>Life Science Solutions</h2>
              <ul>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/professional-services">Professional Services&trade;</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/pathway-studio-biological-research">Pathway Studio&trade;</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/reaxys/reaxys-medicinal-chemistry">Reaxys&reg; Medicinal Chemistry</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/reaxys">Reaxys&reg;</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/pharmapendium-clinical-data">PharmaPendium&reg;</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/embase-biomedical-research">Embase&reg;</a></li>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/quosa-scientific-literature">QUOSA&trade;</a></li>
              </ul>
            </div>
            <div>
              <h2>Support</h2>
              <ul>
                <li><a target="_blank" href="https://service.elsevier.com/app/home/supporthub/embase/">Help</a></li>
                <li><a target="_blank" href="https://service.elsevier.com/app/answers/detail/a_id/15728/supporthub/embase/">Webinars</a></li>
                <li><a target="_blank" href="https://service.elsevier.com/app/answers/list/c/10545/supporthub/embase/">Guides and videos</a></li>
                <li><a target="_blank" href="https://service.elsevier.com/app/contact/supporthub/embase/">Contact Support Team</a></li>
              </ul>
            </div>
            <div>
              <h2>Product</h2>
              <ul>
                <li><a target="_blank" href="https://www.elsevier.com/solutions/embase-biomedical-research" class="last-child">About Embase</a></li>
                <li><a target="_blank" href="https://service.elsevier.com/app/answers/detail/a_id/15728/supporthub/embase/" class="last-child">News</a></li>
                <li><a target="_blank" href="https://service.elsevier.com/app/home/supporthub/embase/" class="last-child">Upcoming webinars</a></li>
                <li><a target="_blank" href="http://www.elsevier.com/legal/elsevier-website-terms-and-conditions" class="last-child">Terms and Conditions</a></li>
                <li><a target="_blank" href="http://www.elsevier.com/legal/privacy-policy" class="last-child">Privacy Policy</a></li>
              </ul>
            </div>
            <div class="last-child subscribtion">
              <h2>Newsletter</h2>
              <p>Subscribe to the quarterly Embase newsletter to receive the latest updates, search tips and Embase conferences.</p>
              <a href="https://www.elsevier.com/solutions/embase-biomedical-research/newsletter" target="_blank" class="emb-btn-small emb-btn-secondary basebutton"><span>Subscribe</span><span class="ss-navigateright"></span></a></div>
          </nav>
          <section class="disclaimer">
            <div class="els-footer-logo"><a href="http://www.elsevier.com/"><img src="https://www.embase.com/webfiles/images/elsevier-logo.png"></a></div>
            <p>Copyright &copy; 2020 Elsevier Limited except certain content provided by third parties. Embase is a trademark of Elsevier Limited.</p>
            <p class="cookiesNotice">We use cookies to help provide and enhance our service and tailor content. By continuing you agree to the <a target="blank" href="https://www.elsevier.com/solutions/embase-biomedical-research/learn-and-support/cookies">use of cookies</a>.</p>
          </section>
          <section class="companyLogo"><a class="relxGroupLogo" target="_blank" href="http://www.relxgroup.com"></a></section>
        </div>
      </footer>
      <!--// Footer -->
    </div>
  </div>
  <!--//  wrapper -->
  <div onmouseout="hideInfoTip(event)" style="display:none" class="infoTip" id="tip">
    <!-- -->
  </div>
  <!-- Process time: 0.43 mSec. -->
</div>
<script language="JavaScript">
    let urlsWithCSRFTokens = {
        //TODO: refactor: several sources of CSRF protection urls list
        //TODO: keep url white list or url black list, not both
        //TODO: Remove CSRFTokensController - it is kind of vulnerability
        '/customer/profile' : '/customer/profile?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9',
'/customer/profile/association' : '/customer/profile/association?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9',
'/customer/authenticate/manra' : '/customer/authenticate/manra?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9',
'/customer/authenticate' : '/customer/authenticate?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9',
'/customer/profile/display' : '/customer/profile/display?org.apache.catalina.filters.CSRF_NONCE=470C2E3A9B9C9E1CE84FE90180AD10E9'
    };

    window.sessionStorage.setItem('EMBS.csrfTokens', JSON.stringify(urlsWithCSRFTokens));

    function attributeUpdater(elements, attributeName) {
        for (var i = 0; i &lt; elements.length; i++) {
            var element = elements[i];
            var attributeValue = element.getAttribute(attributeName);
            if (!attributeValue) {
                continue;   
            }
            var servletPath = attributeValue;
            var queryPart = "";
            if (attributeValue.indexOf("?") &gt;= 0) {
                servletPath = attributeValue.substr(0, attributeValue.indexOf("?"));
                queryPart = attributeValue.substr(attributeValue.indexOf("?") + 1);
            }
            var csrfToken = urlsWithCSRFTokens[servletPath];
            if (csrfToken !== undefined &amp;&amp; csrfToken.indexOf('?') &gt;= 0) {
                element.setAttribute(attributeName, csrfToken + (queryPart &amp;&amp; ("&amp;" + queryPart)));
            }
        }
    }

    function paneUpdater(pane) {
        if (pane) {
            var links = pane.getElementsByTagName("a");
            attributeUpdater(links, "href");
            var forms = pane.getElementsByTagName("form");
            attributeUpdater(forms, "action");
        }
    }

    // JQuery $(document).ready replacement
    function ready(fn) {
        if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading") {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
</script>
<script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"errorBeacon":"bam.nr-data.net","licenseKey":"3c836f97d2","agent":"","beacon":"bam.nr-data.net","applicationTime":2,"applicationID":"631471793","transactionName":"blRRMUVQC0JWVhJaV1ceYBFFRBFCdlYSWldXHlAKWh8AXURQEFpdSx9fEEBQDh9WRRZAFlxcUQREVEtCUkcQX11NQh0LVkcMVlZBD1xWF3NSBlxTCl9ScQNVWUxdRyRURQxeWQ==","queueTime":0}</script>
<ul class="vakata-context">
</ul>
<div id="jstree-marker" style="display: none;">&nbsp;</div>
<div class="feedbackBox" data-action="feedbackBox">
  <div data-action="feedbacBoxClass">
    <div class="icon" data-action="feedbacBoxIcon"><span data-action="feedbackMessage" class="text"></span></div>
    <div class="close_button" data-action="box-control"></div>
  </div>
</div>
<div class="daterangepickerContainer"></div>
<script type="text/javascript" async="" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div dir="ltr" class="skiptranslate" id="goog-gt-tt">
  <div style="padding: 8px;">
    <div>
      <div class="logo"><img width="20" height="20" alt="Google Translate" src="https://www.gstatic.com/images/branding/product/1x/translate_24dp.png"></div>
    </div>
  </div>
  <div style="padding: 8px; float: left; width: 100%;" class="top">
    <h1 class="title gray">Original text</h1>
  </div>
  <div style="padding: 8px;" class="middle">
    <div class="original-text"></div>
  </div>
  <div style="padding: 8px;" class="bottom">
    <div class="activity-links"><span class="activity-link">Contribute a better translation</span><span class="activity-link"></span></div>
    <div class="started-activity-container">
      <hr style="color: #CCC; background-color: #CCC; height: 1px; border: none;">
      <div class="activity-root"></div>
    </div>
  </div>
  <div class="status-message" style="display: none;"></div>
</div>
<script>_satellite["__runScript2"](function(event, target) {
pageDataTracker.mapAdobeVars(s);
});</script>
<div class="goog-te-spinner-pos">
  <div class="goog-te-spinner-animation">
    <svg viewBox="0 0 66 66" height="96px" width="96px" class="goog-te-spinner" xmlns="http://www.w3.org/2000/svg">
      <circle r="30" cy="33" cx="33" stroke-linecap="round" stroke-width="6" fill="none" class="goog-te-spinner-path"/>
    </svg>
  </div>
</div>
<iframe frameborder="0" class="goog-te-menu-frame skiptranslate" title="Language Translate Widget" style="visibility: visible; box-sizing: content-box; width: 1026px; height: 285px; display: none;"></iframe>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-8-button" id="ui-id-8-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-9-button" id="ui-id-9-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-10-button" id="ui-id-10-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-11-button" id="ui-id-11-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-12-button" id="ui-id-12-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-13-button" id="ui-id-13-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<div class="ui-selectmenu-menu ui-front">
  <ul aria-hidden="true" aria-labelledby="ui-id-14-button" id="ui-id-14-menu" role="listbox" tabindex="0" class="ui-menu ui-corner-bottom ui-widget ui-widget-content fragmentedMenu">
  </ul>
</div>
<script>_satellite["__runScript3"](function(event, target) {
_satellite.logger.log("eventDispatcher: clearing tracking state");try{s.events="",s.linkTrackVars="",s.linkTrackEvents=""}catch(e){_satellite.logger.log("eventDispatcher: s object - could not reset state.")}try{dispatcherData=JSON.parse(event.detail),window.ddqueue=window.ddqueue||[],window.ddqueue.push(dispatcherData),window.eventData=dispatcherData.eventData,window.pageData=dispatcherData.pageData,_satellite.track(dispatcherData.eventName)}catch(e){_satellite.logger.log("eventDispatcher: exception"),_satellite.logger.log(e)}
});</script>
</body>
</html>

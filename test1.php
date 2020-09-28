<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>PDFObject Example: PDF.js (forced)</title>
<!-- site analytics, unrelated to any example code presented on this page -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-1394306-6"></script>
<script src="../js/analytics.js"></script><!-- /site analytics -->

<!--
	This example created for PDFObject.com by Philip Hutchison (www.pipwerks.com)
	Copyright 2016-2018, MIT-style license http://pipwerks.mit-license.org/
	Documentation available at http://pdfobject.com
	Source code available at https://github.com/pipwerks/PDFObject
-->

<!-- CSS for basic page styling, not related to example -->
<link href="../css/examples.css" rel="stylesheet" />

<style>
/*
PDFObject appends the classname "pdfobject-container" to the target element.
This enables you to style the element differently depending on whether the embed was successful.
In this example, a successful embed will result in a large box.
A failed embed will not have dimensions specified, so you don't see an oddly large empty box.
*/

.pdfobject-container {
	width: 100%;
	max-width: 600px;
	height: 600px;
	margin: 2em 0;
}

.pdfobject { border: solid 1px #666; }
#results { padding: 1rem; }
.hidden { display: none; }
.success { color: #4F8A10; background-color: #DFF2BF; }
.fail { color: #D8000C; background-color: #FFBABA; }
</style>

</head>

<body>
<h1>PDFObject Example: PDF.js (forced)</h1>

<p>Important: PDFObject does not verify that PDF.js is present and functional, it assumes you have correctly configured your PDF.js viewer and are not trying to load PDFs from a different domain.</p>

<embed src="https://embases3.s3.ap-southeast-1.amazonaws.com/Embase/Production/UAT/Orders_Received/2020/08_Aug/01-Aug-2020/43665130_1/AdditionalItemFile/2004800977.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVG4SM7ZRFYM6REUS%2F20200910%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20200910T122908Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1200&X-Amz-Signature=4de43a5ac1edbe6f44f11f42b5cfe048975cb995417eb10124f76da1b779c725"></embed>

<div id="results" class="hidden"></div>

<div id="pdf"></div>

<div class="pdfobject-com"><a href="http://pdfobject.com">PDFObject.com</a></div>

<script src="https://pdfobject.com/js/pdfobject.min.js"></script>
<script>
var options = {
	pdfOpenParams: {
		navpanes: 0,
		toolbar: 0,
		statusbar: 0,
		view: "FitV",
		pagemode: "thumbs",
		page: 2
	},
	forcePDFJS: true,
	PDFJS_URL: "https://pdfobject.com/pdfjs/web/viewer.html"
};

var myPDF = PDFObject.embed("https://embases3.s3.ap-southeast-1.amazonaws.com/Embase/Production/UAT/Orders_Received/2020/08_Aug/01-Aug-2020/43665130_1/AdditionalItemFile/2004800977.pdf?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIAVG4SM7ZRFYM6REUS%2F20200910%2Fap-southeast-1%2Fs3%2Faws4_request&X-Amz-Date=20200910T122908Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1200&X-Amz-Signature=4de43a5ac1edbe6f44f11f42b5cfe048975cb995417eb10124f76da1b779c725", "#pdf", options);

var el = document.querySelector("#results");
el.setAttribute("class", (myPDF) ? "success" : "fail");
el.innerHTML = (myPDF) ? "PDFObject was successful!" : "Uh-oh, the embed didn't work.";
</script>

</body>
</html>

<!-- PWA -->
<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=yyL6zP53392">
<link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png?v=yyL6zP53392">
<link rel="manifest" href="/site.webmanifest?v=yyL6zP53391" crossorigin="use-credentials">
<link rel="shortcut icon" href="/favicon.ico?v=yyL6zP53391">
<meta name="apple-mobile-web-app-title" content="Meine Subscribe">
<meta name="application-name" content="Meine Subscribe">
<meta name="msapplication-TileColor" content="#81a540">
<meta name="theme-color" content="#ffffff">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="yes">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="#81a540">
<meta name="apple-mobile-web-app-title" content="Meine Subscribe">

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function(registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>

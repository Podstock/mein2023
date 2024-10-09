{
    "name": "Meine Subscribe",
    "short_name": "Meine Subscribe",
    "icons": [
        {
            "src": "/android-chrome-192x192.png?v=yyL6zP5333",
            "sizes": "192x192",
            "type": "image/png"
        },
        {
            "src": "/android-chrome-512x512.png?v=yyL6zP5333",
            "sizes": "512x512",
            "type": "image/png"
        }
    ],
    "theme_color": "#ffffff",
    "background_color": "#ffffff",
@guest
    "start_url": "{{url('/')}}",
@else
    "start_url": "{{url('/pretix/login/'.auth()->user()->token)}}",
@endguest
    "display": "standalone",
    "scope": "https://meine.subscribe.de/"
}

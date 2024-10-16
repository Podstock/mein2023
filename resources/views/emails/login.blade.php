@component('mail::message')
Hallo {{$user->name}},

unter folgender Adresse kannst du dich in Meine Subscribe:

@component('mail::button', ['url' => 'https://meine.subscribe.de/pretix/login/'. $user->token ])
Einloggen
@endcomponent

Das wird dieses Jahr die zentrale Anlaufstelle vom Event.

Aktuell sind folgenden Funktionen enthalten:

- Profil- und Projektverwaltung (Unter Profile oben rechts)
- Online Chat
- Teilnehmer\*innen Liste
- Pinnwand
- Fahrplan

Leider musst du dein Profil-Foto und deine Projekte hier
noch einmal ergänzen, die anderen Angaben wurden schon übernommen.

Noch ein Tipp:

Rufe die Login URL am besten schon mal auf deinem Smartphone
auf und lege die Seite mittels:

- Optionen "Zum Startbildschirm hinzufügen" (Android)

oder

- Teilen "Zum Home-Bildschirm" (iOS)

ab. Dadurch hast du die Seite wie eine App direkt startbereit.

Viele Grüße,

Deine Subscribe Orga
@endcomponent

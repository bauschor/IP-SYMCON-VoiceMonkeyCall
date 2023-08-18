# VoiceMonkey-Control
Sendet einen Text an die VoiceMonkey API v2

Voraussetzung ist der entsprechende Skill in der Alexa App.
Eine Schritt für Schritt Anleitung für VoiceMonkey findet man unter https://voicemonkey.io/start

Das Modul wird über die SYMCON Modulverwaltung (noch nicht über den SYMCON Module Store) hinzugefügt.

Nach Installation des Moduls fügt man eine neue Instanz (suche nach "VoiceMonkey") in den Objektbaum ein.
Die Erforderlichen Infos für das Feld Tokenfindet man unter 
https://console.voicemonkey.io/api-v2/playground


Die Sprachausgabe erfolgt dann im PHP Code durch

VMC_TTS([ID der VoiceMonkeyCall Instanz], [Name_des_Echo_Devices_in_VoiceMonkey], $text);

Den Namen des Echo Devices in VoiceMonkey findet man z.B. im Beispielcode für das jeweilige Device (Fenster auf der rechten Seite, "API URL") unter https://console.voicemonkey.io/api-v2/playground
(In der URL, hinter dem Schlüsselwort "&device=" bis zum nachfolgenden "&")

Leider habe ich keine Möglichkeit gefunden, die Namen der in VoiceMonkey angelegten Devices auszulesen, d.h. man muss wirklich den Device-Namen aus der o.g. URL holen; sorry.

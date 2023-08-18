<?php
    // Klassendefinition
    class VoiceMonkeyCall extends IPSModule {
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

            $this->RegisterPropertyString("VMC_url", "https://api-v2.voicemonkey.io/announcement");
            $this->RegisterPropertyString("VMC_token", "Token");
            $this->RegisterPropertyString("VMC_device", "Device");
			
            $this->RegisterVariableString("VMC_last_device", "Last Device");			
            $this->RegisterVariableString("VMC_last_TTS", "Last TTS");			
	}
		

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }
 

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * VMC_TTS($monkey_device, $text)
        */

        // -------------------------------------------------------------------------        
        public function TTS(string $monkey_device, string $text) {

            $url = $this->ReadPropertyString("VMC_url");
            $tok = $this->ReadPropertyString("VMC_token");
            $dev = $monkey_device;
            $txt = urlencode($text);

            Sys_GetURLContent($url."?token=".$tok."&device=".$dev."&text=".$txt);
			
			$this->SetValue("VMC_last_device", $monkey_device);
			$this->SetValue("VMC_last_TTS", $text);
      	}

    }
?>

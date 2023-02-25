<?php
    // Klassendefinition
    class VoiceMonkeyCall extends IPSModule {
 
        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

            $this->RegisterPropertyString("VMC_url", "https://api.voicemonkey.io/trigger");
            $this->RegisterPropertyString("VMC_access_token", "Access Token");
            $this->RegisterPropertyString("VMC_secret_token", "Secret Token");
            $this->RegisterPropertyString("VMC_monkey_device", "Device");
			
            $this->RegisterVariableString("VMC_last_device", "Last Device");			
            $this->RegisterVariableString("VMC_last_TTS", "Last TTS");			
		}
		
/*		
        public function RequestAction($Ident, $Value) {
            switch($Ident){
            case "VMC_last_device":
                break;                
            case "VMC_last_TTS":
                break;
            }
        }
*/


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
            $acc = $this->ReadPropertyString("VMC_access_token");
            $sec = $this->ReadPropertyString("VMC_secret_token");
            $dev = $monkey_device;
            $txt = urlencode($text);

            Sys_GetURLContent($url."?access_token=".$acc."&secret_token=".$sec."&monkey=".$dev."&announcement=".$txt);
			
			$this->SetValue("VMC_last_device", $monkey_device);
			$this->SetValue("VMC_last_TTS", $text);
      }

    }
?>

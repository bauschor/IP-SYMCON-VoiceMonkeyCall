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
		

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }
 

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * VMC_TTS($monkey_device, $text [, $voice])
		* VMC_Trigger($monkey_device [, $text, $voice, $image, $video, $website])
        */

        // -------------------------------------------------------------------------        
        public function TTS(string $monkey_device, string $text, string $voice = null) {

            $url = $this->ReadPropertyString("VMC_url");
            $acc = $this->ReadPropertyString("VMC_access_token");
            $sec = $this->ReadPropertyString("VMC_secret_token");
            $dev = $monkey_device;
            $txt = urlencode($text);

			$vce = "";
			
			if ($voice !== null){
				$vce = "&voice=".urlencode($voice);
			}
			
            Sys_GetURLContent($url."?access_token=".$acc."&secret_token=".$sec."&monkey=".$dev."&announcement=".$txt.$vce);
			
			$this->SetValue("VMC_last_device", $monkey_device);
			$this->SetValue("VMC_last_TTS", $text);
		}


		// -------------------------------------------------------------------------        
        public function Trigger(string $monkey_device, string $text = null, string $voice = null, string $image = null, string $video = null, string $website = null) {

            $url = $this->ReadPropertyString("VMC_url");
            $acc = $this->ReadPropertyString("VMC_access_token");
            $sec = $this->ReadPropertyString("VMC_secret_token");
            $dev = $monkey_device;


			$more = "";
			if ($text !== null){
				$more = $more."&announcement=".urlencode($text);
				$this->SetValue("VMC_last_TTS", $text);
			}
			if ($voice !== null){
				$more = $more."&voice=".urlencode($voice);
			}
			if ($image !== null){
				$more = $more."&image=".urlencode($image);
			}
			if ($video !== null){
				$more = $more."&video=".urlencode($video);
			}				
			if ($website !== null){
				$more = $more."&website=".urlencode($website);
			}

			if (strlen($more) > 0){
				Sys_GetURLContent($url."?access_token=".$acc."&secret_token=".$sec."&monkey=".$dev.$more);
				$this->SetValue("VMC_last_device", $monkey_device);
			}
		}

		
		// -------------------------------------------------------------------------        
    }
?>

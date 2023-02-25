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
        * VMC_TTS($monkey_device, $text)
        * VMC_TTS_voice($monkey_device, $text, $voice)
	* VMC_Trigger($monkey_device, $text, $voice, $image, $video, $website)
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
        public function TTS_voice(string $monkey_device, string $text, string $voice) {

            $url = $this->ReadPropertyString("VMC_url");
            $acc = $this->ReadPropertyString("VMC_access_token");
            $sec = $this->ReadPropertyString("VMC_secret_token");
            $dev = $monkey_device;
            $txt = urlencode($text);

		$vce = "";
		if (strlen($voice) > 0){
			$vce = "&voice=".urlencode($voice);
		}
		
            Sys_GetURLContent($url."?access_token=".$acc."&secret_token=".$sec."&monkey=".$dev."&announcement=".$txt.$vce);
			$this->SetValue("VMC_last_device", $monkey_device);
			$this->SetValue("VMC_last_TTS", $text);
		}



		// -------------------------------------------------------------------------        
        public function Trigger(string $monkey_device, string $text, string $voice, string $image, string $video, string $website) {

            $url = $this->ReadPropertyString("VMC_url");
            $acc = $this->ReadPropertyString("VMC_access_token");
            $sec = $this->ReadPropertyString("VMC_secret_token");
            $dev = $monkey_device;


			$more = "";
			if (strlen($text) > 0){
				$more = $more."&announcement=".urlencode($text);
				$this->SetValue("VMC_last_TTS", $text);
			}
			if (strlen($voice) > 0){
				$more = $more."&voice=".urlencode($voice);
			}
			if (strlen($image) > 0){
				$more = $more."&image=".urlencode($image);
			}
			if (strlen($video) > 0){
				$more = $more."&video=".urlencode($video);
			}				
			if (strlen($website) > 0){
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

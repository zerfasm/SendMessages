<?php

require_once __DIR__.'/../libs/traits.php';  // Allgemeine Funktionen

// CLASS ClimateCalculation
class SendMessages extends IPSModule
{
    use ProfileHelper, DebugHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
        
	// Nachricht
	$this->RegisterPropertyString('Title', "");
	$this->RegisterPropertyString('Text', "");
	    
        // Message Alexa
	$this->RegisterPropertyBoolean('CheckAlexa', false);
        $this->RegisterPropertyString('AlexaID', "");
	$this->RegisterPropertyInteger('AlexaVolume', 40);
	
	// Message Pushover   
        $this->RegisterPropertyBoolean('CheckPushover', false);
	$this->RegisterPropertyString('PushoverID', "");
	    
	// Message Telegram    
        $this->RegisterPropertyBoolean('CheckTelegram', false);
	$this->RegisterPropertyString('TelegramID', "");
	
	// Message Webfront    
        $this->RegisterPropertyBoolean('CheckPushNotification', false);
        $this->RegisterPropertyBoolean('CheckAudioNotification', false);
	
	// Message Enigma
        $this->RegisterPropertyBoolean('CheckEnigma', false);
	$this->RegisterPropertyString('EnigmaID', "");
	    
        $this->RegisterPropertyBoolean('CheckLogger', false);
	    
	// Update trigger
        $this->RegisterTimer('UpdateTrigger', 0, "MESS_Update(\$_IPS['TARGET']);");
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
    }

    public function Update()
    {
     	$title = $this->ReadPropertyString('Title');
     	$text = $this->ReadPropertyString('Text');
	
	//Alexa    
	$tts = $this->ReadPropertyBoolean('CheckAlexa');
	$AID = $this->ReadPropertyString('AlexaID');   
	$AV = $this->ReadPropertyInteger('AlexaVolume'); 
	
	//TTS Alexa Echo Remote Modul   
        if ($tts == true){
           	EchoRemote_SetVolume($AID, $AV);
		EchoRemote_TextToSpeech($AID, $text);
	}
    }

    public function Duration(int $duration)
    {
        IPS_SetProperty($this->InstanceID, 'UpdateTimer', $duration);
        IPS_ApplyChanges($this->InstanceID);
    }
}

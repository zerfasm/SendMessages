<?php

require_once __DIR__.'/../libs/traits.php';  // Allgemeine Funktionen

// CLASS ClimateCalculation
class Message extends IPSModule
{
    use ProfileHelper, DebugHelper;

    public function Create()
    {
        //Never delete this line!
        parent::Create();
  
        // Message
        $this->RegisterPropertyBoolean('CheckPushover', false);
        $this->RegisterPropertyBoolean('CheckTelegram', false);
        $this->RegisterPropertyBoolean('CheckAlexa', false);
        $this->RegisterPropertyBoolean('CheckPushNotification', false);
        $this->RegisterPropertyBoolean('CheckAudioNotification', false);
        $this->RegisterPropertyBoolean('CheckEnigma', false);
        $this->RegisterPropertyBoolean('CheckLogger', false);
    }

    public function ApplyChanges()
    {
        //Never delete this line!
        parent::ApplyChanges();
    }

    public function Duration(int $duration)
    {
        IPS_SetProperty($this->InstanceID, 'UpdateTimer', $duration);
        IPS_ApplyChanges($this->InstanceID);
    }
}

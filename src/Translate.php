<?php

namespace Kurt\Google;

class Translate
{
    private $googleServicesCore;

    private $defaultLanguage;

    private $service;

    public function __construct(Core $googleServicesCore)
    {
        $this->googleServicesCore = $googleServicesCore;

        $this->setPropertiesFromConfigFile();

        $this->setupTranslateService();
    }

    public function setDefaultLanguage($languageShorty)
    {
        $this->defaultLanguage = $languageShorty;
    }

    private function setPropertiesFromConfigFile()
    {
        $this->defaultLanguage = config('google.translate.defaultLanguage', 'de');
    }

    private function setupTranslateService()
    {
        $this->service = new \Google_Service_Translate(
            $this->googleServicesCore->getClient()
        );
    }

    public function getTranslation($q, $target, $optParameters = [])
    {
        $translationObject = $this->service->translations->listTranslations($q, $target, $optParameters);

        $simpleTranslationObject = $translationObject->toSimpleObject();

        $translatedText = $simpleTranslationObject->data['translations'][0]['translatedText'];

        return $translatedText;
    }

    public function getLanguages($optParameters = [])
    {
        $languagesObject = $this->service->languages->listLanguages($optParameters);

        $simpleLanguagesObject = $languagesObject->toSimpleObject();

        $languages = $simpleLanguagesObject->data['languages'];

        return $languages;
    }

    public function detectLanguage($q, $type = 'language', $optParameters = [])
    {
        $detectedLanguageObject = $this->service->detections->listDetections($q, $optParameters);

        $simpleDetectedLanguageObject = $detectedLanguageObject->toSimpleObject();

        $language = $simpleDetectedLanguageObject->data['detections'][0][0]['language'];

        return $language;
    }
}

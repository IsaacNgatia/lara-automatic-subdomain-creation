<?php

namespace App\Services;

class CountryService
{
    protected $countries = [
        'KE' => [
            'name' => 'Kenya',
            'currency' => 'KES',
            'language' => 'en',
            'timezone' => 'Africa/Nairobi',
        ],
        'UG' => [
            'name' => 'Uganda',
            'currency' => 'UGX',
            'language' => 'en',
            'timezone' => 'Africa/Kampala',
        ],
        'TZ' => [
            'name' => 'Tanzania',
            'currency' => 'TZS',
            'language' => 'sw',
            'timezone' => 'Africa/Dar_es_Salaam',
        ],
        'RW' => [
            'name' => 'Rwanda',
            'currency' => 'RWF',
            'language' => 'rw',
            'timezone' => 'Africa/Kigali',
        ],
        'BI' => [
            'name' => 'Burundi',
            'currency' => 'BIF',
            'language' => 'fr',
            'timezone' => 'Africa/Bujumbura',
        ],
        'SS' => [
            'name' => 'South Sudan',
            'currency' => 'SSP',
            'language' => 'en',
            'timezone' => 'Africa/Juba',
        ],
        'ET' => [
            'name' => 'Ethiopia',
            'currency' => 'ETB',
            'language' => 'am',
            'timezone' => 'Africa/Addis_Ababa',
        ],
        'DJ' => [
            'name' => 'Djibouti',
            'currency' => 'DJF',
            'language' => 'fr',
            'timezone' => 'Africa/Djibouti',
        ],
        'SO' => [
            'name' => 'Somalia',
            'currency' => 'SOS',
            'language' => 'so',
            'timezone' => 'Africa/Mogadishu',
        ],
    ];


    public function getAllCountries()
    {
        return $this->countries;
    }

    public function getCountryByCode($code)
    {
        return $this->countries[strtoupper($code)] ?? null;
    }

    public function getCurrentCountry()
    {
        $countryCode = env('COUNTRY', 'KE');
        return $this->getCountryByCode($countryCode);
    }
    public function getCurrentCurrency()
    {
        $country = $this->getCurrentCountry();
        return $country['currency'] ?? 'KES';
    }
    public function getCurrentLanguage()
    {
        $country = $this->getCurrentCountry();
        return $country['language'] ?? 'en';
    }
    public function getCurrentTimezone()
    {
        $country = $this->getCurrentCountry();
        return $country['timezone'] ?? 'Africa/Nairobi';
    }
}

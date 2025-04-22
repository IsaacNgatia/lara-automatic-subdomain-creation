<?php

namespace App\Providers;

use App\Models\Customer;
use App\Services\RouterosApiService;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(RouterosApiService::class, function ($app) {
            return new RouterosApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->setTimezoneBasedOnCountry();
        // Fortify::authenticateUsing(function (Request $request) {
        //     $client = Customer::where('username', $request->email)
        //         ->orWhere('email', $request->email)
        //         ->first();

        //     if (
        //         $client &&
        //         Hash::check($request->password, $client->password)
        //     ) {
        //         return $client;
        //     }
        // });
    }

    private function setTimezoneBasedOnCountry()
    {
        $country = env('COUNTRY', 'KE'); // Default to 'US' if COUNTRY is not set
        $timezone = $this->getTimezoneByCountry($country);

        Config::set('app.timezone', $timezone);
    }

    private function getTimezoneByCountry($country)
    {
        $timezones = [
            'DZ' => 'Africa/Algiers',       // Algeria
            'AO' => 'Africa/Luanda',        // Angola
            'BJ' => 'Africa/Porto-Novo',    // Benin
            'BW' => 'Africa/Gaborone',      // Botswana
            'BF' => 'Africa/Ouagadougou',   // Burkina Faso
            'BI' => 'Africa/Bujumbura',     // Burundi
            'CM' => 'Africa/Douala',        // Cameroon
            'CV' => 'Atlantic/Cape_Verde',  // Cape Verde
            'CF' => 'Africa/Bangui',        // Central African Republic
            'TD' => 'Africa/Ndjamena',      // Chad
            'KM' => 'Indian/Comoro',        // Comoros
            'CD' => 'Africa/Kinshasa',      // Democratic Republic of the Congo (Kinshasa)
            'CG' => 'Africa/Brazzaville',   // Republic of the Congo (Brazzaville)
            'CI' => 'Africa/Abidjan',       // Ivory Coast
            'DJ' => 'Africa/Djibouti',      // Djibouti
            'EG' => 'Africa/Cairo',         // Egypt
            'GQ' => 'Africa/Malabo',        // Equatorial Guinea
            'ER' => 'Africa/Asmara',        // Eritrea
            'SZ' => 'Africa/Mbabane',       // Eswatini (Swaziland)
            'ET' => 'Africa/Addis_Ababa',   // Ethiopia
            'GA' => 'Africa/Libreville',    // Gabon
            'GM' => 'Africa/Banjul',        // Gambia
            'GH' => 'Africa/Accra',         // Ghana
            'GN' => 'Africa/Conakry',       // Guinea
            'GW' => 'Africa/Bissau',        // Guinea-Bissau
            'KE' => 'Africa/Nairobi',       // Kenya
            'LS' => 'Africa/Maseru',        // Lesotho
            'LR' => 'Africa/Monrovia',      // Liberia
            'LY' => 'Africa/Tripoli',       // Libya
            'MG' => 'Indian/Antananarivo',  // Madagascar
            'MW' => 'Africa/Blantyre',      // Malawi
            'ML' => 'Africa/Bamako',        // Mali
            'MR' => 'Africa/Nouakchott',    // Mauritania
            'MU' => 'Indian/Mauritius',     // Mauritius
            'MA' => 'Africa/Casablanca',    // Morocco
            'MZ' => 'Africa/Maputo',        // Mozambique
            'NA' => 'Africa/Windhoek',      // Namibia
            'NE' => 'Africa/Niamey',        // Niger
            'NG' => 'Africa/Lagos',         // Nigeria
            'RW' => 'Africa/Kigali',        // Rwanda
            'ST' => 'Africa/Sao_Tome',      // Sao Tome and Principe
            'SN' => 'Africa/Dakar',         // Senegal
            'SC' => 'Indian/Mahe',          // Seychelles
            'SL' => 'Africa/Freetown',      // Sierra Leone
            'SO' => 'Africa/Mogadishu',     // Somalia
            'ZA' => 'Africa/Johannesburg',  // South Africa
            'SS' => 'Africa/Juba',          // South Sudan
            'SD' => 'Africa/Khartoum',      // Sudan
            'TZ' => 'Africa/Dar_es_Salaam', // Tanzania
            'TG' => 'Africa/Lome',          // Togo
            'TN' => 'Africa/Tunis',         // Tunisia
            'UG' => 'Africa/Kampala',       // Uganda
            'ZM' => 'Africa/Lusaka',        // Zambia
            'ZW' => 'Africa/Harare',        // Zimbabwe
        ];
        return $timezones[$country] ?? 'UTC'; // Default to 'UTC' if country not found
    }
}

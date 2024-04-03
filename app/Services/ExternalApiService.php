<?php

  namespace App\Services;

  use Illuminate\Support\Facades\Http;

  class ExternalApiService
  {
      public function getCountries()
      {
        try {
            // Make HTTP request to fetch countries
            $response = Http::get('http://country.io/continent.json');

            if ($response->failed()) {
                throw new \Exception('Failed to fetch countries from external API');
            }

            return $response->json();
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            // You can also throw a custom exception
            throw new \Exception('Error fetching countries: ' . $e->getMessage());
        }
      }

      public function getTimezones()
      {
        try {
            // Make HTTP request to fetch timezones
            $response = Http::get('http://worldtimeapi.org/api/timezone');

            if ($response->failed()) {
                throw new \Exception('Failed to fetch timezones from external API');
            }

            return $response->json();
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            // You can also throw a custom exception
            throw new \Exception('Error fetching timezones: ' . $e->getMessage());
        }
      }
  }
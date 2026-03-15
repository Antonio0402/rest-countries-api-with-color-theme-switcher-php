<?php

class CountriesRepository
{
    public function __construct()
    {
    }

    private function serializeCountries(array $countries): Coutry
    {
        return new Coutry(
            name: $country['name'],
            alpha3Code: $country['alpha3Code'],
            topLevelDomain: $country['topLevelDomain'],
            population: $country['population'],
            currencies: $country['currencies'],
            region: $country['region'],
            languages: $country['languages'],
            subregion: $country['subregion'],
            capital: $country['capital'],
            borders: $country['borders'],
            flag: $country['flag']
        );
    }

    public function getAll(): array
    {
        $data = file_get_contents(__DIR__ . '/../data/countries.json');
        $countries = json_decode($data, true);
        $result = [];
        foreach ($countries as $country) {
            $result[] = $this->serializeCountries($country);
        }
        return $result;
    }
    public function getByCode(string $code): ?Coutry
    {
        $countries = $this->getAll();
        foreach ($countries as $country) {
            if ($country->alpha3Code === $code) {
                return $country;
            }
        }
        return null;
    }
    public function getByRegion(string $region): array
    {
        $countries = $this->getAll();
        $result = [];
        foreach ($countries as $country) {
            if ($country->region === $region) {
                $result[] = $country;
            }
        }
        return $result;
    }
    public function getByName(string $name): ?Coutry
    {
        $countries = $this->getAll();
        foreach ($countries as $country) {
            if (strtolower($country->name) === strtolower($name)) {
                return $country;
            }
        }
        return null;
    }

}

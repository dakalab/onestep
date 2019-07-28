<?php

namespace App;

use PragmaRX\Countries\Package\Countries;

class Helper
{
    public static function countries()
    {
        return Countries::all()
            ->pluck('name.common', 'cca3')
            ->sort()
            ->toArray();
    }

    public static function states($country)
    {
        if (!$country || $country == 'undefined') {
            return [];
        }
        try {
            return Countries::where('name.common', $country)
                ->first()
                ->hydrateStates()
                ->states
                ->pluck('name', 'postal')
                ->sort()
                ->toArray();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return [];
        }
    }

    public static function provinces($country)
    {
        return self::states($country);
    }

    public static function cca2($countryName)
    {
        if (empty($countryName)) {
            return '';
        }
        if (strlen($countryName) <= 2) {
            return $countryName;
        }

        try {
            $countries = Countries::whereNameCommon($countryName);
            if (empty($countries)) {
                return $countryName;
            }
            return $countries->pluck('cca2')->first();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $countryName;
        }
    }

    public static function dialingCode($countryName)
    {
        if (empty($countryName) || strlen($countryName) <= 2) {
            return '';
        }

        try {
            $countries = Countries::whereNameCommon($countryName);
            if (empty($countries)) {
                return '';
            }

            $country = $countries->first();
            if (!empty($country) && !empty($country->dialling)) {
                return $country->dialling->calling_code->first();
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return '';
    }

    public static function randomStr($length = 8)
    {
        if (function_exists('random_bytes')) {
            return strtoupper(bin2hex(random_bytes($length)));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return strtoupper(bin2hex(openssl_random_pseudo_bytes($length)));
        }
        if (function_exists('mcrypt_create_iv')) {
            return strtoupper(bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM)));
        }
        return strtoupper(uniqid());
    }

    public static function o2a($object, $recursive = false)
    {
        if ($object instanceof \Traversable) {
            $array = iterator_to_array($object);
        } elseif (method_exists($object, 'toArray')) {
            $array = $object->toArray();
        } elseif (method_exists($object, 'asArray')) {
            $array = $object->toArray();
        } elseif (method_exists($object, 'as_array')) {
            $array = $object->toArray();
        } elseif (method_exists($object, 'getArrayCopy')) {
            $array = $object->toArray();
        } elseif (is_object($object)) {
            $array = get_object_vars($object);
        } else {
            $array = (array) $object;
        }

        if (!$recursive) {
            return $array;
        }

        $data = [];
        foreach ($array as $key => $value) {
            $data[$key] = is_object($value)
            ? self::convert($value, $recursive)
            : $value;
        }

        return $data;
    }

    /**
     * Get the exchange rate of $base/$quote
     *
     * @param  string  $base  the base currency, e.g. USD
     * @param  string  $quote the quoted currency, e.g. CNY
     * @return float
     */
    public static function getExchangeRate($base, $quote)
    {
        $key = 'exchange_rates';

        $base = trim($base);
        $quote = trim($quote);

        if ($base == $quote) {
            return 1;
        }

        $json = cache($key);

        if (!$json) {
            $json = file_get_contents('http://data.fixer.io/api/latest?access_key=' . config('app.fixer_key'));
        }

        $data = json_decode($json, true);

        if (empty($data['rates']) || empty($data['rates'][$base]) || empty($data['rates'][$quote])) {
            throw new \Exception('Fail to get fixer data');
        }

        if (!cache($key)) {
            cache([$key => $json], 720); // cache 12 hours
        }

        return $data['rates'][$base] / $data['rates'][$quote];
    }

    public static function money($amount, $currency = null)
    {
        if (!$currency) {
            $currency = config('app.currency');
        }
        setlocale(LC_MONETARY, config('currency.' . $currency));
        $exchangeRate = self::getExchangeRate($currency, config('app.currency'));

        $m = money_format('%.2n', $amount * $exchangeRate);
        return str_ireplace('Eu', '€', $m);
    }

    /**
     * Calculate periodic time
     *
     * @param  mix    $start      start timestamp or datetime
     * @param  int    $periods    the periods to add
     * @param  string $unit       period unit
     * @return int    timestamp
     */
    public static function periodicTime($start, $periods, $unit = 'm')
    {
        is_numeric($start) || $start = strtotime($start);

        switch (strtolower($unit)) {
            case 'y':
                return strtotime("+$periods years", $start);

            case 'w':
                return strtotime("+$periods weeks", $start);

            case 'm':
                $n = date('n', $start) + $periods;
                $y = date('Y', $start) + floor($n / 12);
                $m = $n % 12;
                $d = date('d', $start);

                $time = strtotime("$y-$m-$d");

                // the first date of month
                $firstDay = strtotime("$y-$m-01");

                // the last date of month
                $lastDay = strtotime(date('Y-m-t', $firstDay));

                return min($time, $lastDay);

            case 'd':
            default:
                return strtotime("+$periods days", $start);
        }
    }

    /**
     * Get order tracking
     *
     * @param  string  $trackingNO
     * @param  string  $express
     * @return array
     */
    public static function track($trackingNO, $express)
    {
        if (empty($trackingNO)) {
            return [];
        }

        $result = [];
        $row = new \stdClass;
        $row->occurDate = '';
        // $row->trackCode = '';
        $row->trackContent = '';
        $row->occurAddress = '';

        $result[] = $row;

        return $result;
    }
}

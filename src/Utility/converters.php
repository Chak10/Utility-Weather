<?php

namespace wt_converter;

class Temperature {
    
    private $res = false;
    
    private static $conversionMap = [
        'c' => ['f' => 'cel2far', 'k' => 'cel2kel', 'r' => 'cel2ran'],
        'f' => ['c' => 'far2cel', 'k' => 'far2kel', 'r' => 'far2ran'],
        'k' => ['c' => 'kel2cel', 'f' => 'kel2far', 'r' => 'kel2ran'],
        'r' => ['c' => 'ran2cel', 'f' => 'ran2far', 'k' => 'ran2kel'],
    ];

    public function __construct($temp, $unit_in, $unit_out) {
        $unit_in = strtolower($unit_in);
        $unit_out = strtolower($unit_out);
        
        if ($temp !== null && is_numeric($temp)) {
            if ($unit_in === $unit_out) {
                return $this->res = $temp;
            }
            $this->res = $this->convert($temp, $unit_in, $unit_out);
        }
    }

    private function convert($temp, $unit_in, $unit_out) {
        if (isset(self::$conversionMap[$unit_in][$unit_out])) {
            return self::{$this::$conversionMap[$unit_in][$unit_out]}($temp);
        }
        return NAN;
    }

    public static function cel2far($n) {
        return $n >= -273.15 ? ($n * 1.8) + 32 : NAN;
    }
    public static function cel2kel($n) {
        return $n >= -273.15 ? $n + 273.15 : NAN;
    }
    public static function cel2ran($n) {
        return $n >= -273.15 ? ($n + 273.15) * 1.8 : NAN;
    }
    public static function far2cel($n) {
        return $n >= -459.67 ? ($n - 32) * (5 / 9) : NAN;
    }
    public static function far2kel($n) {
        return $n >= -459.67 ? ($n + 459.67) * (5 / 9) : NAN;
    }
    public static function far2ran($n) {
        return $n >= -459.67 ? $n + 459.67 : NAN;
    }
    public static function kel2far($n) {
        return $n >= 0 ? ($n * 1.8) - 459.67 : NAN;
    }
    public static function kel2cel($n) {
        return $n >= 0 ? $n - 273.15 : NAN;
    }
    public static function kel2ran($n) {
        return $n >= 0 ? $n * 1.8 : NAN;
    }
    public static function ran2cel($n) {
        return $n >= 0 ? ($n - 491.67) * (5 / 9) : NAN;
    }
    public static function ran2far($n) {
        return $n >= 0 ? $n - 459.67 : NAN;
    }
    public static function ran2kel($n) {
        return $n >= 0 ? $n * (5 / 9) : NAN;
    }
}

class Pressure {
    
    private $res = false;
    
    private static $conversionMap = [
        'hpa' => ['atm' => 'HP2A', 'torr' => 'HP2T'],
        'atm' => ['hpa' => 'A2HP', 'torr' => 'A2T'],
        'torr' => ['atm' => 'T2A', 'hpa' => 'T2HP'],
    ];

    public function __construct($pres, $unit_in, $unit_out) {
        $unit_in = strtolower($unit_in);
        $unit_out = strtolower($unit_out);
        
        if ($pres !== null && is_numeric($pres)) {
            if ($unit_in === $unit_out) {
                return $this->res = $pres;
            }
            $this->res = $this->convert($pres, $unit_in, $unit_out);
        }
    }

    private function convert($pres, $unit_in, $unit_out) {
        if (isset(self::$conversionMap[$unit_in][$unit_out])) {
            return self::{$this::$conversionMap[$unit_in][$unit_out]}($pres);
        }
        return NAN;
    }

    public static function HP2A($n) {
        return $n * 1013.25;
    }
    public static function HP2T($n) {
        return $n * 7.5006157818041e-1;
    }
    public static function A2T($n) {
        return $n * 760;
    }
    public static function A2HP($n) {
        return $n * 9.8692326671601e-4;
    }
    public static function T2A($n) {
        return $n / 760;
    }
    public static function T2HP($n) {
        return $n * 1.33322387;
    }
}

class Rain {
    
    private $res = false;
    
    private static $conversionMap = [
        'mm' => ['in' => 'mm2in'],
        'in' => ['mm' => 'in2mm'],
    ];

    public function __construct($rain, $unit_in, $unit_out) {
        $unit_in = strtolower($unit_in);
        $unit_out = strtolower($unit_out);
        
        if ($rain !== null && is_numeric($rain)) {
            if ($unit_in === $unit_out) {
                return $this->res = $rain;
            }
            $this->res = $this->convert($rain, $unit_in, $unit_out);
        }
    }

    private function convert($rain, $unit_in, $unit_out) {
        if (isset(self::$conversionMap[$unit_in][$unit_out])) {
            return self::{$this::$conversionMap[$unit_in][$unit_out]}($rain);
        }
        return NAN;
    }

    public static function mm2in($n) {
        return $n * 3.9370078740157e-2;
    }
    public static function in2mm($n) {
        return $n * 25.4;
    }
}

class Wind {
    
    private $res = false;
    
    private static $conversionMap = [
        'kmh' => ['ms' => 'kmh2ms', 'mph' => 'kmh2mph', 'kn' => 'kmh2kn', 'fts' => 'kmh2fts'],
        'ms' => ['kmh' => 'ms2kmh', 'mph' => 'ms2mph', 'kn' => 'ms2kn', 'fts' => 'ms2fts'],
        'mph' => ['kmh' => 'mph2kmh', 'ms' => 'mph2ms', 'kn' => 'mph2kn', 'fts' => 'mph2fts'],
        'kn' => ['ms' => 'kn2ms', 'kmh' => 'kn2kmh', 'mph' => 'kn2mph', 'fts' => 'kn2fts'],
        'fts' => ['kmh' => 'fts2kmh', 'ms' => 'fts2ms', 'mph' => 'fts2mph', 'kn' => 'fts2kn'],
    ];

    public function __construct($wind, $unit_in, $unit_out) {
        $unit_in = strtolower($unit_in);
        $unit_out = strtolower($unit_out);
        
        if ($wind !== null && is_numeric($wind)) {
            if ($unit_in === $unit_out) {
                return $this->res = $wind;
            }
            $this->res = $this->convert($wind, $unit_in, $unit_out);
        }
    }

    private function convert($wind, $unit_in, $unit_out) {
        if (isset(self::$conversionMap[$unit_in][$unit_out])) {
            return self::{$this::$conversionMap[$unit_in][$unit_out]}($wind);
        }
        return NAN;
    }

    public static function kmh2ms($n) {
        return $n / 3.6;
    }
    public static function kmh2mph($n) {
        return $n * 0.62137119223733;
    }
    public static function kmh2kn($n) {
        return $n * 0.539956803;
    }
    public static function kmh2fts($n) {
        return $n * 0.911344;
    }
    public static function ms2kmh($n) {
        return $n * 3.6;
    }
    public static function ms2mph($n) {
        return $n * 2.236936;
    }
    public static function ms2kn($n) {
        return $n * 1.943844;
    }
    public static function ms2fts($n) {
        return $n * 3.28084;
    }
    public static function mph2kmh($n) {
        return $n / 0.62137119223733;
    }
    public static function mph2ms($n) {
        return $n / 2.236936;
    }
    public static function mph2kn($n) {
        return $n / 1.150779;
    }
    public static function mph2fts($n) {
        return $n * 1.46667;
    }
    public static function kn2ms($n) {
        return $n / 1.943844;
    }
    public static function kn2kmh($n) {
        return $n / 0.539956803;
    }
    public static function kn2mph($n) {
        return $n / 1.150779;
    }
    public static function kn2fts($n) {
        return $n * 1.68781;
    }
    public static function fts2kmh($n) {
        return $n / 0.911344;
    }
    public static function fts2ms($n) {
        return $n / 3.28084;
    }
    public static function fts2mph($n) {
        return $n / 1.46667;
    }
    public static function fts2kn($n) {
        return $n / 1.68781;
    }
}
?>

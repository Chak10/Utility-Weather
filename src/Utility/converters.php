<?php

namespace wt_converter;

class Temperature {
    
    public $res = false;
    
    private static $conversionMap = [
        'c' => [
            'f' => 'cel2far',
            'k' => 'cel2kel',
            'r' => 'cel2ran',
        ],
        'f' => [
            'c' => 'far2cel',
            'k' => 'far2kel',
            'r' => 'far2ran',
        ],
        'k' => [
            'c' => 'kel2cel',
            'f' => 'kel2far',
            'r' => 'kel2ran',
        ],
        'r' => [
            'c' => 'ran2cel',
            'f' => 'ran2far',
            'k' => 'ran2kel',
        ],
    ];

    function __construct($temp = null, $unit_in = null, $unit_out = null) {
        if ($temp !== null && is_numeric($temp)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);

            // If the units are the same, return the input value
            if ($unit_in === $unit_out) {
                $this->res = $temp;
            }
            // If a valid conversion exists, perform the conversion
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $conversionMethod = self::$conversionMap[$unit_in][$unit_out];
                $this->res = self::$conversionMethod($temp);
            } else {
                $this->res = NAN; // If no valid conversion is found
            }
        }
    }

    public function getResult() {
        return $this->res;
    }

    // Conversion methods
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
    
    public $res = false;
    
    private static $conversionMap = [
        'hpa' => [
            'atm' => 0.00098692326671601,
            'torr' => 0.75006157818041,
        ],
        'atm' => [
            'hpa' => 1013.25,
            'torr' => 760,
        ],
        'torr' => [
            'hpa' => 1.33322387,
            'atm' => 0.001315789474,
        ],
    ];

    function __construct($pres = null, $unit_in = null, $unit_out = null) {
        if ($pres !== null && is_numeric($pres)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            
            // If the units are the same, return the input value
            if ($unit_in === $unit_out) {
                $this->res = $pres;
            }
            // If a valid conversion is available, perform the conversion
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $this->res = $pres * self::$conversionMap[$unit_in][$unit_out];
            }
        }
    }

    public function getResult() {
        return $this->res;
    }
    
}


class Rain {
    
    public $res = false;
    
    private static $conversionMap = [
        'mm' => ['in' => 0.039370078740157],
        'in' => ['mm' => 25.4],
    ];

    function __construct($rain = null, $unit_in = null, $unit_out = null) {
        if ($rain !== null && is_numeric($rain)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            
            // If the units are the same, return the input value
            if ($unit_in === $unit_out) {
                $this->res = $rain;
            }
            // If a valid conversion is available, perform the conversion
            elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $this->res = $rain * self::$conversionMap[$unit_in][$unit_out];
            }
        }
    }
    
    public static function mm2in($n) {
        return $n * self::$conversionMap['mm']['in'];
    }

    public static function in2mm($n) {
        return $n * self::$conversionMap['in']['mm'];
    }
    
    public function getResult() {
        return $this->res;
    }
}

class Wind {
    
    private $res = false;
    private static $conversionMap = [
        'kmh' => ['ms' => 0.27777777778, 'mph' => 0.62137119273443, 'fts' => 0.9113444160105, 'kn' => 0.53995680389235],
        'ms' => ['kmh' => 3.6, 'mph' => 2.2369362920544, 'fts' => 3.2808398950131, 'kn' => 1.9438444924574],
        'mph' => ['kmh' => 1.6093439987125, 'ms' => 0.44704, 'fts' => 1.4666666666667, 'kn' => 0.86897624190816],
        'fts' => ['kmh' => 1.0972799991222, 'ms' => 0.3048, 'mph' => 0.68181818181818, 'kn' => 0.59248380130101],
        'kn' => ['kmh' => 1.8519999985024, 'ms' => 0.27777777778, 'mph' => 1.1507794480136, 'fts' => 1.6878098570866],
    ];

    function __construct($wind = null, $unit_in = null, $unit_out = null) {
        if ($wind !== null && is_numeric($wind)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            
            if ($unit_in === $unit_out) {
                $this->res = $wind;
            } elseif (isset(self::$conversionMap[$unit_in][$unit_out])) {
                $conversionFactor = self::$conversionMap[$unit_in][$unit_out];
                $this->res = $wind * $conversionFactor;
            }
        }
    }
    
    public static function degToCom($num) {
        $val = floor(($num / 22.5) + 0.5);
        $arr = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
        return $arr[$val % 16];
    }
    
    public function getResult() {
        return $this->res;
    }
}


class dewPoint {
    var $res = null;

    function __construct($T, $RH, $t_u = 'c', $formula = 1, $out = null) {
        if (!is_numeric($T) || !is_numeric($RH)) {
            return $this->res = null; // Se i dati non sono numerici, ritorna null.
        }
        if ($RH < 0 || $RH > 100) {
            return $this->res = null; // Se l'umidità relativa è fuori dal range, ritorna null.
        }

        // Converte la temperatura nel formato richiesto (Kelvin per calcoli interni)
        $T = new Temperature($T, $t_u, 'k');
        $T = $T->res;
        if (is_nan($T)) {
            return $this->res = null; // Se la temperatura non è valida, ritorna null.
        }

        // Calcola il punto di rugiada usando il metodo scelto
        if ($formula === 1) {
            $this->res = self::calculateDewPointByPVS($RH, $T, $out, $t_u);
        } elseif ($formula === 2) {
            $this->res = self::calculateDewPointByMagnus($T, $RH, $out, $t_u);
        } elseif ($formula === 3) {
            $this->res = self::calculateDewPointBySimplified($T, $RH, $out, $t_u);
        }

        return $this->res;
    }

    private static function calculateDewPointByPVS($RH, $T, $out, $t_u) {
        // Calcola il punto di rugiada usando il metodo PVS
        $PVS = self::PVS($T);
        $T_dew = self::solve($RH / 100 * $PVS, $T);
        $T_dew = new Temperature($T_dew, 'k', $out ?: $t_u);
        return $T_dew->res;
    }

    private static function calculateDewPointByMagnus($T, $RH, $out, $t_u) {
        // Calcola il punto di rugiada usando il metodo Magnus-Tetens
        $B = (log($RH / 100) + ((17.27 * $T) / (237.3 + $T))) / 17.27;
        $T_dew = (237.3 * $B) / (1 - $B);
        $T_dew = new Temperature($T_dew, 'c', $out ?: $t_u);
        return $T_dew->res;
    }

    private static function calculateDewPointBySimplified($T, $RH, $out, $t_u) {
        // Calcola il punto di rugiada usando il metodo semplificato
        $T_dew = pow($RH / 100, 1 / 8) * (112 + (0.9 * $T)) + (0.1 * $T) - 112;
        $T_dew = new Temperature($T_dew, 'c', $out ?: $t_u);
        return $T_dew->res;
    }

    private static function PVS($T) {
        // Calcola la pressione di vapore
        if ($T < 273.15) {
            return self::pvsIce($T);
        } else {
            return self::pvsWater($T);
        }
    }

    private static function pvsIce($T) {
        // Calcola la pressione di vapore per il ghiaccio
        $k0 = -5.8666426e3;
        $k1 = 2.232870244e1;
        $k2 = 1.39387003e-2;
        $k3 = -3.4262402e-5;
        $k4 = 2.7040955e-8;
        $k5 = 6.7063522e-1;
        
        $lnP = $k0 / $T + $k1 + ($k2 + ($k3 + ($k4 * $T)) * $T) * $T + $k5 * log($T);
        return exp($lnP);
    }

    private static function pvsWater($T) {
        // Calcola la pressione di vapore per l'acqua
        $n1 = 0.11670521452767e4;
        $n2 = -0.72421316703206e6;
        $n3 = -0.17073846940092e2;
        $n4 = 0.12020824702470e5;
        $n5 = -0.32325550322333e7;
        $n6 = 0.14915108613530e2;
        $n7 = -0.48232657361591e4;
        $n8 = 0.40511340542057e6;
        $n9 = -0.23855557567849;
        $n10 = 0.65017534844798e3;
        
        $th = $T + $n9 / ($T - $n10);
        $A = ($th + $n1) * $th + $n2;
        $B = ($n3 * $th + $n4) * $th + $n5;
        $C = ($n6 * $th + $n7) * $th + $n8;
        $p = 2 * $C / (-$B + sqrt($B * $B - 4 * $A * $C));
        $p *= $p;
        $p *= $p;
        return $p * 1e6;
    }

    private static function solve($y, $x0) {
        // Metodo per risolvere l'equazione di punto di rugiada
        $x = $x0;
        $maxCount = 10;
        $count = 0;
        while (TRUE) {
            $dx = $x / 1000;
            $z = self::PVS($x);
            $xNew = $x + $dx * ($y - $z) / (self::PVS($x + $dx) - $z);
            if (abs(($xNew - $x) / $xNew) < 0.0001)
                return $xNew;
            if ($count > $maxCount) {
                return 273.15; // Ritorna temperatura di congelamento se non converge
            }
            $x = $xNew;
            $count++;
        }
    }
}

class apparentTemp {
    var $res = null;

    function __construct($T, $H, $W, $Q = null, $t_u = 'c', $v_u = 'kmh', $out = null) {
        /*
        Source: Norms of apparent temperature in Australia, Aust. Met. Mag., 1994, Vol 43, 1-16
        More Info http://www.bom.gov.au/info/thermal_stress/#atapproximation
        */
        
        // Verifica dei parametri di input
        if (!is_numeric($T) || !is_numeric($H) || !is_numeric($W) || $H < 0 || $H > 100) {
            return false; // Ritorna false se i parametri non sono validi
        }

        // Converte la temperatura in gradi Celsius
        $T = new Temperature($T, $t_u, 'c');
        $T = $T->res;
        if (is_nan($T)) {
            return; // Se la temperatura è invalida, esce
        }

        // Converte la velocità del vento in m/s
        $W = new Wind($W, strtolower($v_u), 'ms');
        $W = $W->res;
        if (is_nan($W)) {
            return; // Se la velocità del vento è invalida, esce
        }

        // Calcola la pressione del vapore
        $e = ($H / 100) * 6.105 * exp((17.27 * $T) / (237.7 + $T));

        // Calcola la temperatura apparente considerando la radiazione solare
        if ($Q !== null && is_numeric($Q) && $Q >= 0) {
            // Se $Q è valido, usa questa formula
            $result = $T + 0.348 * $e - 0.7 * $W + 0.70 * $Q / ($W + 10) - 4.25;
        } else {
            // Altrimenti, usa la formula senza radiazione solare
            $result = $T + 0.33 * $e - 0.7 * $W - 4;
        }

        // Restituisce la temperatura apparente nel formato richiesto
        $outUnit = $out ?? $t_u; // Se $out è null, usa $t_u come unità di output
        $new = new Temperature($result, 'c', $outUnit);
        return $this->res = $new->res;
    }
}


class heatIndex {
    var $res = null;

    function __construct($T, $RH, $unit = "f", $out = null) {
        // Verifica che i parametri siano validi
        if (!is_numeric($T) || !is_numeric($RH) || $RH < 0 || $RH > 100) {
            return; // Se non sono validi, esci
        }

        // Converte la temperatura nell'unità desiderata (in Fahrenheit)
        $T = new Temperature($T, $unit, 'f');
        $T = $T->res;
        
        // Calcola il calore percepito con la formula di base
        $hi_sp = new Temperature(0.5 * ($T + 61.0 + (($T - 68.0) * 1.2) + ($RH * 0.094)), 'f', $out ?? $unit);
        
        // Se la temperatura è al di fuori del range specificato, ritorna il risultato basato sulla formula di base
        if ($T < 80 || $T > 112) {
            return $this->res = $hi_sp->res;
        }
        
        // Calcolo del heat index usando la formula complessa
        $hi_cp = self::HI($T, $RH);
        
        // Se la temperatura è tra 80 e 87 e l'umidità è maggiore di 85, usa una formula correttiva
        if ($T >= 80 && $T <= 87 && $RH > 85) {
            $hi = new Temperature($hi_cp + (((13 - $RH) / 4) * sqrt((17 - abs($T - 95)) / 17)), 'f', $out ?? $unit);
            return $this->res = $hi->res;
        }
        
        // Se la temperatura è tra 80 e 112 e l'umidità è inferiore a 13, usa un'altra formula correttiva
        if ($T >= 80 && $T <= 112 && $RH <= 13) {
            $hi = new Temperature($hi_cp - (((13 - $RH) / 4) * sqrt((17 - abs($T - 95)) / 17)), 'f', $out ?? $unit);
            return $this->res = $hi->res;
        }
    }
    
    // Calcola l'heat index usando la formula complessa di Fawzy e Steadman
    private static function HI($T, $RH) {
        // Coefficienti della formula
        $c1 = -42.379;
        $c2 = -2.04901523;
        $c3 = -10.14333127;
        $c4 = -0.22475541;
        $c5 = -6.83783e-3;
        $c6 = -5.481717e-2;
        $c7 = -1.22874e-3;
        $c8 = 8.5282e-4;
        $c9 = -1.99e-6;
        
        // Formula per il calcolo dell'heat index
        return $c1 + $c2 * $T + $c3 * $RH + $c4 * $T * $RH + $c5 * ($T * 2) + $c6 * ($RH * 2) 
            + $c7 * ($T * 2) * $RH + $c8 * $T * ($RH * 2) + $c9 * ($T * 2) * ($RH * 2);
    }
}

class windChill {
    var $res;

    function __construct($T, $V, $type = true, $t_u = 'c', $v_u = 'kmh', $out = null) {
        // Verifica dei parametri
        if (!is_numeric($T) || !is_numeric($V)) {
            return false; // Restituisce false se i parametri non sono numerici
        }

        // Converte la temperatura nell'unità desiderata (in Fahrenheit)
        $T = new Temperature($T, $t_u, 'f');
        $T = $T->res;

        // Converte la velocità del vento nell'unità desiderata (in mph)
        $V = new Wind($V, $v_u, 'mph');
        $V = $V->res;

        // Calcola l'indice di raffreddamento da vento
        if ($type == false) {
            // Vecchia formula
            $wc = new Temperature(0.0817 * (3.71 * pow($V, 0.5) + 5.81 - 0.25 * $V) * ($T - 91.4) + 91.4, 'f', $out ?? $t_u);
        } else {
            // Formula aggiornata
            $wc = new Temperature(35.74 + 0.6215 * $T - 35.75 * pow($V, 0.16) + 0.4275 * $T * pow($V, 0.16), 'f', $out ?? $t_u);
        }

        // Restituisce il risultato finale
        return $this->res = $wc->res;
    }
}


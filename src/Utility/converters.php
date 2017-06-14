<?php

namespace wt_converter;

class temperature {
    
    var $res = false;
    
    function __construct($temp = null, $unit_in = null, $unit_out = null) {
        if ($temp !== null && is_numeric($temp)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            if ($unit_in == $unit_out)
                return $this->res = $temp;
            if ($unit_in == "c" && $unit_out == "f")
                return $this->res = self::cel2far($temp);
            if ($unit_in == "f" && $unit_out == "c")
                return $this->res = self::far2cel($temp);
            if ($unit_in == "c" && $unit_out == "k")
                return $this->res = self::cel2kel($temp);
            if ($unit_in == "k" && $unit_out == "c")
                return $this->res = self::kel2cel($temp);
            if ($unit_in == "k" && $unit_out == "f")
                return $this->res = self::kel2far($temp);
            if ($unit_in == "f" && $unit_out == "k")
                return $this->res = self::far2kel($temp);
            if ($unit_in == "c" && $unit_out == "r")
                return $this->res = self::cel2ran($temp);
            if ($unit_in == "f" && $unit_out == "r")
                return $this->res = self::far2ran($temp);
            if ($unit_in == "k" && $unit_out == "r")
                return $this->res = self::kel2ran($temp);
            if ($unit_in == "r" && $unit_out == "c")
                return $this->res = self::ran2cel($temp);
            if ($unit_in == "r" && $unit_out == "f")
                return $this->res = self::ran2far($temp);
            if ($unit_in == "r" && $unit_out == "k")
                return $this->res = self::ran2kel($temp);
        }
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

class pressure {
    
    var $res = false;
    
    function __construct($pres = null, $unit_in = null, $unit_out = null) {
        if ($pres !== null && is_numeric($pres)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            if ($unit_in == $unit_out)
                return $this->res = $pres;
            if ($unit_in == "hpa" && $unit_out == "atm")
                return $this->res = self::HP2A($pres);
            if ($unit_in == "hpa" && $unit_out == "torr")
                return $this->res = self::HP2T($pres);
            if ($unit_in == "atm" && $unit_out == "torr")
                return $this->res = self::A2T($pres);
            if ($unit_in == "atm" && $unit_out == "hpa")
                return $this->res = self::A2HP($pres);
            if ($unit_in == "torr" && $unit_out == "atm")
                return $this->res = self::T2A($pres);
            if ($unit_in == "torr" && $unit_out == "hpa")
                return $this->res = self::T2HP($pres);
        }
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

class rain {
    
    var $res = false;
    
    function __construct($rain = null, $unit_in = null, $unit_out = null) {
        if ($rain !== null && is_numeric($rain)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            if ($unit_in == $unit_out)
                return $this->res = $rain;
            if ($unit_in == "mm" && $unit_out == "in")
                return $this->res = self::mm2in($rain);
            if ($unit_in == "in" && $unit_out == "mm")
                return $this->res = self::in2mm($rain);
        }
    }
    
    public static function mm2in($n) {
        return $n * 3.9370078740157e-2;
    }
    public static function in2mm($n) {
        return $n * 25.4;
    }
}

class wind {
    
    var $res = false;
    
    function __construct($wind = null, $unit_in = null, $unit_out = null) {
        if ($wind !== null && is_numeric($wind)) {
            $unit_in = strtolower($unit_in);
            $unit_out = strtolower($unit_out);
            if ($unit_in == $unit_out)
                return $this->res = $wind;
            if ($unit_in == 'kmh' && $unit_out == 'ms')
                return $this->res = self::kmh2ms($wind);
            if ($unit_in == 'ms' && $unit_out == 'kmh')
                return $this->res = self::ms2kmh($wind);
            if ($unit_in == 'mph' && $unit_out == 'ms')
                return $this->res = self::mph2ms($wind);
            if ($unit_in == 'ms' && $unit_out == 'mph')
                return $this->res = self::ms2mph($wind);
            if ($unit_in == 'kmh' && $unit_out == 'mph')
                return $this->res = self::kmh2mph($wind);
            if ($unit_in == 'mph' && $unit_out == 'kmh')
                return $this->res = self::mph2kmh($wind);
            if ($unit_in == 'ms' && $unit_out == 'fts')
                return $this->res = self::ms2fts($wind);
            if ($unit_in == 'ms' && $unit_out == 'kn')
                return $this->res = self::ms2kn($wind);
            if ($unit_in == 'kmh' && $unit_out == 'kn')
                return $this->res = self::kmh2kn($wind);
            if ($unit_in == 'kmh' && $unit_out == 'fts')
                return $this->res = self::kmh2fts($wind);
            if ($unit_in == 'mph' && $unit_out == 'fts')
                return $this->res = self::mph2fts($wind);
            if ($unit_in == 'mph' && $unit_out == 'kn')
                return $this->res = self::mph2kn($wind);
            if ($unit_in == 'fts' && $unit_out == 'ms')
                return $this->res = self::fts2ms($wind);
            if ($unit_in == 'fts' && $unit_out == 'kmh')
                return $this->res = self::fts2kmh($wind);
            if ($unit_in == 'fts' && $unit_out == 'mph')
                return $this->res = self::fts2mph($wind);
            if ($unit_in == 'fts' && $unit_out == 'kn')
                return $this->res = self::fts2kn($wind);
            if ($unit_in == 'kn' && $unit_out == 'ms')
                return $this->res = self::kn2ms($wind);
            if ($unit_in == 'kn' && $unit_out == 'fts')
                return $this->res = self::kn2fts($wind);
            if ($unit_in == 'kn' && $unit_out == 'kmh')
                return $this->res = self::kn2kmh($wind);
            if ($unit_in == 'kn' && $unit_out == 'mph')
                return $this->res = self::kmh2mph($wind);
        }
    }
    
    public static function ms2kmh($n) {
        return $n * 3.59999999712;
    }
    public static function ms2mph($n) {
        return $n * 2.2369362920544;
    }
    public static function ms2fts($n) {
        return $n * 3.2808398950131;
    }
    public static function ms2kn($n) {
        return $n * 1.9438444924574;
    }
    public static function kmh2ms($n) {
        return $n / 3.59999999712;
    }
    public static function kmh2kn($n) {
        return $n * 0.53995680389235;
    }
    public static function kmh2mph($n) {
        return $n * 0.62137119273443;
    }
    public static function kmh2fts($n) {
        return $n * 0.9113444160105;
    }
    public static function mph2ms($n) {
        return $n * 0.44704;
    }
    public static function mph2kmh($n) {
        return $n * 1.6093439987125;
    }
    public static function mph2fts($n) {
        return $n * 1.4666666666667;
    }
    public static function mph2kn($n) {
        return $n * 0.86897624190816;
    }
    public static function fts2ms($n) {
        return $n * 0.3048;
    }
    public static function fts2kmh($n) {
        return $n * 1.0972799991222;
    }
    public static function fts2mph($n) {
        return $n * 0.68181818181818;
    }
    public static function fts2kn($n) {
        return $n * 0.59248380130101;
    }
    public static function kn2ms($n) {
        return $n * (1852 / 3600);
    }
    public static function kn2fts($n) {
        return $n * 1.6878098570866;
    }
    public static function kn2kmh($n) {
        return $n * 1.8519999985024;
    }
    public static function kn2mph($n) {
        return $n * 1.1507794480136;
    }
    public static function degToCom($num) {
        $val = floor(($num / 22.5) + 0.5);
        $arr = array(
            "N",
            "NNE",
            "NE",
            "ENE",
            "E",
            "ESE",
            "SE",
            "SSE",
            "S",
            "SSW",
            "SW",
            "WSW",
            "W",
            "WNW",
            "NW",
            "NNW"
        );
        return $arr[($val % 16)];
    }
    
}

class dewPoint {
    var $res = null;
    
    function __construct($T, $RH, $t_u = 'c', $formula = 1, $out = null) {
        if (!is_numeric($T) || !is_numeric($RH))
            return $this->res = $T;
        if ($RH > 100 || $RH < 0)
            return;
        if ($formula === 1) {
            $T = new temperature($T, $t_u, 'k');
            $T = $T->res;
            if (is_nan($T))
                return;
            $T = new temperature(self::solve($RH / 100 * self::PVS($T), $T), 'k', $out == null ? $t_u : $out);
        } elseif ($formula === 2) {
            $T = new temperature($T, $t_u, 'c');
            $T = $T->res;
            if (is_nan($T))
                return;
            $T = new temperature(self::solve2($T, $RH), 'c', $out == null ? $t_u : $out);
        } elseif ($formula === 3) {
            $T = new temperature($T, $t_u, 'c');
            $T = $T->res;
            if (is_nan($T))
                return;
            $T = new temperature(self::solve3($T, $RH), 'c', $out == null ? $t_u : $out);
        }
        $T = $T->res;
        if (is_nan($T))
            return;
        return $this->res = $T;
    }
    
    private static function pvsIce($T) {
        
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
    
    private static function PVS($T) {
        if ($T < 173 || $T > 678)
            return null;
        else if ($T < 273.15)
            return self::pvsIce($T);
        else
            return self::pvsWater($T);
    }
    
    private static function solve($y, $x0) {
        $x = $x0;
        $maxCount = 10;
        $count = 0;
        while (TRUE) {
            $xNew;
            $dx = $x / 1000;
            $z = self::PVS($x);
            $xNew = $x + $dx * ($y - $z) / (self::PVS($x + $dx) - $z);
            if (abs(($xNew - $x) / $xNew) < 0.0001)
                return $xNew;
            else if ($count > $maxCount) {
                $xnew = null;
                return 273.15;
            }
            $x = $xNew;
            $count++;
        }
    }
    
    private static function solve2($T, $RH) {
        /* Magnus-Tetens */
        $B = (log($RH / 100) + ((17.27 * $T) / (237.3 + $T))) / 17.27;
        return (237.3 * $B) / (1 - $B);
    }
    
    private static function solve3($T, $RH) {
        return pow($RH / 100, 1 / 8) * (112 + (0.9 * $T)) + (0.1 * $T) - 112;
    }
    
}

class apparentTemp {
    var $res = null;
    function __construct($T, $H, $W, $Q = null, $t_u = 'c', $v_u = 'kmh', $out = null) {
        /*
        Source: Norms of apparent temperature in Australia, Aust. Met. Mag., 1994, Vol 43, 1-16
        More Info http://www.bom.gov.au/info/thermal_stress/#atapproximation
        */
        if (!is_numeric($T) || !is_numeric($H) || !is_numeric($W))
            return false;
        if ($H > 100 || $H < 0)
            return;
        $v_u = strtolower($v_u);
        $T = new temperature($T, $t_u, 'c');
        $T = $T->res;
        if (is_nan($T))
            return;
        $W = new wind($W, $v_u, 'ms');
        $W = $W->res;
        if (is_nan($W))
            return;
        $e = ($H / 100) * 6.105 * exp((17.27 * $T) / (237.7 + $T));
        if ($Q !== null && is_numeric($Q) && $Q >= 0) {
            $old = new temperature($T + 0.33 * $e - 0.7 * $W - 4, 'c', $out == null ? $t_u : $out);
            return $this->res = $old->res;
        }
        $new = new temperature($T + 0.348 * $e - 0.7 * $W + 0.70 * $Q / ($W + 10) - 4.25, 'c', $out == null ? $t_u : $out);
        return $this->res = $new->res;
    }
    
}

class heatIndex {
    var $res = null;
    function __construct($T, $RH, $unit = "f", $out = null) {
        if (!is_numeric($T) || !is_numeric($RH))
            return;
        if ($RH > 100 || $RH < 0)
            return;
        $T = new temperature($T, $unit, 'f');
        $T = $T->res;
        $hi_sp = new temperature(0.5 * ($T + 61.0 + (($T - 68.0) * 1.2) + ($RH * 0.094)), 'f', $out == null ? $unit : $out);
        if ($T < 80 || $T > 112) {
            return $this->res = $hi_sp->res;
        }
        $hi_cp = self::HI($T, $RH);
        if ($T >= 80 && $T <= 87 && $RH > 85) {
            $hi = new temperature($hi_cp + (((13 - $RH) / 4) * sqrt((17 - abs($T - 95)) / 17)), 'f', $out == null ? $unit : $out);
            return $this->res = $hi->res;
        }
        if ($T >= 80 && $T <= 112 && $RH <= 13) {
            $hi = new temperature($hi_cp - (((13 - $RH) / 4) * sqrt((17 - abs($T - 95)) / 17)), 'f', $out == null ? $unit : $out);
            return $this->res = $hi->res;
        }
    }
    
    private static function HI($T, $RH) {
        $c1 = -42.379;
        $c2 = -2.04901523;
        $c3 = -10.14333127;
        $c4 = -0.22475541;
        $c5 = -6.83783e-3;
        $c6 = -5.481717e-2;
        $c7 = -1.22874e-3;
        $c8 = 8.5282e-4;
        $c9 = -1.99e-6;
        return $c1 + $c2 * $T + $c3 * $RH + $c4 * $T * $RH + $c5 * ($T * 2) + $c6 * ($RH * 2) + $c7 * ($T * 2) * $RH + $c8 * $T * ($RH * 2) + $c9 * ($T * 2) * ($RH * 2);
    }
}

class windChill {
    
    /*
    North American and United Kingdom wind chill index
    In November 2001, Canada, the U.S., and the U.K. implemented a new wind chill index developed by scientists and medical experts on the Joint Action Group for Temperature Indices (JAG/TI). It is determined by iterating a model of skin temperature under various wind speeds and temperatures using standard engineering correlations of wind speed and heat transfer rate. Heat transfer was calculated for a bare face in wind, facing the wind, while walking into it at 1.4 metres per second (3.1 mph). The model corrects the officially measured wind speed to the wind speed at face height, assuming the person is in an open field.
    */
    var $res;
    function __construct($T, $V, $type = true, $t_u = 'c', $v_u = 'kmh', $out = null) {
        if (!is_numeric($T) || !is_numeric($V))
            return false;
        $T = new temperature($T, $t_u, 'f');
        $T = $T->res;
        $V = new wind($V, $v_u, 'mph');
        $V = $V->res;
        if ($type == false) {
            $wc = new temperature(0.0817 * (3.71 * pow($V, 0.5) + 5.81 - 0.25 * $V) * ($T - 91.4) + 91.4, 'f', $out == null ? $t_u : $out);
            return $this->res = $wc->res; // old 
        }
        $wc = new temperature(35.74 + 0.6215 * $T - 35.75 * pow($V, 0.16) + 0.4275 * $T * pow($V, 0.16), 'f', $out == null ? $t_u : $out);
        return $this->res = $wc->res;
    }
}


?>

<?php

class dewPoint {
    
    /*
    Compute dewPoint for given temperature T[Deg.C] and relative humidity RH[%].
    */
    
    function __construct($T, $RH) {
        if (!is_numeric($T)) {
            $this->res = $T;
            return;
        }
        $T = $T + 273.15; // C to K
        $this->res = self::solve($RH / 100 * self::PVS($T), $T) - 273.15;
        return;
    }
    
    /*
     * Saturation Vapor Pressure formula for range -100..0 Deg. C.
     * This is taken from
     *   ITS-90 Formulations for Vapor Pressure, Frostpoint Temperature,
     *   Dewpoint Temperature, and Enhancement Factors in the Range 100 to +100 C
     * by Bob Hardy
     * as published in "The Proceedings of the Third International Symposium on Humidity & Moisture",
     * Teddington, London, England, April 1998
     */
    
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
    
    /*
     * Saturation Vapor Pressure formula for range 273..678 Deg. K.
     * This is taken from the
     *   Release on the IAPWS Industrial Formulation 1997
     *   for the Thermodynamic Properties of Water and Steam
     * by IAPWS (International Association for the Properties of Water and Steam),
     * Erlangen, Germany, September 1997.
     *
     * This is Equation (30) in Section 8.1 "The Saturation-Pressure Equation (Basic Equation)"
     */
    
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
    
    /*
    Compute Saturation Vapor Pressure for minT<T[Deg.K]<maxT.
    */
    private static function PVS($T) {
        if ($T < 173 || $T > 678)
            return null;
        else if ($T < 273.15)
            return self::pvsIce($T);
        else
            return self::pvsWater($T);
    }
    
    /*
    Newton's Method to solve f(x)=y for x with an initial guess of x0.
    */
    private static function solve($y, $x0) {
        $x = $x0;
        $maxCount = 10;
        $count = 0;
        do {
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
        } while (TRUE);
    }
}
?>

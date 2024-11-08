<?php

namespace WtConverter;

class dewPoint {
    var $res = null;

    /**
     * Costruttore della classe dewPoint.
     * @param float $T La temperatura iniziale.
     * @param float $RH L'umidità relativa (in %).
     * @param string $t_u L'unità della temperatura iniziale (predefinito: 'c' per Celsius).
     * @param int $formula Il metodo di calcolo del punto di rugiada (1, 2 o 3).
     * @param string|null $out L'unità di output per il punto di rugiada.
     */
    function __construct($T, $RH, $t_u = 'c', $formula = 1, $out = null) {
        if (!is_numeric($T) || !is_numeric($RH)) {
            return $this->res = null; // Se i dati non sono numerici, ritorna null.
        }
        if ($RH < 0 || $RH > 100) {
            return $this->res = null; // Se l'umidità relativa è fuori dal range, ritorna null.
        }

        // Converte la temperatura nel formato richiesto (Kelvin per i calcoli interni)
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
        // Calcola la pressione di vapore in base alla temperatura
        if ($T < 273.15) {
            return self::pvsIce($T); // Usa il modello per il ghiaccio se sotto 0°C
        } else {
            return self::pvsWater($T); // Usa il modello per l'acqua sopra 0°C
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
        // Metodo iterativo per risolvere l'equazione di punto di rugiada
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
<?php

namespace WtConverter;

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

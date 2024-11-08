<?php

namespace WtConverter;

class windChill {
    var $res;

    // Costruttore per calcolare l'indice di raffreddamento da vento
    function __construct($T, $V, $type = true, $t_u = 'c', $v_u = 'kmh', $out = null) {
        // Verifica che i parametri siano numerici
        if (!is_numeric($T) || !is_numeric($V)) {
            return false; // Se i parametri non sono numerici, ritorna false
        }

        // Converte la temperatura nell'unità desiderata (in Fahrenheit)
        $T = new Temperature($T, $t_u, 'f');
        $T = $T->res;

        // Converte la velocità del vento nell'unità desiderata (in mph)
        $V = new Wind($V, $v_u, 'mph');
        $V = $V->res;

        // Calcola l'indice di raffreddamento da vento
        if ($type == false) {
            // Usa la formula vecchia per il wind chill (utilizzata precedentemente)
            $wc = new Temperature(0.0817 * (3.71 * pow($V, 0.5) + 5.81 - 0.25 * $V) * ($T - 91.4) + 91.4, 'f', $out ?? $t_u);
        } else {
            // Usa la formula aggiornata per il wind chill (formula attualmente in uso)
            $wc = new Temperature(35.74 + 0.6215 * $T - 35.75 * pow($V, 0.16) + 0.4275 * $T * pow($V, 0.16), 'f', $out ?? $t_u);
        }

        // Restituisce il risultato finale dell'indice di raffreddamento da vento
        return $this->res = $wc->res;
    }
}

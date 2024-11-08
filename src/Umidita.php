<?php

namespace WtConverter;

class Humidity {
    
    public $res = false;

    /**
     * @param float $T La temperatura in gradi Celsius
     * @param float $RH L'umidità relativa in percentuale (0 - 100)
     * @return float|null Ritorna l'umidità assoluta in g/m³, o null se i valori non sono validi
     */
    public static function calculateAbsoluteHumidity($T, $RH) {
        if ($RH < 0 || $RH > 100 || !is_numeric($T) || !is_numeric($RH)) {
            return null; // Se i dati non sono validi, ritorna null.
        }
        
        // Calcola la pressione di saturazione del vapore acqueo in hPa
        $T_kelvin = $T + 273.15;
        $Pvs = 6.112 * exp((17.67 * $T) / ($T + 243.5));
        
        // Calcola l'umidità assoluta (g/m³)
        $AH = (216.7 * ($Pvs * $RH / 100)) / $T_kelvin;
        
        return $AH;
    }

    /**
     * @param float $AH L'umidità assoluta in g/m³
     * @param float $T La temperatura in gradi Celsius
     * @return float|null Ritorna l'umidità specifica in kg/kg o null se i valori non sono validi
     */
    public static function calculateSpecificHumidity($AH, $T) {
        if (!is_numeric($AH) || !is_numeric($T)) {
            return null; // Se i dati non sono validi, ritorna null.
        }
        
        // Umidità specifica (kg di vapore acqueo / kg di aria)
        $specificHumidity = $AH / (1000 + AH);
        
        return $specificHumidity;
    }

    /**
     * @param float $T La temperatura in gradi Celsius
     * @param float $AH L'umidità assoluta in g/m³
     * @return float|null Ritorna l'umidità relativa in percentuale o null se i valori non sono validi
     */
    public static function calculateRelativeHumidity($T, $AH) {
        if (!is_numeric($T) || !is_numeric($AH)) {
            return null; // Se i dati non sono validi, ritorna null.
        }
        
        // Pressione di saturazione del vapore acqueo
        $Pvs = 6.112 * exp((17.67 * $T) / ($T + 243.5));
        
        // Calcolo dell'umidità relativa
        $RH = ($AH * ($T + 273.15)) / (216.7 * $Pvs) * 100;
        
        return $RH;
    }

    /**
     * Ottiene il risultato dell'umidità calcolata.
     * @return float|null Il valore calcolato dell'umidità o null se non è stato calcolato
     */
    public function getResult() {
        return $this->res;
    }
}

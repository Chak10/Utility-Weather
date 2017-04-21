
# Info 

```php
require('class/Utility/converter.php');

use \wt_converter\dewPoint as dewP;
use \wt_converter\apparentTemp as appT;
use \wt_converter\heatIndex as heatI;
use \wt_converter\windChill as windC;
```

## Dewpoint

Compute Dewpoint for given temperature T[°C or °F] and relative humidity RH[%].

### Use

```php
function __construct($T, $RH, $unit = "f") {
```
- **$T = Temperature => Int => Celsius or Fahrenheit or Kelvin (Specify in variable $unit)**
- **$RH = Humidity => Int => Relative Humidity[%]**
- **$unit = Temperature Unit => String => **
	1. Celsius => c
	1. Fahrenheit => f
	1. Kelvin => k
```php
$dw = new dewP($temperature,$humidity); //If the temperature is in degrees Celsius.
$dw = $dw->res; // int

$dw = new dewP($temperature,$humidity,'f'); //If the temperature is in degrees Fahrenheit.
$dw = $dw->res; // int
```


### Credits

[Equations of IAPWS-IF97, Section 5. "Equations for Region 4".](https://github.com/Chak10/weather/blob/master/resources/IF97.pdf)

[Release on the IAPWS Industrial Formulation 1997 for the Thermodynamic Properties of Water and Steam, Section 5. "Equations for Region 4".](https://github.com/Chak10/weather/blob/master/resources/IF97.pdf)

[ITS-90 FORMULATIONS FOR VAPOR PRESSURE, FROSTPOINT TEMPERATURE, DEWPOINT TEMPERATURE](https://github.com/Chak10/weather/blob/master/resources/IT90.pdf)

[IAPWS-IF97-REV2012](https://github.com/Chak10/weather/blob/master/resources/IF97-Rev.pdf)

[Wolfgang Kuehn](http://www.decatur.de/javascript/dew/)

## Apparent Temperature (Australian)

The formula for the Apparent Temperature used by the Bureau of Meteorology is an approximations of the value provided by a mathematical model of heat balance in the human body. It can include the effects of temperature, humidity, wind-speed and radiation. Two forms are given, one including radiation and one without.

### Use

```php
function __construct($T, $H, $W, $Q = null,$t_u = null, $v_u = null){}
```

- **$T = Temperature => Int => Celsius or Fahrenheit or Kelvin (Specify in variable $ t_u)**
- **$H = Humidity => Int => Relative Humidity[%]**
- **$W = Wind Speed => Int => m/s or ft/s or mi/h or km/h or knots (Specify in variable $ v_u)**
- **$Q = Solar radiation => Int => W/m²**
- **$t_u = Temperature Unit => String =>**
	1. Celsius => c
	1. Fahrenheit => f
	1. Kelvin => k
**$v_u = Wind Unit => String =>**
	1. ft/s => fts
	1. m/s => ms
	1. mi/h => mph
	1. kmh => kmh
	1. Knots => kn

```php
$at = new appT($temperature,$humidity,$windspeed,null,'c','mph'); //If the temperature is in degrees Celsius and wind speed is in mi/h.
$at = $at->res; // int

$at = new appT($temperature,$humidity,$windspeed,null,'f','kmh'); //If the temperature is in degrees Fahrenheit and wind speed is in km/h.
$at = $at->res; // int
```

### Credits

[Commonwealth of Australia , Bureau of Meteorology](http://www.bom.gov.au/info/thermal_stress/)

## Heat Index (American)

The heat index (HI) or humiture or humidex (not to be confused with the Canadian humidex) is an index that combines air temperature and relative humidity, in shaded areas, as an attempt to determine the human-perceived equivalent temperature, as how hot it would feel if the humidity were some other value in the shade.

### Use

```php
function __construct($T, $RH, $unit = "f") {
```

- **$T = Temperature => Int => Celsius or Fahrenheit or Kelvin (Specify in variable $unit)**
- **$RH = Humidity => Int => Relative Humidity[%]**
- **$unit = Temperature Unit => String =>**
	1. Celsius => c
	1. Fahrenheit => f
	1. Kelvin => k

```php
$hi = new heatI($temperature,$humidity); //If the temperature is in degrees Celsius.
$hi = $hi->res; // int

$hi = new heatI($temperature,$humidity,'f'); //If the temperature is in degrees Fahrenheit.
$hi = $hi->res; // int
```

### Credits

[NOAA's National Weather Service](http://www.wpc.ncep.noaa.gov/html/heatindex_equation.shtml)

## Wind Chill (New and Old Type)

Wind-chill or windchill, (popularly wind chill factor) is the perceived decrease in air temperature felt by the body on exposed skin due to the flow of air.

Wind chill numbers are always lower than the air temperature for values where the formula is valid. When the apparent temperature is higher than the air temperature, the heat index is used instead.

### Use

```php
function __construct($T, $V, $type = true, $t_u = null, $v_u = null){}
```
- **$T = Temperature => Int => Celsius or Fahrenheit or Kelvin (Specify in variable $ t_u)**

- **$V = Wind Speed => Int => m/s or ft/s or mi/h or km/h or knots (Specify in variable $ v_u)**

- **$type = Formula Type => boolean =>** 
	1. With TRUE use the new formula[1]
	1. With FALSE use the old formula[2]

- **$t_u = Temperature Unit => String =>**
	1. Celsius => c
	1. Fahrenheit => f
	1. Kelvin => k

- **$v_u = Wind Unit => String => **
	1. ft/s => fts
	1. m/s => ms
	1. mi/h => mph
	1. kmh => kmh
	1. Knots => kn

_[1] WC New = 35.74 + 0.6215T - 35.75 x V^0.16 + 0.4275 x T x V^0.16_

_[2] WC Old = 0.0817(3.71 x V^0.5 + 5.81 -0.25 x V)(T - 91.4) + 91.4_

```php
$at = new appT($temperature,$humidity,$windspeed,null,'c','mph'); //If the temperature is in degrees Celsius and wind speed is in mi/h.
$at = $at->res; // int

$at = new appT($temperature,$humidity,$windspeed,null,'f','kmh'); //If the temperature is in degrees Fahrenheit and wind speed is in km/h.
$at = $at->res; // int
```

### Credits

[Wikipedia](https://en.wikipedia.org/wiki/Wind_chill)
[USATODAY.com](http://usatoday30.usatoday.com/weather/winter/windchill/wind-chill-formulas.htm)


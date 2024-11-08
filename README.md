# Weather Converter

Weather Converter is a PHP-based tool designed to convert weather data between different units and formats. This project is intended for developers looking to integrate weather data conversion functionality into their applications.

## Features
- Convert temperature, wind speed, and pressure between different units.
- Easy integration with your existing PHP applications.
- Supports both metric and imperial units.

## Installation

1. Clone the repository:
    ```bash
    git clone https://github.com/chak10/weather-converter.git
    ```

2. Install dependencies using Composer:
    ```bash
    composer install
    ```

## Usage

Simply include the `WeatherConverter` class in your PHP code and use the methods to convert weather data between units.

Example:

```php
use WtConverter\Temperature;

$temp = new Temperature(25, 'c', 'f');
echo $temp->getResult(); // Output: 77 (Fahrenheit)

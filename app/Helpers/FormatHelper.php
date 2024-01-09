<?php

if (!function_exists('formatCurrency')) {
  /**
   * Format numeric value to currency format.
   *
   * @param float $value
   * @param string $currencySymbol
   * @param int $decimalPlaces
   * @param string $decimalSeparator
   * @param string $thousandsSeparator
   * @return string
   */
  function formatCurrency($value, $currencySymbol = 'Rp.', $decimalPlaces = 2, $decimalSeparator = ',', $thousandsSeparator = '.')
  {
    return $currencySymbol . number_format($value, $decimalPlaces, $decimalSeparator, $thousandsSeparator);
  }
}

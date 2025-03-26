<?php
/**
 * Here is your custom functions.
 */
if (!function_exists('checkPass')) {
    /**
     * 是否通过验证
     * @param bool $condition
     * @return string
     */
    function checkPass(bool $condition): string
    {
        return $condition ? '<p class="text-success font-bold"><i class="icon icon-check icon-2x"></i></p>' : '<p class="text-danger font-bold"><i class="icon icon-times icon-2x"></i></p>';
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Andrew Tait (1504693)
 * Date: 02/04/2017
 * Time: 17:59
 * Form functions used for all forms across the website
 */

function comboInputSetup($isRequired, $labelDescription, $labelControlName, $selected, $options, $isReadOnly = false)
{
    if ($isRequired) {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '" disabled>';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>
                    <span class="required">* </span>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        }
    } else {
        if ($isReadOnly) {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '" disabled>';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        } else {
            $output = '<div class="large-12 medium-12 small-12 columns">
                <label><b>' . $labelDescription . '</b>
                <select id="' . $labelControlName . '" name="' . $labelControlName . '">';
            foreach ($options as $key => $value) {
                if ($labelDescription === "Rank") {
                    if ($value == $selected) {
                        $output .= '<option selected="selected" value="' . $value . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $value . '">' . $value . '</option>';
                    }
                } else {
                    if ($value == $selected || $key == $selected) {
                        $output .= '<option selected="selected" value="' . $key . '">' . $value . '</option>';
                    } else {
                        $output .= '<option value="' . $key . '">' . $value . '</option>';
                    }
                }
            }
            $output .= '</select>
                </label>
            </div>';
            return $output;
        }
    }
}

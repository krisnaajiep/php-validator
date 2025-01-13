<?php

namespace KrisnaAjieP\PHPValidator;

use KrisnaAjieP\PHPValidator\Validator;

/**
 * This class provides a set of validation rules for validating input data.
 * It supports various validation rules such as required, alpha, alpha_num, 
 * alpha_num_space, array_string, num, lowercase, min_length, max_length, 
 * numeric, email, match, phone_number, and date.
 * It also provides methods to set validation errors, check for validation 
 * errors, and retrieve validated data.
 */
class Rule extends Validator
{
    /**
     * Validates the value against the alpha_num rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function alpha_num($rule, $value, $field, $data = []): void
    {
        if ($rule === "alpha_num") {
            if (!preg_match("/^[a-zA-Z0-9. _-]+$/", $value)) {
                self::setValidationError($field, $field . " input may only contain letters, spaces, numbers, periods (.), underscores (_), and hyphens (-).");
            }
        }
    }

    /**
     * Validates the value against the alpha rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function alpha($rule, $value, $field, $data = []): void
    {
        if ($rule === "alpha") {
            if (!preg_match("/^[a-zA-Z. _-]+$/", $value)) {
                self::setValidationError($field, $field . " input may only contain letters, spaces, periods (.), underscores (_), and hyphens (-).");
            }
        }
    }

    /**
     * Validates the value against the array_string rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function array_string($rule, $value, $field, $data = []): void
    {
        if ($rule === "array_string") {
            if (!is_array($value)) {
                self::setValidationError($field, $field . " input must be an array.");
            } else {
                foreach ($value as $item) {
                    if (!is_string($item)) {
                        self::setValidationError($field, $field . " input must be an array of strings.");
                        break;
                    }
                }
            }
        }
    }

    /**
     * Validates the value against the num rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function num($rule, $value, $field, $data = []): void
    {
        if ($rule === "num") {
            if (!is_numeric($value)) {
                self::setValidationError($field, $field . " input must be a number.");
            }
        }
    }

    /**
     * Validates the value against the lowercase rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function lowercase($rule, $value, $field, $data = []): void
    {
        if ($rule === "lowercase") {
            if (strtolower($value) !== $value) {
                self::setValidationError($field, $field . " input must be all lowercase.");
            }
        }
    }

    /**
     * Validates the value againts the minimum length rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function min_length($rule, $value, $field, $data = []): void
    {
        if (str_contains($rule, "min_length") && str_contains($rule, ":")) {
            $rule = explode(":", $rule)[1];

            if (strlen($value) < (int)$rule) {
                self::setValidationError($field, $field . " input must be at least {$rule} characters long.");
            }
        }
    }

    /**
     * Validates the value against the maximum length rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function max_length($rule, $value, $field, $data = []): void
    {
        if (str_contains($rule, "max_length") && str_contains($rule, ":")) {
            $rule = explode(":", $rule)[1];

            if (strlen($value) > (int)$rule) {
                self::setValidationError($field, $field . " input must not exceed {$rule} characters.");
            }
        }
    }

    /**
     * Validates the value against the email rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function email($rule, $value, $field, $data = []): void
    {
        if ($rule === "email") {
            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                self::setValidationError($field, $field . " input must be a valid email address.");
            }
        }
    }

    /**
     * Validates the value against the match rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function match($rule, $value, $field, $data = []): void
    {
        if (str_contains($rule, "match") && str_contains($rule, ":")) {
            $match = explode(":", $rule);
            if ($value !== $data[$match[1]]) {
                self::setValidationError($field, $field . " doesn't match.");
            }
        }
    }

    /**
     * Validates the value against the phone_number rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function phone_number($rule, $value, $field, $data = []): void
    {
        if ($rule === "phone_number") {
            if (!preg_match("/^[0-9-+]+$/", $value)) {
                self::setValidationError($field, $field . " input may only contain numbers, hyphens (-), and plus (+).");
            }
        }
    }

    /**
     * Validates the value against the date rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return void
     */
    public static function date($rule, $value, $field, $data = []): void
    {
        if ($rule === "date") {
            $date = date_parse($value);

            if (!checkdate($date['month'], $date['day'], $date['year'])) {
                self::setValidationError($field, $field . " input must be a valid date.");
            }
        }
    }
}

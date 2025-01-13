<?php

namespace KrisnaAjieP\PHPValidator;

/**
 * This class provides a set of validation rules for validating input data.
 * It supports various validation rules such as required, alpha, alpha_num, 
 * alpha_num_space, array_string, num, lowercase, min_length, max_length, 
 * numeric, email, match, phone_number, and date.
 * It also provides methods to set validation errors, check for validation 
 * errors, and retrieve validated data.
 */
class Validator
{
    /**
     * Array to store validation errors and validated data
     *
     * @var array $validation_errors Array to store validation errors
     */
    private static array $validation_errors = [];

    /**
     * Validates the given input based on the specified rules.
     *
     * @param array $input The input data to be validated.
     * @param array $rules The validation rules to apply.
     * @return object Returns an instance of the Validator class.
     */
    public static function setRules(array $data, array $rules): object
    {

        foreach ($rules as $field => $ruleset) {
            $value = $data[$field] ?? null;

            foreach ($ruleset as $rule) {
                if (!isset(self::$validation_errors[$field])) {
                    self::validate($value, $rule, $field, $data);
                }
            }
        }

        return new self();
    }

    /**
     * Validates a single value against a specific rule.
     *
     * @param mixed $value The value to be validated.
     * @param string $rule The validation rule to apply.
     * @param string $field The name of the field being validated.
     * @param array $data The entire input data array for cross-field validation.
     * @return mixed The validated value.
     */
    private static function validate($value, string $rule, string $field, array $data): mixed
    {
        if ($rule === "required" && empty($value)) {
            self::setValidationError($field, $field . " field is required.");
        }

        if ($rule !== "required" && !empty($value)) {
            if (str_contains($rule, ":")) {
                $method = explode(":", $rule)[0];
            } else {
                $method = $rule;
            }

            call_user_func_array([Rule::class, $method], [$rule, $value, $field, $data]);
        }

        return $value;
    }

    /**
     * Sets a validation error message for a specific field.
     *
     * @param string $field The name of the field that has the validation error.
     * @param string $message The validation error message to be set.
     * @return void
     */
    public static function setValidationError(string $field, string $message): void
    {
        self::$validation_errors[$field] = $message;
    }


    /**
     * Check if there are any validation errors.
     *
     * This method returns a boolean indicating whether there are any
     * validation errors present in the static property $validation_errors.
     *
     * @return bool True if there are validation errors, false otherwise.
     */
    public function hasValidationErrors(): bool
    {
        return !empty(self::$validation_errors);
    }

    /**
     * Checks if there is a validation error for a specific field.
     *
     * @param string $field The name of the field to check for validation errors.
     * @return bool Returns true if there is a validation error for the field, false otherwise.
     */
    public static function hasValidationError(string $field): bool
    {
        return isset(self::$validation_errors[$field]);
    }

    /**
     * Retrieves the validation errors and resets the validation errors array.
     *
     * @return array An array of validation errors.
     */
    public function getValidationErrors(): array
    {
        $validation_errors = self::$validation_errors ?? [];
        self::$validation_errors = [];

        return $validation_errors;
    }
}

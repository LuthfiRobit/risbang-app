<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class WordCount implements ValidationRule
{
    protected $min;
    protected $max;

    /**
     * Create a new rule instance.
     *
     * @param  int  $min
     * @param  int  $max
     */
    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $wordCount = str_word_count($value);

        if ($wordCount < $this->min || $wordCount > $this->max) {
            $fail("The :attribute must be between {$this->min} and {$this->max} words.");
        }
    }
}

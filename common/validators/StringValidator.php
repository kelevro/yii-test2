<?php


namespace common\validators;


class StringValidator extends \yii\validators\StringValidator
{
    public $withoutSpaces = false;

    /**
     * @inheritdoc
     */
    public function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if (!is_string($value)) {
            $this->addError($object, $attribute, $this->message);
            return;
        }

        if ($this->withoutSpaces) {
            $value = str_replace(' ', '', $value);
        }
        $length = mb_strlen($value, $this->encoding);

        if ($this->min !== null && $length < $this->min) {
            $this->addError($object, $attribute, $this->tooShort, ['min' => $this->min]);
        }
        if ($this->max !== null && $length > $this->max) {
            $this->addError($object, $attribute, $this->tooLong, ['max' => $this->max]);
        }
        if ($this->length !== null && $length !== $this->length) {
            $this->addError($object, $attribute, $this->notEqual, ['length' => $this->length]);
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!is_string($value)) {
            return [$this->message, []];
        }

        if ($this->withoutSpaces) {
            $value = str_replace(' ', '', $value);
        }
        $length = mb_strlen($value, $this->encoding);

        if ($this->min !== null && $length < $this->min) {
            return [$this->tooShort, ['min' => $this->min]];
        }
        if ($this->max !== null && $length > $this->max) {
            return [$this->tooLong, ['max' => $this->max]];
        }
        if ($this->length !== null && $length !== $this->length) {
            return [$this->notEqual, ['length' => $this->length]];
        }

        return null;
    }


}
<?php

namespace app\base\validators;


use app\base\models\interfaces\StartFinishModelInterface;
use yii\base\Exception;
use yii\base\Model;
use yii\validators\DateValidator;
use yii\validators\Validator;

class AfterDateValidator extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if(!in_array(StartFinishModelInterface::class, class_implements($model))) {
            $this->addError($model, $attribute, 'Ошибка ADV17: Проблема с валидацией формы. Обратитесь к администратору');
            return;
        }

        /**
         * @var $model Model|StartFinishModelInterface
         */

        if($attribute === $model->getStartDate()) {
            $startDate = $model->$attribute;
            $finishDateAttribute = $model->getFinishDate();
            $finishDate = $model->$finishDateAttribute;
        } elseif($attribute === $model->getFinishDate()) {
            $finishDate = $model->$attribute;
            $startDateAttribute = $model->getStartDate();
            $startDate  = $model->$startDateAttribute;
        } else {
            throw new Exception('Валидация данного типа применима к аттрибутам, возвращаемым методами интерфеса');
        }

        $obValidator = Validator::createValidator(
            DateValidator::class,
            $model,
            array($model->getStartDate(), $model->getFinishDate()),
            array(
                'format' => 'yyyy-MM-dd'
            )
        );

        if(!$obValidator->validate($startDate)) {
            $this->addError(
                $model,
                $model->getStartDate(),
                'Поле "{startDate}" должно быть заполнено',
                array(
                    'startDate' => $model->getAttributeLabel($model->getStartDate())
                )
            );
        } elseif(strlen($finishDate) > 0 && !$obValidator->validate($finishDate)) {
            $this->addError(
                $model,
                $model->getFinishDate(),
                'Поле "{finishDate}" должно быть корректной датой',
                array(
                    'finishDate' => $model->getAttributeLabel($model->getFinishDate())
                )
            );
        } else {
            $startDate = \DateTime::createFromFormat('Y-m-d', $startDate);
            $finishDate = \DateTime::createFromFormat('Y-m-d', $finishDate);
            if($startDate && $finishDate && $finishDate->getTimestamp() < $startDate->getTimestamp()) {
                foreach ( array($model->getFinishDate(), $model->getStartDate()) as $currentAttribute) {
                    $this->addError(
                        $model,
                        $currentAttribute,
                        'Поле "{finishDate}" раньше поля "{startDate}"',
                        array(
                            'startDate' => $model->getAttributeLabel($model->getStartDate()),
                            'finishDate' => $model->getAttributeLabel($model->getFinishDate())
                        )
                    );
                }
            }
        }
    }
}
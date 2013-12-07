<?php

class Orm_Registry {
    public static $models = [];
    public static $model_classes = [];
    public static $finder_classes = [];

    public static function registerModel($model, $model_class, $finder_class) {
        self::$models[$model] = [
            'model_class' => $model_class,
            'finder_class' => $finder_class,
        ];

        self::$model_classes[$model_class] = [
            'model' => $model,
            'finder_class' => $finder_class,
        ];

        self::$finder_classes[$finder_class] = [
            'model' => $model,
            'model_class' => $model_class,
        ];
    }
}

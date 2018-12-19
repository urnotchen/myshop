<?php

namespace common\traits;

trait FindOrExceptionTrait
{
    /**
     * @param array $where
     * @param bool $closure
     * @return static
     * @throws \yii\web\HttpException
     */
    public static function findOneOrException(array $where, $closure = false)
    {
        $query = static::find();

        $query->andWhere($where);

        if ($closure instanceof \Closure) {
            $closure($query);
        }

        $model = $query->one();

        if (empty($model)) {
            throw new \yii\web\HttpException(
                404,
                'required item not found.',
                \common\components\ResponseCode::ENTITY_NOT_FOUND
            );
        }

        return $model;
    }

    /**
     * @param array $where
     * @param bool $closure
     * @return array object
     * @throws \yii\web\HttpException
     */
    public static function findAllOrException(array $where, $closure = false)
    {
        $query = static::find();

        $query->andWhere($where);

        if ($closure instanceof \Closure) {
            $closure($query);
        }

        $model = $query->all();

        if (empty($model)) {
            throw new \yii\web\HttpException(
                404,
                'required item not found.',
                \common\components\ResponseCode::ENTITY_NOT_FOUND
            );
        }

        return $model;
    }

}

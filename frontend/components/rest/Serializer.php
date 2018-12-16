<?php

namespace frontend\components\rest;

use yii\base\Model;
use yii\base\Arrayable;
use yii\data\DataProviderInterface;
use yii\data\Pagination as YiiPagination;


class Serializer extends \yii\rest\Serializer
{

    public $collectionEnvelope = 'list';
    public $metaEnvelope = '_meta';

    public function serialize($data)
    {

        # [model.hasErrors]
        if ($data instanceof Model && $data->hasErrors()) {
            return $this->serializeModelErrors($data);
        }
        # [model,model...]
        elseif (is_array($data) && current($data) instanceof Arrayable){
            return $this->serializeModels($data);
        }
        # {model}
        elseif ($data instanceof Arrayable) {
            return $this->serializeModel($data);
        }
        elseif ($data instanceof DataProviderInterface) {
            return $this->serializeDataProvider($data);
        }
        else {
            return $data;
        }

    }

    protected function serializePagination($pagination)
    {
        return [
            $this->metaEnvelope => [
                'totalCount'  => $pagination->totalCount,
                'pageCount'   => $pagination->getPageCount(),
                'currentPage' => $pagination->getPage() + 1,
                'perPage'     => $pagination->getPageSize(),
                'hasMore'     => $this->hasMore($pagination),
            ],
        ];
    }

    public function hasMore(YiiPagination $pagination)
    {
        return $pagination->getPage() + 1 < $pagination->getPageCount();
    }

}


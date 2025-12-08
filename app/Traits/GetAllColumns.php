<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Database\Eloquent\Relations;

trait GetAllColumns
{
    public function ownAndRelatedModelsFillableColumns(): Collection
    {
        $ownColumns = [
            'model' => class_basename($this),
            'name' => Str::title(Str::replace('_', ' ', $this->getTable())),
            'table_name' => $this->getTable(),
            'columns' => $this->getColumns($this->getTable())
        ];

        return $this->relatedModels()
            ->map(function ($model) {
                $modelName = $this->$model()->getRelated();
                return [
                    'model' => $model,
                    'name' => Str::title(Str::replace('_', ' ', $modelName->getTable())),
                    'table_name' => $modelName->getTable(),
                    'columns' => $this->getColumns($modelName->getTable())
                ];
            })
            ->prepend($ownColumns);
    }

    public function relatedModels(): Collection
    {
        $ref = new ReflectionClass($this);

        return collect($ref->getMethods())
            ->filter(function (ReflectionMethod $reflectionMethod) {
                return in_array($reflectionMethod->getReturnType(), [
                    //Relations\BelongsTo::class,
//                    Relations\BelongsToMany::class,
                    Relations\HasMany::class,
//                    Relations\HasManyThrough::class,
//                    Relations\HasOne::class,
//                    Relations\HasOneThrough::class,
//                    Relations\Relation::class,
                ]);
            })
            ->map(function (ReflectionMethod $reflectionMethod) {
                return $reflectionMethod->getName();
            })
            ->values();
    }


    public function getColumns($table): Collection
    {
        $tableColumnInfos = collect(DB::select("SHOW FULL COLUMNS FROM `$table`"));

        $array = $this->getTableColumns($tableColumnInfos);

        return collect(array_values($array));
    }


    /**
     * @param Collection $tableColumnInfos
     * @param bool $checkByComment
     * @return mixed
     */
    public function getTableColumns(Collection $tableColumnInfos, bool $checkByComment = true): mixed
    {
        if ($checkByComment) {
            $columns = $tableColumnInfos
                ->filter(function ($column) {
                    return !empty($column->Comment);
                })
                ->map(function ($column) {
                    return [
                        'name' => $column->Comment,
                        'column' => $column->Field
                    ];
                })
                ->toArray();
        } else {
            $columns = $tableColumnInfos
                ->map(function ($column) {
                    return ['column' => $column->Field];
                })
                ->toArray();
        }

        return $columns;
    }
}

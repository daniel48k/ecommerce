<?php

namespace App\Repositories;

use App\Models\Category;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version June 19, 2021, 9:21 am UTC
 */
class CategoryRepository extends BaseRepository
{

    /**
     * @var array
     */
    protected $fieldSearchable = ['name'];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    public function delete($id)
    {
        $model = $this->model->newQuery()->findOrFail($id);
        return (!$model->sub_categories()->exists()) && parent::delete($id);
    }
}

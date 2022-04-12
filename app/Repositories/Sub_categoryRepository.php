<?php

namespace App\Repositories;

use App\Models\Sub_category;
use App\Repositories\BaseRepository;

/**
 * Class Sub_categoryRepository
 * @package App\Repositories
 * @version June 19, 2021, 9:22 am UTC
 */
class Sub_categoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'category_id'
    ];

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
        return Sub_category::class;
    }

    public function delete($id)
    {
        $model = $this->find($id);
        return $model->products()->doesntExist() && parent::delete($id);
    }
}

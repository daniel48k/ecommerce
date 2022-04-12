<?php

namespace App\Repositories;

use App\Http\Traits\ImageFileUploadTrait;
use App\Models\Product;
use App\Repositories\Traits\ProductFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProductRepository
 * @package App\Repositories
 */
class ProductRepository extends BaseRepository
{
    use ProductFilters, ImageFileUploadTrait;

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title',
        'description',
        'sub_category_id',
        'price',
        'description',
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
        return Product::class;
    }

    public function filter(Request $request)
    {
        $query = $this->applyFilters($request->query)->query_filter;
        if ($request->sortBy && in_array($request->sortBy, $this->fieldSearchable)) {
            $query->orderBy($request->sortBy);
        }
        if ($request->search) {
            $query->where('products.title', 'like', '%' . $request->search . '%')->orwhere('products.price', 'like', '%' . $request->search . '%');
        }
        return ($request->show) ? $query->paginate($request->show) : $query->paginate(9);
    }

    public function updateWithPhoto(Request $request, $id)
    {
        $query = $this->model->newQuery();
        $model = $query->findOrFail($id);

        $input = $request->all();

        $input['photo'] = $this->saveFile($request, 'photo', Product::FILE_PATH);
        $this->deleteFile(Product::FILE_PATH . '/' . $model->photo);
        return parent::update($input, $id);
    }

    public function delete($id)
    {
        $model = $this->model->newQuery()->findOrFail($id);
        return (!$model->carts()->exists()) && parent::delete($id);
    }

}

<?php

namespace Modules\Backend\Http\Controllers;

use App\Components\FileUpload;
use App\Entities\Category;
use App\Entities\Themes;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class CategoryController extends BaseBackendController
{
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getCategories();
        return $this->view('category.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->getCategories();
        $themes = Themes::pluck('name', 'id');

        $products = $this->productRepository->with(['categories'])->all();

        return $this->view('category.create', [
            'categories' => $categories,
            'products' => $products,
            'themes' => $themes,
        ]);

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name|max:100',
            'slug' => 'required|unique:categories,slug',
            'image' => 'mimes:jpeg,jpg,png,gif|max:2048',
            'category_id' => 'integer|exists:categories',
        ]);

        $category = $this->categoryRepository->create($this->buildData($request));
        \Message::success(['Category successfully created.']);

        return redirect()->route('category.edit', $category->id);
    }

    public function edit($id)
    {
        $categories = $this->categoryRepository->getCategories();
        $category = $this->categoryRepository->with(['parentCategory', 'products'])->find($id);
        $themes = Themes::pluck('name', 'id');

        foreach ($category->products as $key) {
            $productFromCategory[$key['id']] = $key['name'];
        }

        $products = $this->productRepository->with(['categories'])->all();
        return $this->view('category.edit', [
            'category' => $category,
            'categories' => $categories,
            'products' => $products,
            'productFromCategory' => $productFromCategory ?? [],
            'themes' => $themes,
        ]);
    }

    public function throwValidationException(Request $request, $validator)
    {
        if ($validator->getMessageBag()->has('category_id')) {
            \Message::error($validator->getMessageBag()->get('category_id'));
        }
        parent::throwValidationException($request, $validator);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'category_id' => 'integer|exists:categories',
        ]);

        if ($this->parentExist(($request->get('category_id') != 0 ) ? $request->get('category_id') : null, $id)) {
            $this->validate($request, [
                'name' => 'required|unique:categories,name,' . $id . '|max:100',
                'slug' => 'required|unique:categories,slug,' . $id,
                'image' => 'mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            $this->categoryRepository->update($this->buildData($request), $id);
            \Message::success(['Category successfully updated.']);
            if ($request->has('stay_here')) {
                return redirect()->back();
            }
            return redirect()->route('category.index');
        } else {
            \Message::error(['Error for update category. This is Root category.']);
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        $category->products()->detach();

        $this->categoryRepository->delete($id);
        \Message::success(['Category successfully deleted.']);

        return redirect()->route('category.index');
    }

    public function activate($id)
    {
        return $this->changeStatus($id, true);
    }

    public function inactivate($id)
    {
        return $this->changeStatus($id, false);
    }

    protected function attachProducts(Request $request, $id)
    {
        $product = Category::find($request->get('category_id'));
        $product->products()->attach($id);
        \Message::success(['Products successfully added to category.']);

        return redirect()->back();
    }

    protected function detachProducts(Request $request, $id)
    {
        $product = Category::find($request->get('category_id'));
        $product->products()->detach($id);
        \Message::success(['Products successfully deleted to category.']);

        return redirect()->back();
    }

    protected function changeStatus($id, $status)
    {
        $this->categoryRepository->update(['active' => $status], $id);
        \Message::success(['Status successfully changed.']);

        return redirect()->route('category.index');
    }

    protected function parentExist($childId, $parentId)
    {
        if ($childId === null) {
            return true;
        } elseif($childId == $parentId) {
            return false;
        } else {
            $child = $this->categoryRepository->find($childId);
            if ($child->category_id === $parentId) {
                return false;
            } elseif ($child->category_id === null) {
                return true;
            } else {
                return $this->parentExist($child->category_id, $parentId);
            }
        }
    }

    protected function buildData(Request $request)
    {
        $data = $request->except(['_token', '_method', 'stay_here']);

        $data['active'] = $request->get('active', false);
        $data['is_page'] = $request->get('is_page', false);
        $data['show_in_navigation'] = $request->get('show_in_navigation', false);

        if (!$request->get('category_id')) {
            $data['category_id'] = null;
        }
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveFile($request->file('image'));
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->saveFile($request->file('thumbnail'));
        }
        return $data;
    }

    protected function saveFile(UploadedFile $img)
    {
        return \FileUpload::uploadFile($img, FileUpload::CATEGORY);
    }

}

<?php

namespace Modules\Backend\Http\Controllers;

use App\Entities\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Components\FileUpload;
use Modules\Backend\Repositories\AddonRepository;
use Modules\Backend\Repositories\Criteries\FindByRelation;

class ProductController extends BaseBackendController
{
    protected $productRepository;
    protected $categoryRepository;
    protected $addonRepository;

    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository,
        AddonRepository $addonRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->addonRepository = $addonRepository;
    }

    public function index()
    {
        $products = $this->productRepository->with(['categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return $this->view('products.index', [
            'products' => $products,
        ]);
    }

    public function create()
    {
        $categories = $this->categoryRepository->getCategories();

        return $this->view('products.create', [
            'categories' => $categories,
            'types' => Product::$displayTypes,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name|max:100',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        $product = $this->productRepository->create($this->buildData($request));
        $product->categories()->attach($request->get('category_ids'));
        \Message::success(['Products successfully created.']);

        return redirect()->route('products.edit', $product->id);
    }

    public function edit($id)
    {
        $categories = $this->categoryRepository->getCategories();
        $product = $this->productRepository->with(['categories', 'prices' => function ($query) {
            $query->orderBy('quantity', 'asc');
        }, 'addons'])->find($id);
        $addons = $this->addonRepository->all();

        if ($product === null) {
            abort(404);
        }

        foreach ($product->addons as $addon) {
            $addonsFromProduct[$addon->id] = $addon->name;
        }

        return $this->view('products.edit', [
            'product' => $product,
            'categories' => $categories,
            'types' => Product::$displayTypes,
            'addons' => $addons,
            'addonsFromProduct' => $addonsFromProduct ?? [],
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:products,name,' . $id . '|max:100',
            'image' => 'mimes:jpeg,jpg,png|max:2048',
        ]);

        $this->productRepository->update($this->buildData($request), $id);
        $product = $this->productRepository->find($id);

        if ($product === null) {
            abort(404);
        }

        $product->categories()->sync($request->get('category_ids', []));
        \Message::success(['Products successfully updated.']);
        if ($request->has('stay_here')) {
            return redirect()->back();
        }
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $product = $this->productRepository->find($id);

        if ($product === null) {
            abort(404);
        }
        DB::transaction(function () use ($product) {
            $product->categories()->detach();
            $product->prices()->delete();
            $product->delete();
        });
        \Message::success(['Products successfully deleted.']);

        return redirect()->route('products.index');
    }

    public function templates()
    {
        echo 'master-templates';
    }

    public function addPrice(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'add_quantity' => 'required|integer',
            'add_price' => 'required|numeric|max:' . Product::MAX_PRICE_SIZE,
        ]);

        $product = $this->productRepository->find($id);
        if ($product === null) {
            abort(404);
        }

        foreach ($product->prices as $price) {
            $validator->after(function ($validator) use ($price, $request) {
                if ($price->quantity == $request->get('add_quantity')) {
                    $validator->errors()->add('add_quantity', 'The quantity name has already been taken.');
                }
            });

            if ($validator->fails()) {
                $this->throwValidationException($request, $validator);
            }
        }

        $product->prices()->create([
            'price' => $request->get('add_price'),
            'quantity' => $request->get('add_quantity'),
        ]);
        \Message::success(['Price successfully added.']);

        return redirect()->back();
    }

    public function updatePrices(Request $request, $productId, $priceId)
    {
        $validator = \Validator::make($request->all(), [
            'quantity' => 'required|array',
            'price' => 'required|array',
        ]);

        $quantity = $request->get('quantity')[$priceId] ?? null;
        $price = $request->get('price')[$priceId] ?? null;

        $product = $this->productRepository->pushCriteria(new FindByRelation('prices', $priceId))->find($productId);

        if ($product === null) {
            abort(404);
        }

        $validator->after(function($validator) use ($quantity, $price, $priceId, $product) {
            if (!$price) {
                $validator->errors()->add('price[' . $priceId . ']', 'The price field is required.');
            }
            if (!$quantity) {
                $validator->errors()->add('quantity[' . $priceId . ']', 'The quantity field is required.');
            }
            $priceExist = $product->prices()
                ->where('quantity', $quantity)
                ->where('id', '!=', $priceId)
                ->first();

            if ($priceExist !== null) {
                $validator->errors()->add('quantity[' . $priceId . ']', 'The quantity name has already been taken.');
            }
        });
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $product->prices()->where('id', $priceId)->update([
            'price' => $price,
            'quantity' => $quantity,
        ]);
        \Message::success(['Price successfully updated.']);

        return redirect()->back();
    }

    public function deletePrice($productId, $priceId)
    {
        $product = $this->productRepository->find($productId);

        if ($product === null) {
            abort(404);
        }
        $product->prices()->where(['id' => $priceId])->delete();
        \Message::success(['Price successfully deleted.']);

        return redirect()->back();
    }

    protected function attachAddons(Request $request, $id)
    {
        $product = $this->productRepository->find($request->get('product_id'));
        $product->addons()->attach($id);
        \Message::success(['Addon successfully added to product.']);

        return redirect()->back();
    }

    protected function detachAddons(Request $request, $id)
    {
        $product = $this->productRepository->find($request->get('product_id'));
        $product->addons()->detach($id);
        \Message::success(['Addon successfully deleted to product.']);

        return redirect()->back();
    }

    protected function buildData(Request $request)
    {
        $data = $request->except(['_token', '_method', 'category_ids', 'stay_here']);
        if ($request->hasFile('image')) {
            $data['image'] = $this->saveFile($request->file('image'));
        }

        return $data;
    }

    protected function saveFile(UploadedFile $img)
    {
        return \FileUpload::uploadFile($img, FileUpload::PRODUCT);
    }

}

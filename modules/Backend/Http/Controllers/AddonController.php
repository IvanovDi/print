<?php

namespace Modules\Backend\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Backend\Entities\Addon;
use Modules\Backend\Entities\AddonOption;
use Modules\Backend\Repositories\AddonRepository;
use Modules\Backend\Repositories\Criteries\FindByRelation;

class AddonController extends BaseBackendController
{
    protected $addonRepository;

    public function __construct(AddonRepository $addonRepository)
    {
        $this->addonRepository = $addonRepository;
    }

    public function index()
    {
        $addons = $this->addonRepository->paginate(10);

        return $this->view('addons.index', [
            'addons' => $addons,
        ]);
    }

    public function create()
    {
        return $this->view('addons.create', [
            'types' => Addon::$displayTypes,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:addons,name|max:100',
            'type_views' => 'required|in:'
                . Addon::TYPE_CHECKBOX . ','
                . Addon::TYPE_RADIO . ','
                . Addon::TYPE_SELECT,
        ]);

        $addon = $this->addonRepository->create($request->only([
            'name',
            'type_views',
        ]));
        \Message::success(['Addon successfully created.']);

        return redirect()->route('addons.edit', $addon->id);
    }

    public function edit($id)
    {
        $addon = $this->addonRepository->find($id);
        if ($addon === null) {
            abort(404);
        }

        $options = $addon->options()->orderBy('id', 'desc')->paginate(5);
        return $this->view('addons.edit', [
            'addon' => $addon,
            'types' => Addon::$displayTypes,
            'options' => $options,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:addons,name,' . $id . '|max:100',
            'type_views' => 'required',
        ]);

        $this->addonRepository->update($request->only([
            'name',
            'type_views',
        ]), $id);
        \Message::success(['Addon successfully updated.']);

        if ($request->has('stay_here')) {
            return redirect()->back();
        }
        return redirect()->route('addons.index');
    }

    public function destroy($id)
    {
        $addon = $this->addonRepository->find($id);
        \DB::transaction(function () use ($addon) {
            $addon->options()->delete();
            $addon->delete();
        });
        \Message::success(['Addon successfully deleted.']);

        return redirect()->back();
    }

    public function addOptions(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'option_add_name' => 'required',
            'price' => 'required|numeric|max:' . AddonOption::MAX_PRICE_SIZE,
        ]);

        $addon = $this->addonRepository->find($id);

        if ($addon === null) {
            abort(404);
        }
        foreach ($addon->options as $option) {
            $validator->after(function ($validator) use ($option, $request) {
                if ($option->name == $request->get('option_add_name')) {
                    $validator->errors()->add('option_add_name', 'The name name has already been taken.');
                }
            });
        }

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $addon->options()->create([
            'name' => $request->get('option_add_name'),
            'price' => $request->get('price'),
        ]);
        \Message::success(['Options successfully created.']);

        return redirect()->back();
    }

    public function updateOptions(Request $request, $addonId, $optionId)
    {
        $validator = \Validator::make($request->all(), [
            'option_name' => 'required|array', // array - because of validation (view)
            'option_price' => 'required|array',
        ]);
        $optionName = $request->get('option_name')[$optionId] ?? null;
        $optionPrice = $request->get('option_price')[$optionId] ?? null;

        $addon = $this->addonRepository->pushCriteria(new FindByRelation('options', $optionId))->find($addonId);

        if ($addon === null) {
            abort(404);
        }

        $validator->after(function ($validator) use ($addon, $request, $optionId, $optionName, $optionPrice) {
            if ($optionName === null) {
                $validator->errors()->add('option_name[' . $optionId . ']', 'The name field is required.');
            }
            if ($optionPrice === null) {
                $validator->errors()->add('option_price[' . $optionId . ']', 'The name field is required.');
            }
            if ($optionPrice > AddonOption::MAX_PRICE_SIZE) {
                $validator->errors()->add('option_price[' . $optionId . ']', 'The price may not be greater than ' . AddonOption::MAX_PRICE_SIZE);
            }
            $optionExist = $addon->options()
                ->where('name', $optionName)
                ->where('id', '!=', $optionId)
                ->first();
            if ($optionExist !== null) {
                $validator->errors()->add('option_name[' . $optionId . ']', 'This name has already been taken.');
            }
        });

        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }

        $addon->options()->where('id', $optionId)->update([
            'name' => $optionName,
            'price' => $optionPrice,
        ]);
        \Message::success(['Option successfully updated.']);

        return redirect()->back();
    }

    public function deleteOptions($addonId, $optionId)
    {
        $addon = $this->addonRepository->find($addonId);

        if ($addon === null) {
            abort(404);
        }

        $addon->options()->where(['id' => $optionId])->delete();
        \Message::success(['Options successfully deleted.']);

        return redirect()->back();
    }

}

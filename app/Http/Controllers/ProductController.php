<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\ListProductRequest;
use App\Http\Requests\UpdateProductRequest;
use NohYooHan\Domain\Product\Product;
use Exception;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Response;

class ProductController extends Controller
{
    public function createProduct(CreateProductRequest $request)
    {
        DB::beginTransaction();

        try {
            /** @var Product $product */
            $product = new Product;
            $this->makeProduct($product, $request);
            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function listProduct(ListProductRequest $request)
    {
        $dto = $request->getProductSearchParam();

        $builder = Product::query();

        if ($dto->getSearch()) {
            $builder->where(function (Builder $builder) use ($dto) {
                $builder->where('name', 'like', "%{$dto->getSearch()}%")
                    ->orWhere('description', 'like', "%{$dto->getSearch()}%");
            });
        }

        if ($dto->getPriceFrom() && $dto->getPriceTo()) {
            $builder->whereBetween('price', [
                $dto->getPriceFrom(),
                $dto->getPriceTo()
            ]);
        }

        if ($dto->getPriceFrom() && ! $dto->getPriceTo()) {
            $builder->where('price', '>=', $dto->getPriceFrom());
        }

        if (! $dto->getPriceFrom() && $dto->getPriceTo()) {
            $builder->where('price', '<=', $dto->getPriceTo());
        }

        return $builder->paginate($dto->getSize(), ['*'], 'page', $page = $dto->getPage());
    }

    public function updateProduct(UpdateProductRequest $request, int $productId)
    {
        DB::beginTransaction();

        try {
            /** @var Product $product */
            $product = Product::findOrFail($productId);
            $this->modifyProduct($product, $request);
            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function deleteProduct(DeleteProductRequest $request, int $productId)
    {
        DB::beginTransaction();

        try {
            /** @var Product $product */
            $product = Product::findOrFail($productId);
            $product->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json([], 204);
    }

    private function makeProduct(Product $product, CreateProductRequest $request)
    {
        $product->name = $request->getName();
        $product->description = $request->getDescription();
        $product->price = $request->getPrice();
        $product->stock = $request->getStock();
    }

    private function modifyProduct(Product $product, UpdateProductRequest $request)
    {
        $product->name = $request->getName();
        $product->description = $request->getDescription() ?: $product->description;
        $product->price = $request->getPrice();
        $product->stock = $request->getStock();
    }
}

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
use NohYooHan\Service\Product\ProductCreator;
use NohYooHan\Service\Product\ProductModifier;
use NohYooHan\Service\Product\ProductRetriever;
use Response;

class ProductController extends Controller
{
    public function createProduct(
        CreateProductRequest $request,
        ProductCreator $productCreator
    ) {
        DB::beginTransaction();

        try {
            $product = $productCreator->makeProduct($request->getProductDto());
            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function listProduct(ListProductRequest $request, ProductRetriever $productRetriever)
    {
        return $productRetriever->retrieveBySearchParam($request->getProductSearchParam());
    }

    public function updateProduct(UpdateProductRequest $request, int $productId, ProductModifier $productModifier)
    {
        DB::beginTransaction();

        try {
            /** @var Product $product */
            $product = Product::findOrFail($productId);
            $productModifier->modifyProduct($product, $request->getProductDto());
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
}

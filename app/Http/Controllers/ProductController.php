<?php

namespace App\Http\Controllers;

use App\Events\ProductCreatedEvent;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\ListProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Transformers\ProductTransformer;
use DB;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use NohYooHan\Service\Product\ProductCreator;
use NohYooHan\Service\Product\ProductModifier;
use NohYooHan\Service\Product\ProductRetriever;
use Response;

class ProductController extends Controller
{
    public function createProduct(
        CreateProductRequest $request,
        ProductCreator $productCreator,
        Dispatcher $eventDispatcher
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

        $eventDispatcher->dispatch(new ProductCreatedEvent($product));

        return $product;
    }

    public function listProduct(ListProductRequest $request, ProductRetriever $productRetriever)
    {
        $paginator = $productRetriever->retrieveBySearchParam($request->getProductSearchParam());

        return json()->setMeta([
            'foo' => 'bar'
        ])->withPagination($paginator, new ProductTransformer);
    }

    public function getProduct(ListProductRequest $request, ProductRetriever $productRetriever, int $productId)
    {
        $product = $productRetriever->retrieveById($productId);

        return json()->setMeta([
            'foo' => 'bar'
        ])->withItem($product, new ProductTransformer);
    }

    public function updateProduct(
        UpdateProductRequest $request,
        ProductRetriever $productRetriever,
        ProductModifier $productModifier,
        int $productId
    ) {
        DB::beginTransaction();

        try {
            $product = $productRetriever->retrieveById($productId);
            $productModifier->modifyProduct($product, $request->getProductDto());
            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function deleteProduct(
        DeleteProductRequest $request,
        ProductRetriever $productRetriever,
        int $productId
    ) {
        DB::beginTransaction();

        try {
            $product = $productRetriever->retrieveById($productId);
            $product->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json([], 204);
    }
}

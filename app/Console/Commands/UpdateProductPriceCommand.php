<?php

namespace App\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use NohYooHan\Domain\Common\Dto\ProductDto;
use NohYooHan\Domain\Product\Category;
use NohYooHan\Domain\Product\Product;
use NohYooHan\Service\Product\ProductModifier;
use NohYooHan\Service\Product\ProductRetriever;

class UpdateProductPriceCommand extends Command
{
    protected $signature = 'product:update-price';
    protected $description = '제품 가격을 두배로 업데이트합니다.';

    public function handle(ProductRetriever $productRetriever, ProductModifier $productModifier)
    {
        \Log::info('[UpdateProductPriceCommand] 작업을 시작합니다.');
        $products = $productRetriever->retrieveAll();

        /** @var Product $product */
        foreach($products as $product) {
            $dto = new ProductDto(
                $product->name,
                $product->description,
                $product->price * 2,
                $product->stock,
                Category::getInstance($product->category)
            );

            DB::beginTransaction();

            try {
                $productModifier->modifyProduct($product, $dto);
                $product->save();

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                \Log::error('[UpdateProductPriceCommand] 예외가 발생했습니다.');
                throw $e;
            }
        }

        \Log::info('[UpdateProductPriceCommand] 작업을 성공했습니다.');
    }
}

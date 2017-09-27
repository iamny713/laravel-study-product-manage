<?php

namespace App\Jobs;

use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use NohYooHan\Domain\Common\Dto\ProductDto;
use NohYooHan\Domain\Product\Category;
use NohYooHan\Domain\Product\Product;
use NohYooHan\Service\Product\ProductModifier;

class UpdateProductNameJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    private $product;

    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function handle(ProductModifier $productModifier)
    {
        Log::info('[UpdateProductNameJob] 작업을 시작합니다.');

        $dto = new ProductDto(
            $this->product->name . ' modified',
            $this->product->description,
            $this->product->price * 2,
            $this->product->stock,
            Category::getInstance($this->product->category)
        );

        DB::beginTransaction();

        try {
            $productModifier->modifyProduct($this->product, $dto);
            $this->product->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[UpdateProductNameJob] 작업을 실패했습니다.');
            throw $e;
        }

        Log::error('[UpdateProductNameJob] 작업을 완료했습니다.');
    }
}

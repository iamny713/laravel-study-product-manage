<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\DeleteReviewRequest;
use App\Http\Requests\ListReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Support\Facades\DB;
use NohYooHan\Domain\Review\Review;
use NohYooHan\Service\Review\ReviewCreator;
use NohYooHan\Service\Review\ReviewModifier;
use NohYooHan\Service\Review\ReviewRetriever;

use Response;

class ReviewController extends Controller
{
    //
    public function createReview(
        CreateReviewRequest $request,
        ReviewCreator $reviewCreator,
        int $productId
    ) {
        DB::beginTransaction();

        try {
            $product = $reviewCreator->makeReview($request->getReviewDto(), $productId);
            $product->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $product;
    }

    public function updateReview(
        UpdateReviewRequest $request,
        ReviewModifier $reviewModifier,
        int $reviewId
    ) {
        DB::beginTransaction();

        try {
            /** @var Review $review */
            $review = Review::findOrFail($reviewId);
            $reviewModifier->modifyReview($review, $request->getReviewDto());
            $review->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $review;
    }

    public function listReviewByProductId(
        ReviewRetriever $reviewRetriever,
        ListReviewRequest $request,
        int $productId
    ) {
        return $reviewRetriever->retrieveByProductId($productId, $request->getReviewSearchParam());
    }

    public function deleteReview(
        DeleteReviewRequest $request,
        int $reviewId
    ) {
        DB::beginTransaction();

        try {
            /** @var Review $review */
            $review = Review::findOrFail($reviewId);
            $review->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return Response::json([], 204);
    }
}

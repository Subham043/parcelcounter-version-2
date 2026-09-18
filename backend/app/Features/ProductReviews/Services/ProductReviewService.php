<?php

namespace App\Features\ProductReviews\Services;

use App\Features\ProductReviews\DTO\ProductReviewDTO;
use App\Features\ProductReviews\Interfaces\ProductReviewRepositoryInterface;
use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Features\ProductReviews\Models\ProductReview;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductReviewService implements ProductReviewServiceInterface
{

	public function __construct(private ProductReviewRepositoryInterface $reviewRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->reviewRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductReview
	{
		return $this->reviewRepository->getById($product_id, $id);
	}

	public function create(ProductReviewDTO $data, int $product_id): ProductReview
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->reviewRepository->create([...$data->toArray(), 'is_active' => false, 'user_id' => auth(Guards::API->value())->user()->id], $product_id);
		});
	}

	public function update(ProductReviewDTO $data, ProductReview $review): ProductReview
	{
		return DB::transaction(function () use ($data, $review) {
			return $this->reviewRepository->update($review, $data->toArray());
		});
	}

	public function delete(ProductReview $review): ProductReview
	{
		return DB::transaction(function () use ($review) {
			return $this->reviewRepository->delete($review);
		});
	}

	public function toggleActive(ProductReview $review): ProductReview
	{
		return DB::transaction(function () use ($review) {
			return $this->reviewRepository->update($review, ['is_active' => !$review->is_active]);
		});
	}
}

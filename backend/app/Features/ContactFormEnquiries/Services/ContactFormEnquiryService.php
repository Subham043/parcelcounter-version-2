<?php

namespace App\Features\ContactFormEnquiries\Services;

use App\Features\ContactFormEnquiries\DTO\ContactFormEnquiryDTO;
use App\Features\ContactFormEnquiries\Exports\ContactFormEnquiryExport;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryRepositoryInterface;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Features\ContactFormEnquiries\Models\ContactFormEnquiry;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ContactFormEnquiryService implements ContactFormEnquiryServiceInterface
{

	public function __construct(private ContactFormEnquiryRepositoryInterface $enquiryRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->enquiryRepository->paginate($total);
	}

	public function getById(Int $id): ContactFormEnquiry
	{
		return $this->enquiryRepository->getById($id);
	}

	public function create(ContactFormEnquiryDTO $data): ContactFormEnquiry
	{
		return DB::transaction(function () use ($data) {
			return $this->enquiryRepository->create($data->toArray());
		});
	}

	public function update(ContactFormEnquiryDTO $data, ContactFormEnquiry $enquiry): ContactFormEnquiry
	{
		return DB::transaction(function () use ($data, $enquiry) {
			return $this->enquiryRepository->update($enquiry, $data->toArray());
		});
	}

	public function toggleActive(ContactFormEnquiry $enquiry): ContactFormEnquiry
	{
		return DB::transaction(function () use ($enquiry) {
			return $this->enquiryRepository->update($enquiry, ['is_active' => !$enquiry->is_active]);
		});
	}

	public function delete(ContactFormEnquiry $enquiry): ContactFormEnquiry
	{
		return DB::transaction(function () use ($enquiry) {
			return $this->enquiryRepository->delete($enquiry);
		});
	}

	public function exportContactFormEnquiries(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new ContactFormEnquiryExport($this->enquiryRepository->query()), 'enquiries.xlsx');
	}
}

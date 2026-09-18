<?php

namespace App\Features\ContactFormEnquiries\Interfaces;

use App\Features\ContactFormEnquiries\DTO\ContactFormEnquiryDTO;
use App\Features\ContactFormEnquiries\Models\ContactFormEnquiry;
use Illuminate\Pagination\LengthAwarePaginator;

interface ContactFormEnquiryServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(ContactFormEnquiryDTO $data): ContactFormEnquiry;
    public function update(ContactFormEnquiryDTO $data, ContactFormEnquiry $enquiry): ContactFormEnquiry;
    public function getById(int $id): ContactFormEnquiry;
    public function delete(ContactFormEnquiry $enquiry): ContactFormEnquiry;
    public function toggleActive(ContactFormEnquiry $enquiry): ContactFormEnquiry;
    public function exportContactFormEnquiries(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}

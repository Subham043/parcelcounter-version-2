<?php

namespace App\Features\ContactFormEnquiries\DTO;

use App\Features\ContactFormEnquiries\Requests\ContactFormEnquiryPostRequest;
use Illuminate\Support\Collection;

final class ContactFormEnquiryDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly string $subject,
        public readonly string $message,
        public readonly ?string $page_url,
    ) {}

    /**
     * @param ContactFormEnquiryPostRequest $request
     * @return self
     */
    public static function fromRequest(ContactFormEnquiryPostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            phone: $request->validated('phone') ?? null,
            subject: $request->validated('subject'),
            message: $request->validated('message'),
            page_url: $request->validated('page_url') ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'page_url' => $this->page_url,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ContactFormEnquiryDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}

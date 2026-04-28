<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreReservationRequest extends FormRequest
{
	public function authorize(): bool
	{
		return true;
	}

	public function rules(): array
	{
		return [
			'court_id' => ['required', 'integer', Rule::exists('courts', 'id')->where('is_active', true)],
			'date' => ['required', 'date', 'after_or_equal:today'],
			'time_slot_id' => ['required', 'integer', 'exists:time_slots,id'],
			'start_time' => ['required', 'date_format:H:i'],
			'first_name' => ['required', 'string', 'max:100'],
			'last_name' => ['required', 'string', 'max:100'],
			'email' => ['required', 'email', 'max:150'],
			'phone' => ['required', 'string', 'max:50', 'regex:/^\\+?[0-9\\s\\-()]{7,20}$/'],
		];
	}

	public function messages(): array
	{
		return [
			'phone.regex' => 'Telefon mora biti u formatu npr. +381 64 123 4567 ili 064-123-4567.',
		];
	}
} 
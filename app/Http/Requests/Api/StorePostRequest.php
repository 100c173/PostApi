<?php

namespace App\Http\Requests\Api;

use App\Rules\FutureDateRule;
use App\Rules\MaxKeywordCountRule;
use App\Rules\ValidSlugRule;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        // Automatically generate slug if not submitted
        if (!$this->filled('slug') && $this->filled('title')) {
            $this->merge([
                'slug' => Str::slug($this->title),
            ]);
        }

        // Create a meta_description from the title and tags if it is not submitted.
        if (!$this->filled('meta_description') && $this->filled('title') && $this->filled('tags')) {
            $this->merge([
                'meta_description' => $this->title . ' - ' . $this->tags,
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug', new ValidSlugRule()],
            'body' => ['required', 'string'],
            'publish_date' => ['nullable', 'date', new FutureDateRule()],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string'],
            'keywords' => ['nullable', 'string', new MaxKeywordCountRule(10)],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'This slug is already taken.',
            'publish_date.date' => 'The publish date must be a valid date.',
            'keywords.string' => 'The keywords must be a string.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'title',
            'slug' => 'slug',
            'body' => 'body',
            'is_published' => 'publish status',
            'publish_date' => 'publish date',
            'meta_description' => 'meta description',
            'tags' => 'tags',
            'keywords' => 'keywords',

        ];
    }

    public function passedValidation(): void
    {
        // Abbreviation for the content (first 150 characters) of a new field that can be used in a controller
        $summary = Str::limit(strip_tags($this->body), 150);

        // Merge new value immediately after verification
        $this->merge([
            'summary' => $summary,
            'tags' => strtolower($this->tags), //Clean the field and convert it to lowercase letters.
        ]);
    }

    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422)
        );
    }
}

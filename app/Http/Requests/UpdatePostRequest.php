<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // dd($this->all());
        $post=Post::where('id', $this->input('id'))->where('user_id', Auth::id())->first();
        return !!$post;
    }

    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string', 'min:1'],
            'id' => ['required', 'numeric'],
            'attachments' => ['nullable', 'array', 'max:10'],
            'attachments.*' => [
                'required', 
                'file', 
                'mimes:jpg,jpeg,png,webp,gif,mp3,wav,wma,mp4,avi,mkv,pdf,csv,xlsx,zip,rar',
                'max:20480'
            ],
            'deletedFileIds' => ['nullable', 'array'],
            'deletedFileIds.*' => ['nullable', 'numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'id' => $this->input('id'),
            'body' => $this->input('body', ''),
            'attachments' => $this->file('attachments') ?? [], 
            'deletedFileIds' => $this->input('deletedFileIds') ?? [],
        ]);
    }


    public function messages()
    {
        if (!$this->hasFile('attachments')) {
            return[
            'body.min' => 'The post must be at least 1 character.',
            ];
        }
        
        return [
            'attachments.max' => 'You may not upload more than 10 attachments.',
            'attachments.*.file' => 'Invalid attachment file.',
            'attachments.*.mimes' => 'Invalid file type for attachments. Allowed types are: jpg, jpeg, png, webp, gif, mp3, wav, wma, mp4, avi, mkv, doc, docx, pdf, csv, xlsx, zip, rar.',
            'attachments.*.max' => 'Each attachment may not be larger than 20MB.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->filled('body') && !$this->hasFile('attachments')) {
                $validator->errors()->add('body', 'Either the post body or attachments are required.');
                $validator->errors()->add('attachments', 'Either the post body or attachments are required.');
            }
        });
    }
}

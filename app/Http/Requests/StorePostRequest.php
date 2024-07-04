<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\File;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $file_size=100 * 1024 * 1024;
        return [
            'body'=> ['nullable', 'string'],
            'attachments'=>['nullable','array','max:10'],
            'attachments.*'=>[
                File::types([
                    'jpg','jpeg','png','webp','gif',  /* Image types */
                    'mp3','wav','wma',  /* Audio types */
                    'mp4','avi','mkv',  /* Video types */
                    'pdf','csv', 'xlsx',  /* Document types */
                    'zip', 'rar' /* Archive types */
                ])->max($file_size)
            ],
            'user_id' => ['numeric'],
        ];
    }

    protected function prepareForValidation(){
        $this->merge([
            'user_id'=> auth()->user()->id,
            'body' => $this->input('body', ' '),
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
            'attachments.*.file' => 'Each attachment must be a valid file type.',
            'attachments.*.mimes' => 'Allowed types are jpg, jpeg, png, webp, gif, mp3, wav, wma, mp4, avi, mkv, doc, docx, pdf, csv, xlsx, zip, rar.',
            'attachments.*.max' => 'Each attachment may not be greater than 100MB.',
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

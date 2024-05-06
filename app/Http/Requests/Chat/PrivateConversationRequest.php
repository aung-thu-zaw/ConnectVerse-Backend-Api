<?php

namespace App\Http\Requests\Chat;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PrivateConversationRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'receiver_id' => ['required', 'numeric', Rule::exists('users', 'id')],
    //         'content' => ['nullable', 'string'],
    //         'message_type' => ['required', 'string', Rule::in(['text', 'media'])],
    //         'media' => [
    //             'required_if:message_type,media',
    //             'array',
    //             function ($attribute, $value, $fail) {
    //                 if (!isset($value['media_file']) || !isset($value['media_type']) || !isset($value['caption'])) {
    //                     $fail('The media field must contain media_file, media_type, and caption.');
    //                 }
    //             },
    //             'media_type' => ['required', 'string',Rule::in(['file', 'image', 'video', 'voice'])],
    //             'media_file' => [
    //                 'required',
    //                 'file',
    //                 'max:50000',
    //                 function ($attribute, $value, $fail) {
    //                     $allowedTypes = [
    //                         'file' => ['pdf', 'doc', 'docx', 'txt','zip'],
    //                         'image' => ['jpeg', 'jpg', 'png', 'gif'],
    //                         'video' => ['mp4', 'avi', 'mov'],
    //                         'voice' => ['mp3', 'wav', 'ogg'],
    //                     ];

    //                     $mediaType = $this->media->media_type;
    //                     $extension = $value->getClientOriginalExtension();

    //                     if (!in_array($extension, $allowedTypes[$mediaType])) {
    //                         $fail('Invalid file type for the selected media type.');
    //                     }
    //                 },
    //             ],
    //             'caption' => ['nullable', 'string'],
    //         ]
    //     ];
    // }

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'numeric', Rule::exists('users', 'id')],
            'content' => ['nullable', 'string'],
            'message_type' => ['required', 'string', Rule::in(['text', 'media'])],
            'media' => [
                'required_if:message_type,media',
                'array',
                function ($attribute, $value, $fail) {
                    if (!isset($value['media_file']) || !isset($value['media_type']) || !isset($value['caption'])) {
                        $fail('The media field must contain media_file, media_type, and caption.');
                    }
                },
            ],
            'media.media_type' => ['required_with:media', 'string', Rule::in(['file', 'image', 'video', 'voice'])],
            'media.media_file' => [
                'required_with:media',
                'file',
                'max:50000',
                function ($attribute, $value, $fail) {
                    $allowedTypes = [
                        'file' => ['pdf', 'doc', 'docx', 'txt','zip'],
                        'image' => ['jpeg', 'jpg', 'png', 'gif'],
                        'video' => ['mp4', 'avi', 'mov'],
                        'voice' => ['mp3', 'wav', 'ogg'],
                    ];

                    $mediaType = request()->input('media.media_type');
                    $extension = $value->getClientOriginalExtension();

                    if (!in_array($extension, $allowedTypes[$mediaType])) {
                        $fail('Invalid file type for the selected media type.');
                    }
                },
        ],
            'media.caption' => ['nullable', 'string'],
        ];
    }

}

<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'phone-required'                     => 'សូមបញ្ចូលលេខទូរស័ព្ទរបស់អ្នក',
    'phone-regex'                        => 'សូមប្រើទម្រង់លេខទូរស័ព្ទត្រឹមត្រូវ។ E.g 0965416704',
    'email-required'                     => 'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ',
    'email-email'                        => 'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ. E.g khouch.koeun@gmail.com',
    'email-max'                          => 'អាសយដ្ឋានអ៊ីម៉ែលរបស់អ្នកត្រូវមានប្រវែងអតិបរមា 50 តួលេខ',
    'purpose-required'                   => 'សូមដាក់ស្នើគោលបំណងរបស់អ្នក',

    //====================== Purpose
    'password-notification'              => 'ផ្លាស់ប្តូរពាក្យសម្ងាត់',
    'password-notification-message'      => 'លេខកូដសម្ងាត់ត្រូវបានផ្ញើទៅអ៊ីម៉ែលរបស់អ្នក។ សូមពិនិត្យវាសម្រាប់ការផ្ទៀងផ្ទាត់។',
    'password-nexmo-message'             => 'លេខកូដសម្ងាត់ត្រូវបានផ្ញើទៅទូរស័ព្ទរបស់អ្នក។ សូមពិនិត្យវាសម្រាប់ការផ្ទៀងផ្ទាត់។',
    'password-nexmo-error'               => 'មិនមានវិធីណាមួយដើម្បីផ្ញើកូដសម្រាប់ផ្ទៀងផ្ទាត់នោះទេ',

    'activate-notification'              => 'ផ្ទៀងផ្ទាត់គណនី',
    'activate-notification-message'      => 'លេខកូដសម្ងាត់ត្រូវបានផ្ញើទៅអ៊ីម៉ែលរបស់អ្នក។ សូមពិនិត្យវាសម្រាប់ការផ្ទៀងផ្ទាត់។',
    'activate-notification-error'        => 'គណនីរបស់អ្នកត្រូវបានសកម្មរួចហើយ។ អ្នកមិនអាចស្នើសុំលេខកូដថ្មីបានទេ',
    'activate-nexmo-message'             => 'លេខកូដសម្ងាត់ត្រូវបានផ្ញើទៅទូរស័ព្ទរបស់អ្នក។ សូមពិនិត្យវាសម្រាប់ការផ្ទៀងផ្ទាត់។',
    'activate-nexmo-error'               => 'គណនីរបស់អ្នកត្រូវបានសកម្មរួចហើយ។ អ្នកមិនអាចស្នើសុំលេខកូដថ្មីបានទេ',
    'no-phone-email'                     => 'មិនមានអ្នកប្រើណាដែលមានអ៊ីមែលឬលេខទូរស័ព្ទនេះទេ',
    'code-purpose-error'                 => 'សូមផ្តល់នូវគោលបំណងនៃការទទួលបានកូដផ្ទៀងផ្ទាត់',

    //====================== Verify Code
    'code-required'                      => 'សូមបញ្ចូលលេខកូដ 6 ខ្ទង់របស់អ្នក',
    'code-length'                        => 'លេខកូដរបស់អ្នកមាន 6 ខ្ទង់',
    'code-purpose'                       => 'សូមដាក់ស្នើគោលបំណងរបស់អ្នក',
    'code-message'                       => 'កូដត្រូវបានផ្ទៀងផ្ទាត់ដោយជោគជ័យ',
    'code-error'                         => 'កូដត្រូវបានប្រើរួចហើយ',
    'user-error'                         => 'គណនីអ្នកប្រើមិនត្រឹមត្រូវ',
    'expired-code'                       => 'លេខកូដផុតកំណត់',
    'code-wrong'                         => 'លេខកូដមិនត្រឹមត្រូវ',

    //====================== Reset Password
    'reset-message'                      => 'ពាក្យសម្ងាត់បានជោគជ័យ',
    'reset-password-required'            => 'សូម​បញ្ចូល​ពាក្យ​សម្ងាត់​របស់​អ្នក',
    'reset-password-min'                 => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦ខ្ទង់យ៉ាងហោចណាស់',
    'reset-password-max'                 => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦០ខ្ទង់យ៉ាងច្រើនបំផុត',
    'reset-token'                        => '​token មិន​ត្រឹមត្រូវ',

    //====================== Update Profile
    'profile-name-required'             => 'សូមបញ្ជូលឈ្មោះរបស់នាក់',
    'profile-phone-unique'              => 'ទូរស័ព្ទនេះត្រូវបានគេយករួចហើយ។ សូមជ្រើសរើសមួយផ្សេងទៀត។',
    'profile-phone-required'            => 'សូមបញ្ចូលលេខទូរស័ព្ទរបស់អ្នក',
    'profile-phone-regex'               => 'សូមប្រើទម្រង់លេខទូរស័ព្ទត្រឹមត្រូវ។ E.g 0965416704',
    'profile-email-required'            => 'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ',
    'profile-email-email'               => 'សូមបញ្ចូលអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ. E.g khouch.koeun@gmail.com',
    'profile-email-max'                 => 'អាសយដ្ឋានអ៊ីម៉ែលរបស់អ្នកត្រូវមានប្រវែងអតិបរមា 50 តួលេខ',
    'profile-email-unique'              => 'អ៊ីម៉ែលត្រូវបានគេយករួចហើយ។ សូមជ្រើសរើសមួយផ្សេងទៀត។',
    'profile-password-required'         => 'សូម​បញ្ចូល​ពាក្យ​សម្ងាត់​របស់​អ្នក',
    'profile-password-min'              => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦ខ្ទង់យ៉ាងហោចណាស់',
    'profile-password-max'              => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦០ខ្ទង់យ៉ាងច្រើនបំផុត',
    'profile-password-confirmed'        => 'សូមបញ្ជាក់ពាក្យសម្ងាត់របស់អ្នក',
    'profile-message'                    => 'គណនីរបស់អ្នកបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ',

    //====================== Change Password
    'old-password-required'              => 'សូមបញ្ចូលពាក្យសម្ងាត់ចាស់របស់អ្នក',
    'old-password-min'                   => 'ពាក្យសំងាត់ចាស់ត្រូវមានចំនួន ៦ខ្ទង់យ៉ាងហោចណាស់',
    'old-password-max'                   => 'ពាក្យសំងាត់ចាសត្រូវមានចំនួន ៦០ខ្ទង់យ៉ាងច្រើនបំផុត',

    'change-password-required'          => 'សូម​បញ្ចូល​ពាក្យ​សម្ងាត់​របស់​អ្នក',
    'change-password-min'               => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦ខ្ទង់យ៉ាងហោចណាស់',
    'change-password-max'               => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦០ខ្ទង់យ៉ាងច្រើនបំផុត',
    'change-password-confirmed'         => 'ការអះអាងពាក្យសម្ងាត់មិនត្រូវគ្នា។',
    'change-password-message'           => 'ពាក្យសម្ងាត់បានជោគជ័យ',
    'change-password-token'             => 'token មិន​ត្រឹមត្រូវ',
    'invalid-old-password'              => 'ពាក្យសម្ងាត់ចាស់មិនត្រឹមត្រូវ។',
    //====================== Deleted
    'deleted-message'                   => 'គនណីត្រូវបានលុប',
    'deleted-error'                     => 'គណនីនេះមិនត្រូវបានលុបទេ!',

    //====================== Refresh Token
    'refresh-token'                     => 'Toekn has been refreshed!',

];

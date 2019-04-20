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

    'phone-required'                     => 'Please enter your phone number',
    'phone-regex'                        => 'Please use a valid mobile phone number. E.g 0965416704',
    'email-required'                     => 'Please enter a valid email address',
    'email-email'                        => 'Please enter a valid email address. E.g khouch.koeun@gmail.com',
    'email-max'                          => 'Your email address must have a maximum length of 50 digits',
    'purpose-required'                   => 'Please submit your goal',

    //====================== Purpose
    'password-notification'              => 'Change password',
    'password-notification-message'      => 'A PIN has been sent to your email. Please check it for verification.',
    'password-nexmo-message'             => 'A PIN has been sent to your phone. Please check it for verification.',
    'password-nexmo-error'               => 'There is no way to send a verification code',

    'activate-notification'              => 'Verify account',
    'activate-notification-message'      => 'A PIN has been sent to your email. Please check it for verification.',
    'activate-notification-error'        => 'Your account has been activated. You can not request a new code',
    'activate-nexmo-message'             => 'A PIN has been sent to your phone. Please check it for verification.',
    'activate-nexmo-error'               => 'Your account has been activated. You can not request a new code',
    'no-phone-email'                     => 'No user has an email or phone number',
    'code-error'                         => 'សូមផ្តល់នូវគោលបំណងនៃការទទួលបានកូដផ្ទៀងផ្ទាត់',

    //====================== Verify Code
    'code-required'                      => 'Please enter your 6-digit code',
    'code-length'                        => 'Your code is up to 6 digits',
    'code-purpose'                       => 'Please submit your goal',
    'code-message'                       => 'The code has been successfully verified',
    'code-error'                         => 'Code is already used',
    'user-error'                         => 'User accounts are not limited to',
    'expired-code'                       => 'Code expired',
    'code-wrong'                         => 'The code is invalid',

    //====================== Reset Password
    'reset-message'                      => 'Password successful',
    'reset-password-required'            => 'សូម​បញ្ចូល​ពាក្យ​សម្ងាត់​របស់​អ្នក',
    'reset-password-min'                 => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦ខ្ទង់យ៉ាងហោចណាស់',
    'reset-password-max'                 => 'ពាក្យសំងាត់ត្រូវមានចំនួន ៦០ខ្ទង់យ៉ាងច្រើនបំផុត',
    'reset-token'                        => '​token មិន​ត្រឹមត្រូវ',

    //====================== Update Profile
    'profile-name-required'              => 'Please enter your name',
    'profile-phone-unique'               => 'This phone is already taken. Please select another.',
    'profile-phone-required'             => 'Please enter your phone number',
    'profile-phone-regex'                => 'Please use a valid mobile phone number. E.g 0965416704',
    'profile-email-required'             => 'Please enter a valid email address',
    'profile-email-email'                => 'Please enter a valid email address. E.g khouch.koeun@gmail.com',
    'profile-email-max'                  => 'Your email address must have a maximum length of 50 digits',
    'profile-email-unique'               => 'Email is already taken. Please select another.',
    'profile-password-required'          => 'Please enter your password',
    'profile-password-min'               => 'Password must be at least 6 digits',
    'profile-password-max'               => 'The password must be at most 60 digits',
    'profile-password-confirmed'         => 'Please confirm your password',
    'profile-message'                    => 'គណនីរបស់អ្នកបានធ្វើបច្ចុប្បន្នភាពដោយជោគជ័យ',

    //====================== Change Password
    'old-password-required'              => 'Please enter your old password',
    'old-password-min'                   => 'The old password must be at least 6 digits',
    'old-password-max'                   => 'The password must be at most 60 digits',

    'change-password-required'          => 'Please enter your password',
    'change-password-min'               => 'Password must be at least 6 digits',
    'change-password-max'               => 'The password must be at most 60 digits',
    'change-password-confirmed'         => 'ការអះអាងពាក្យសម្ងាត់មិនត្រូវគ្នា។',
    'change-password-message'           => 'Password has been changed successful',
    'change-password-token'             => 'token មិន​ត្រឹមត្រូវ',
    'invalid-old-password'              => 'Invalid old password.',
    
    //====================== Deleted
    'deleted-message'                   => 'Account has been deleted',
    'deleted-error'                     => 'គណនីនេះមិនត្រូវបានលុបទេ!',

    //====================== Refresh Token
    'refresh-token'                     => 'Toekn has been refreshed!',


];

@component('mail::message')
# New Question

Greetings, {{ $user->email }},

Someone just asked a new question, as follows: **{{ $question->content }}** 

To answer, click the button below. 

@component('mail::button', ['url' => ''])
Go to Question
@endcomponent

Stop receiving new question emails? You can opt-out by going to your account settings.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

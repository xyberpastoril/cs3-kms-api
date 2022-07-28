@component('mail::message')
# Answer Updated

Greetings, {{ $waitlister->email }},

{{ $waitlister->createdSince() }}, you asked the following question: **{{ $question->content }}** <br><br>
An admin updated the answer,<br>

<strong style="font-size: 20px">{{ $answer->content }}</strong><br><br>

You may be notified again when this answer gets updated.

@component('mail::button', ['url' => ''])
Go to Question
@endcomponent

Wish to opt-out for updated answers? You can opt-out by clicking the button below.

@component('mail::button', ['url' => ''])
Opt-Out of Waitlist
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

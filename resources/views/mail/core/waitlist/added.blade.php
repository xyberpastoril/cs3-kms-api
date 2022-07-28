@component('mail::message')
# You are added to the waitlist.

Greetings, {{ $waitlister->email }},

You are added to the waitlist for the following question: **{{ $question->content }}** 
You will be notified in a separate email when this question is answered.

@component('mail::button', ['url' => ''])
Go to Question
@endcomponent

Haven't you added yourself to the waitlist? You can opt-out by clicking the button below.

@component('mail::button', ['url' => ''])
Opt-Out of Waitlist
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

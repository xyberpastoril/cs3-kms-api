@component('mail::message')
# You just asked a question.

Greetings, {{ $waitlister->email }},

You just asked the following question: **{{ $question->content }}** 
You will be notified in a separate email when this question is answered.

Want to update/delete this question? Click the button below. Please take note that you can no longer do so when this question is answered. 

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

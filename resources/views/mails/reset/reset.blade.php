@component('mail::message')
<p> Hi {{ $user->fullname }} </p>
<p> You have successfully reset your password </p>
@component('mail::panel')
If you did not reset your password, please contact the administrator to take action.
@endcomponent
Thank you </br> {{ config('app.name') }}
@endcomponent

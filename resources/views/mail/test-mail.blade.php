@component('mail::message')
# Welcome to the community!

Your account has been recharged Successfully. An attachment of your invoice has been given below.

@component('mail::button', ['url' => 'portal.inspire.com.bd'])
Check Validaity
@endcomponent

Thanks,<br>
Inspire Broadband!
@endcomponent

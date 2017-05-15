@component('mail::message')
# TFC - International Conference
## 9th and 10th November 2017


Hello {{ $data['name'] }},

We received your application, it will be confirmed after 15th of July.

If you need more information, feel free to contact us replying to this email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

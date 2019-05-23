@component('mail::message')
# TFC - International Conference
## 9th and 10th November 2017


Hello {{ $data['name'] }},

Thank you for your subscription.

**Your participation to the conference is confirmed.**

You will be contacted again in the next months.
In the meanwhile, get in touch and keep updated through the conference website and facebook account.

For further informations please don't hesitate to contact us.

The Film Corner International Conference
[thefilmcorner@cinetecamilano.it](mailto:thefilmcorner@cinetecamilano.it)

Thanks,<br>
{{ config('app.name') }}
@endcomponent

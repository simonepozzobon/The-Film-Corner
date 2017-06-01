@component('mail::message')
# TFC - International Conference
## 9th and 10th November 2017

C'è una nuova iscrizione alla conferenza.

- Dati: {{ $data['name'] }}, {{ $data['surname'] }}
- Email: {{ $data['email'] }}
- Istituzione: {{ $data['institution'] }}
- Ruolo: {{ $data['role'] }}
- Note: {{ $data['notes'] }}

{{ config('app.name') }}
@endcomponent

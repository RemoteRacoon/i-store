@component('mail::message')
<div class="h1 mb-4">
    Dear <span class="font-weight-bold text-muted">{{$user}}</span>, your order has been confirmed!
</div>
<p>
    <span class="h3 font-weight-bold">Your order:</span><br>
    <span class="font-weight-bold">Product: {{$label}}</span><br>
    <span class="font-weight-bold">Rent Rate: {{$rent_rate}}</span><br>
    <span class="font-weight-bold">Status: {{$state}}</span><br>
</p>
<p>Now your can choose rent period</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent

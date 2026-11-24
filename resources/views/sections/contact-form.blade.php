@php
    $typeSlugMap = [
        'hotel'     => 'Hotels',
        'holiday'   => 'Holiday package',
        'corporate' => 'Corporate travel',
        'umrah'     => 'Umrah or religious travel',
        'flight'    => 'Flights',
    ];

    $selectedTravelType = old('travel_type')
        ?? ($defaultTravelType ?? null)
        ?? ($typeSlugMap[request()->query('type')] ?? null);

    $travelTypeOptions = [
        'General travel enquiry',
        'Flights',
        'Hotels',
        'Holiday package',
        'Umrah or religious travel',
        'Corporate travel',
    ];
@endphp
<form class="contact-form" action="/send-enquiry" method="post" id="contact-enquiry-form">
    @csrf
    <div class="form-section-title">Your details</div>
    <div class="form-grid">
        <label @class(['has-error' => $errors->has('name')])>
            <span>Full name *</span>
            <input name="name" autocomplete="name" minlength="2" maxlength="255" value="{{ old('name') }}" required>
            @error('name')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('email')])>
            <span>Email *</span>
            <input name="email" type="email" autocomplete="email" maxlength="255" value="{{ old('email') }}" required>
            @error('email')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('phone')])>
            <span>Phone or WhatsApp *</span>
            <input name="phone" type="tel" autocomplete="tel" minlength="8" maxlength="50" value="{{ old('phone') }}" required>
            @error('phone')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('travel_type')])>
            <span>How can we help? *</span>
            <select name="travel_type" required>
                @foreach($travelTypeOptions as $option)
                <option @selected($selectedTravelType === $option)>{{ $option }}</option>
                @endforeach
            </select>
            @error('travel_type')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('company_name')])>
            <span>Company name</span>
            <input name="company_name" autocomplete="organization" maxlength="255" value="{{ old('company_name') }}">
            @error('company_name')<small class="field-error">{{ $message }}</small>@enderror
        </label>
    </div>

    <div class="form-section-title">Trip details</div>
    <div class="form-grid">
        <label @class(['has-error' => $errors->has('origin')])>
            <span>Leaving from</span>
            <input name="origin" maxlength="255" value="{{ old('origin') }}">
            @error('origin')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('destination')])>
            <span>Destination</span>
            <input name="destination" maxlength="255" value="{{ old('destination') }}">
            @error('destination')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('departure_date')])>
            <span>Departure date</span>
            <input name="departure_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('departure_date') }}">
            @error('departure_date')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('return_date')])>
            <span>Return date</span>
            <input name="return_date" type="date" min="{{ now()->toDateString() }}" value="{{ old('return_date') }}">
            @error('return_date')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label @class(['has-error' => $errors->has('travellers')])>
            <span>Travellers</span>
            <input name="travellers" type="number" min="1" max="50" value="{{ old('travellers') }}">
            @error('travellers')<small class="field-error">{{ $message }}</small>@enderror
        </label>
    </div>

    <div class="form-grid">
        <label class="form-span @error('message') has-error @enderror">
            <span>Tell us about your plans *</span>
            <textarea name="message" rows="6" minlength="10" required>{{ old('message') }}</textarea>
            @error('message')<small class="field-error">{{ $message }}</small>@enderror
        </label>
        <label class="honeypot" aria-hidden="true"><span>Company</span><input name="company" tabindex="-1" autocomplete="off"></label>
        <label class="form-consent form-span @error('consent') has-error @enderror">
            <input name="consent" type="checkbox" value="yes" required>
            <span>I agree that Fly Quick may use these details to respond to my enquiry.</span>
            @error('consent')<small class="field-error">{{ $message }}</small>@enderror
        </label>
    </div>

    @if(session('enquiry_sent'))
    <p class="form-success">Thank you — we'll be in touch soon.</p>
    @endif
    @if($errors->any())
    <p class="form-error">Please check the highlighted fields and try again.</p>
    @endif
    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-contact">
    <button class="button button-bright form-submit" type="submit">Send enquiry</button>
</form>

@if(config('recaptcha.api_site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('recaptcha.api_site_key') }}"></script>
<script>
document.getElementById('contact-enquiry-form').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = this;
    grecaptcha.ready(function() {
        grecaptcha.execute('{{ config('recaptcha.api_site_key') }}', {action: 'contact'}).then(function(token) {
            document.getElementById('g-recaptcha-response-contact').value = token;
            form.submit();
        });
    });
});
</script>
@endif

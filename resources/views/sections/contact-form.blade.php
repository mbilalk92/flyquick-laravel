<form class="contact-form" action="/send-enquiry" method="post" id="contact-enquiry-form">
    @csrf
    <div class="form-grid">
        <label><span>Full name *</span><input name="name" autocomplete="name" minlength="2" required></label>
        <label><span>Email *</span><input name="email" type="email" autocomplete="email" required></label>
        <label><span>Phone or WhatsApp *</span><input name="phone" type="tel" autocomplete="tel" minlength="8" required></label>
        <label><span>How can we help? *</span>
            <select name="travel_type" required>
                <option>General travel enquiry</option>
                <option>Flights</option>
                <option>Hotels</option>
                <option>Holiday package</option>
                <option>Umrah or religious travel</option>
                <option>Corporate travel</option>
            </select>
        </label>
        <label><span>Leaving from</span><input name="origin"></label>
        <label><span>Destination</span><input name="destination"></label>
        <label><span>Preferred dates</span><input name="dates"></label>
        <label><span>Travellers</span><input name="travellers"></label>
        <label class="form-span"><span>Tell us about your plans *</span><textarea name="message" rows="6" minlength="10" required></textarea></label>
        <label class="honeypot" aria-hidden="true"><span>Company</span><input name="company" tabindex="-1" autocomplete="off"></label>
        <label class="form-consent form-span">
            <input name="consent" type="checkbox" value="yes" required>
            <span>I agree that Fly Quick may use these details to respond to my enquiry.</span>
        </label>
    </div>
    @if(session('enquiry_sent'))
    <p class="form-success" style="color:green;font-weight:600;margin-bottom:1rem;">Thank you — we'll be in touch soon.</p>
    @endif
    @if($errors->any())
    <p class="form-error" style="color:red;margin-bottom:1rem;">Please check the form and try again.</p>
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

<script>
(function () {
    var HEADINGS = {
        AIR: 'Where would you like to fly?',
        HTL: 'Where would you like to stay?',
        PKG: 'Plan your perfect holiday package'
    };

    function setTab(tab) {
        document.querySelectorAll('[data-sabre]').forEach(function (btn) {
            var active = btn.dataset.sabre === tab;
            btn.classList.toggle('active', active);
            btn.setAttribute('aria-selected', active ? 'true' : 'false');
        });
        var h = document.getElementById('sabre-tab-heading');
        if (h) h.textContent = HEADINGS[tab] || '';
        var frame = document.getElementById('sabre-widget-frame');
        if (frame && frame.contentWindow) {
            frame.contentWindow.postMessage({ action: 'setTab', tab: tab }, '*');
        }
    }

    document.querySelectorAll('[data-sabre]').forEach(function (btn) {
        btn.addEventListener('click', function () { setTab(this.dataset.sabre); });
    });

    // Receive height reports from the iframe and resize it
    window.addEventListener('message', function (e) {
        if (e.data && e.data.type === 'fq-height') {
            var frame = document.getElementById('sabre-widget-frame');
            if (frame) frame.style.height = e.data.height + 'px';
        }
    });
})();
</script>

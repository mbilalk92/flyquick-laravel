<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Search widget</title>

<!-- Sabre / DEAgentBooking styles -->
<link rel="stylesheet" href="https://flights.flyquick.com.au/Portals/_default/Skins/DEAgentBooking/bootstrap/css/bootstrap.min.css?ts=20230821024238">
<!-- Angular Material's chevrons etc. render as literal text (e.g. "expand_more")
     without this — Angular Material itself doesn't ship the icon font. -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://flights.flyquick.com.au/Resources/Shared/components/Angular-Material/1.1.21/angular-material.min.css">
<link rel="stylesheet" href="https://flights.flyquick.com.au/Resources/Shared/components/angularjs-slider/6.4.3/rzslider.min.css">
<link rel="stylesheet" href="https://flights.flyquick.com.au/min/css/searchbox.css?ts=20230821024238">
<link rel="stylesheet" href="https://flights.flyquick.com.au/Style/agent.css?ts=20230821024238">

<style>
html, body {
    margin: 0;
    padding: 0;
    background: transparent;
    font-family: Tahoma, Helvetica, Arial, "Microsoft Yahei", STXihei, sans-serif;
}

/* ── Hide Sabre's own AIR/HTL/PKG tab nav (parent page controls it) ── */
.searchPanelType { display: none !important; }

/* HOME PAGE SEARCH BOX CSS — ported from reference widget */
.row.PaddingTop10.ng-scope { height: 0 !important; }
.PaddingTop10 { padding-top: 0 !important; }
.md-icon-button + .md-datepicker-input-container { margin-left: 0; }
.md-datepicker-input { min-width: 40px !important; }
#cbDirectFlight { margin: 0; }
.divDEACombinedSearchPanel { opacity: 1; }

.fly-search-panel md-datepicker,
.fly-search-panel md-select { padding: 8px 26px; }
.fly-search-panel.padding-firefox md-datepicker { padding: 8px 18px; }

.col-sm-6 .ng-binding { white-space: nowrap; font-weight: 600; color: #000; }
.ng-pristine.ng-untouched.ng-valid.ng-empty { margin-top: 0; }
.row.PaddingTop10 .col-xs-12.col-sm-3 { display: flex; padding: 14px; justify-content: space-evenly; }
#cbDirectFlight { align-items: center !important; }
.col-xs-12.col-sm-3 md-checkbox#cbLongConnectingFlight { margin: 0 !important; }
.col-xs-12 md-checkbox.ng-pristine.ng-untouched.ng-valid.ng-empty,
.col-xs-12 md-checkbox.ng-pristine.ng-untouched.ng-not-empty { margin-bottom: 8px; margin-top: 8px; color: #000; }

div#DEACombinedSearchPanel { margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; }

.fly-search-panel .divDEACombinedSearchPanel .md-datepicker-calendar-icon { color: #00aee8; }
[id^="searchButton"] { background: #00aee8 !important; border-color: #00aee8 !important; }
.divDEACombinedSearchPanel .div_greybox input { color: #999999 !important; }
.divDEACombinedSearchPanel .div_greybox { color: #00aee8 !important; }
#ddlCabin { color: #999999; }
/* Bootstrap's .btn-danger keeps its red border-color; only the background
   was being overridden, leaving a red outline around the selected
   Round Trip / One Way / Multi-City button. */
.tripTypeButton .btn-danger { background-color: #00aee8 !important; border-color: #00aee8 !important; }

/* ── Responsive (from reference widget — container widths removed for full-width layout) ── */
@media only screen and (min-width: 600px) and (max-width: 700px) {
    .md-datepicker-input { min-width: 163px !important; }
}

@media only screen and (max-width: 700px) {
    .panel-body { width: 100% !important; margin-left: -14px !important; }
}

@media only screen and (min-width: 700px) and (max-width: 768px) {
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 50% !important; }
    .md-datepicker-input { min-width: 203px !important; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: -314px; }
    .divAirMC .md-datepicker-input { margin-right: 306px; margin-bottom: 10px; }
    .col-xs-12.col-sm-3 { margin-top: -8px; }
}

@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .md-icon-button + .md-datepicker-input-container { border: none !important; }
}

@media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
    .md-icon-button + .md-datepicker-input-container { border: none; width: 75% !important; }
    input#ptc-Panel { width: 110% !important; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: 0; }
    md-checkbox .md-label { margin-left: 25px; }
    .ng-binding.ng-scope { font-size: 14px; }
    .row.PaddingTop10 .col-xs-12.col-sm-3 { margin-top: -7px; display: flow; }
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 100% !important; }
    .md-default-theme .md-datepicker-input-container,
    .md-datepicker-input-container { width: 200px !important; }
}

@media only screen and (min-width: 480px) and (max-width: 600px) {
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 50% !important; }
    .md-datepicker-input { min-width: 190px !important; margin: 0 !important; }
    .md-icon-button + .md-datepicker-input-container { border: none; width: 70% !important; }
    .row.PaddingTop10 .col-xs-12.col-sm-6 { width: 50%; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: -227px; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-5 { width: 40%; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-1.text-center { width: 10%; }
    .fly-search-panel md-datepicker, .fly-search-panel md-select { padding: 8px 18px; }
    .col-lg-4.mb-50.col-md-4.col-sm-6.col-xs-12.d-flex-md-center { width: 50%; }
}

@media only screen and (min-width: 590px) and (max-width: 700px) {
    .panel-body { padding-right: 1px; }
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 50% !important; }
    .md-datepicker-input { min-width: 203px !important; }
    .md-icon-button + .md-datepicker-input-container { border: none; width: 68% !important; }
    .row.PaddingTop10 .col-xs-12.col-sm-6 { width: 50%; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: -272px; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-5 { width: 40%; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-1.text-center { width: 10%; }
    .fly-search-panel md-datepicker, .fly-search-panel md-select { padding: 8px 26px; }
    .fly-search-panel.padding-firefox md-datepicker { padding: 8px 18px !important; }
    .col-lg-4.mb-50.col-md-4.col-sm-6.col-xs-12.d-flex-md-center { width: 50%; }
}

@media only screen and (min-width: 700px) and (max-width: 767px) {
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 50% !important; }
    .md-datepicker-input { min-width: 203px !important; }
    .md-icon-button + .md-datepicker-input-container { border: none; }
    .row.PaddingTop10 .col-xs-12.col-sm-6 { width: 50%; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: -325px; }
    .panel-body { padding-right: 1px; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-5 { width: 40%; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-1.text-center { width: 10%; }
    .fly-search-panel md-datepicker, .fly-search-panel md-select { padding: 8px 26px; }
    .fly-search-panel.padding-firefox md-datepicker { padding: 8px 18px !important; }
    .col-lg-4.mb-50.col-md-4.col-sm-6.col-xs-12.d-flex-md-center { width: 50%; }
}

@media only screen and (min-width: 768px) and (max-width: 992px) {
    .panel-body { padding-right: 1px; }
    .row.PaddingTop10.ng-scope .col-xs-12.col-sm-6:nth-child(-n + 2) { width: 50% !important; }
    .md-datepicker-input { min-width: 203px !important; }
    .md-icon-button + .md-datepicker-input-container { border: none; width: 148%; }
    .row.PaddingTop10 .col-xs-12.col-sm-6 { width: 50%; }
    .divAirMC ._md-datepicker-has-triangle-icon { margin-left: -335px; padding: 8px 28px; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-5 { width: 50% !important; }
    .divAirMC .row.PaddingTop10.ng-scope .col-xs-12.col-sm-1.text-center { width: 0%; display: none; }
    .divAirMC .md-icon-button + .md-datepicker-input-container { margin-left: 24px !important; margin-bottom: 11px; }
    #cbDirectFlight { align-items: center !important; margin-top: 4px; }
    .fly-search-panel md-datepicker, .fly-search-panel md-select { padding: 8px 41px; }
    .fly-search-panel.padding-firefox md-datepicker { padding: 8px 39px !important; }
}
</style>
</head>
<body>

<div class="fly-search-panel">
    <div style="background: url('') center top no-repeat; background-size: cover;">
        <div class="container" ng-app="DEASearchApp">
            <div class="row" ng-controller="DEASearchPnlCtrl" ng-init="DefaultItem='AIR'">
                <div id="DEACombinedSearchPanel"
                     class="divDEACombinedSearchPanel"
                     TargetServer="https://secl-au-flyquick.azurewebsites.net"
                     RouteURL=""
                     AgentID="flyquick"
                     ng-init="data2.ServiceType='';EmbedLang='en-US';OpenTarget='_blank';Referrer=''">

                    <!-- Sabre's own AIR/HTL/PKG nav — hidden via CSS, kept for Angular state -->
                    <div>
                        <ul class="nav nav-pills searchPanelType" style="margin-left:13px">
                            <li id="searchPanelType-Air" ng-class="{'active': data.SelectedItem == 'AIR'}" ng-if="bEnableFlight && !bHideFlightItem">
                                <a id="searchPanelType-Air-tab" data-toggle="pill" href="#" ng-click="data.SelectedItem='AIR'">
                                    <br><span ng-bind="getLabel('AirTicket')" class="ng-binding"></span><br>
                                </a>
                            </li>
                            <li id="searchPanelType-Htl" ng-class="{'active': data.SelectedItem == 'HTL'}" ng-if="bEnableHotel && !bHideHotelItem">
                                <a id="searchPanelType-Htl-tab" data-toggle="pill" href="#" ng-click="data.SelectedItem='HTL'">
                                    <br><span ng-bind="getLabel('Hotel')" class="ng-binding"></span><br>
                                </a>
                            </li>
                            <li id="searchPanelType-Pkg" ng-class="{'active': data.SelectedItem == 'PKG'}" ng-if="bEnableDynamicPackage && !bHideDP">
                                <a id="searchPanelType-Pkg-tab" data-toggle="pill" href="#" ng-click="data.SelectedItem='PKG'">
                                    <br><span ng-bind="getLabel('FlightAndHotel')" class="ng-binding"></span><br>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content searchPanel">
                        <div id="flight" ng-show="data.SelectedItem=='AIR'">
                            <div ng-include="'https://secl-au-flyquick.azurewebsites.net/DesktopModules/DEAAirSearchResult/DEASearchPanel.min.html?ts=20240321081049' | trustAsResourceUrl" class="ng-scope"></div>
                        </div>
                        <div id="hotel" ng-show="data.SelectedItem=='HTL'">
                            <div ng-include="'https://secl-au-flyquick.azurewebsites.net/DesktopModules/DEAHotelSearchResult/DEAHotelSearchPanel.min.html?ts=20240321081049' | trustAsResourceUrl" class="ng-scope"></div>
                        </div>
                        <div id="flightAndHotel" ng-show="data.SelectedItem=='PKG'">
                            <div ng-include="'https://secl-au-flyquick.azurewebsites.net/DesktopModules/DEAPkgSearchResult/DEAPkgSearchPanel.min.html?ts=20240321081049' | trustAsResourceUrl" class="ng-scope"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sabre / DEAgentBooking scripts — load order matters -->
<script src="https://flights.flyquick.com.au/Resources/libraries/jQuery/03_04_01/jquery.min.js"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular-animate.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular-aria.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular-messages.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular-route.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/angular-sanitize.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Portals/_default/Skins/DEAgentBooking/bootstrap/js/bootstrap.min.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/ui-bootstrap-tpls-1.3.2.min.js"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/components/Angular-Material/1.1.21/angular-material.min.js"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/components/angularjs-slider/6.4.3/rzslider.min.js"></script>
<script src="https://flights.flyquick.com.au/Resources/Shared/Scripts/moment-with-locales.js?ts=20230821024238"></script>
<script src="https://flights.flyquick.com.au/min/js/searchbox.js?ts=20230821024239"></script>
<script src="https://flights.flyquick.com.au/Style/agent.js?ts=20230821024238"></script>

<script>
(function () {
    // ── Inline agent settings ──────────────────────────────────────────
    window.__DEA_AGENT_SETTINGS = {
        "AgentID": "flyquick", "iNetVersionNo": "", "CSContactNumber": "61390171800",
        "Email": "info@flyquick.com.au", "bEnableFlight": true, "bEnableHotel": true,
        "bEnableOtherServices": false, "bEnableDynamicPackage": true, "bEnableTour": false,
        "bEnableCarRental": false, "bEnableCarRentalMarkup": false, "bEnableCarRentalCrossSell": false,
        "bEnableCorpBooking": true, "bEnableCorpDashboard": false, "CorpDashBoardCurSign": "$",
        "CorpDocStatusPLabel": "Confirmed", "bEnableCorpReports": false, "bEnableCorpInvoices": false,
        "bEnableCorpCreditNotes": false, "bDownloadCrCardInfoToPNR": false,
        "bCorpProfileShowMandatoryOnly": false, "bPayFailNotCancelPNR": true,
        "bEnableOSIAffiliate": false, "bHideFlightItem": false, "bHideHotelItem": false,
        "bHideServiceItem": false, "bHideTourItem": false, "bHideDP": false, "bHideCarRental": false,
        "DepartureDateOffset": 2, "DefaultCurrencyCode": "AUD", "DefaultCurrencyDisplay": "AUD ",
        "DefaultNationality": "AU", "DefaultAirNoAdult": 1, "DefaultHotelNoAdult": 2,
        "DefaultDPNoAdult": 2, "bDefaultDirectFlight": false, "bAllowLongConnectingFlight": true,
        "bDefaultLongConnectingFlight": false, "bSearchWithFlightTime": false,
        "bEnableFFPFareSearch": false, "bEnableFlexibleDay": true, "bEnableOneWay": true,
        "bEnableRoundTrip": true, "bEnableMultiCity": true, "bAirFareShowNationality": false,
        "TravelerType": [
            {"Description": [{"AgentID": "flyquick", "Lang": "en-US", "PTC": "ADT", "SpecialMessage": "", "OtherFOPDescription": ""}],
             "AgentID": "flyquick", "SeqNo": 1, "PTC": "ADT", "bAIR": true, "bHTL": true, "bPKG": true, "bMISC": true,
             "bEnablePaymentGateway": false, "bEnableOtherFOP": true, "bEnabled": true},
            {"Description": [{"AgentID": "flyquick", "Lang": "en-US", "PTC": "CNN", "SpecialMessage": "", "OtherFOPDescription": ""}],
             "AgentID": "flyquick", "SeqNo": 2, "PTC": "CNN", "bAIR": true, "bHTL": true, "bPKG": true, "bMISC": true,
             "bEnablePaymentGateway": false, "bEnableOtherFOP": true, "bEnabled": true},
            {"Description": [{"AgentID": "flyquick", "Lang": "en-US", "PTC": "INF", "SpecialMessage": "", "OtherFOPDescription": ""}],
             "AgentID": "flyquick", "SeqNo": 3, "PTC": "INF", "bAIR": true, "bHTL": false, "bPKG": false, "bMISC": false,
             "bEnablePaymentGateway": false, "bEnableOtherFOP": true, "bEnabled": true}
        ],
        "bFirstLastNameDisplay": false, "SearchPanelBackgroundDisplay": "", "MaxAllowedNoRoom": 9,
        "HotelConsoleID": "SABRE", "bEnableSabreCSLAPI": true, "minHotelStar": 3,
        "bEnablePaymentGateway": true, "bPaymentByDeposit": false, "MiscServiceTypeForSearchPanel": [],
        "bCorpMode": false, "bAdvancedCorp": false, "FamilyTripType": "",
        "defaultDeparture": {"airportcod": "MEL", "citycode": "MEL", "cntrycode": "AU",
            "display": "Melbourne, AU (MEL - Melbourne Airport)"},
        "CarDepartureDateOffset": 0, "CarTransferPickupbuffer": 1, "bShowInPolicyFlag": false,
        "bShowFareOfferSource": false, "HotelRatePlanCode": null, "HotelRatePlanDesc": null,
        "HotelRateCode": null, "bEnableNDCSearch": true, "bLoginRequireMFA": false
    };

    // ── Patch DEACommonSrv to resolve with inline settings ────────────
    if (typeof angular !== 'undefined' && angular.module) {
        try {
            angular.module('DEACommonMod').config(['$provide', function ($provide) {
                $provide.decorator('DEACommonSrv', ['$delegate', '$q', function ($delegate, $q) {
                    $delegate.getAgentSettings = function () {
                        var d = $q.defer(); d.resolve(window.__DEA_AGENT_SETTINGS); return d.promise;
                    };
                    return $delegate;
                }]);
            }]);
        } catch (e) { console.error('[Sabre] Failed to patch DEACommonSrv:', e); }
    }

    // ── Firefox datepicker fix (from reference widget) ─────────────────
    $(document).ready(function () {
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            $('.fly-search-panel md-datepicker, .fly-search-panel md-select').css('padding', '8px 18px');
            $('.fly-search-panel').addClass('padding-firefox');
        } else {
            $('.fly-search-panel md-datepicker, .fly-search-panel md-select').css('padding', '8px 30px');
        }
    });

    // ── Height reporting to parent iframe ──────────────────────────────
    var lastH = 0;
    function reportHeight() {
        var h = Math.max(document.body.scrollHeight, document.documentElement.scrollHeight);
        if (h !== lastH) { lastH = h; window.parent.postMessage({ type: 'fq-height', height: h }, '*'); }
    }
    window.addEventListener('load', reportHeight);
    window.addEventListener('resize', reportHeight);

    // ── Tab switching: parent sends { action: 'setTab', tab: 'HTL' } ──
    window.addEventListener('message', function (e) {
        if (!e.data || e.data.action !== 'setTab') return;
        var ctrl = document.querySelector('[ng-controller="DEASearchPnlCtrl"]');
        if (ctrl && typeof angular !== 'undefined') {
            try {
                var scope = angular.element(ctrl).scope();
                if (scope) scope.$apply(function () { scope.data.SelectedItem = e.data.tab; });
            } catch (err) {}
        }
        setTimeout(reportHeight, 200);
    });

    // ── MutationObserver: height updates when Angular renders content ──
    new MutationObserver(function (muts) {
        if (muts.some(function (m) { return m.addedNodes.length > 0; })) reportHeight();
    }).observe(document.body, { childList: true, subtree: true });
})();
</script>

</body>
</html>

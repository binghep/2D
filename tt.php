
<style type="text/css">
	.bdMainFD .searchEntryArea.simpleMode {
    position: relative;
}
	.bdMainFD .searchEntryArea {
    max-width: 1005px;
    min-width: 1005px;
}


</style>
<!----------------------------part 1:search header started-----------------------------/-->
<div class="headerAndSearchType">
<h1 class="titleText">
Flights </h1>
<div class="s14 fieldBlock fieldBlockSearchType">
<span class="r9-radiobuttonset " id="flightSearchTypes">
<input class="r9-radiobuttonset ui-helper-hidden-accessible" id="roundtrip" name="oneway" type="radio" value="n" checked="checked">
<label class="r9-radiobuttonset-label r9-radiobuttonset-label-first r9-radiobuttonset-label-checked" id="roundtrip-label" for="roundtrip" title="Round-trip" role="button"><span>Round-trip</span></label>
<input class="r9-radiobuttonset ui-helper-hidden-accessible" id="onewaytrip" name="oneway" type="radio" value="y">
<label class="r9-radiobuttonset-label" id="onewaytrip-label" for="onewaytrip" title="One-way" role="button"><span>One-way</span></label>
<input class="r9-radiobuttonset ui-helper-hidden-accessible" id="multi" name="oneway" type="radio" value="m">
<label class="r9-radiobuttonset-label r9-radiobuttonset-label-last" id="multi-label" for="multi" title="Multi-city" role="button"><span>Multi-city</span></label>
</span>
</div>
<div class="clear"></div>
</div>



<!----------------------------part 1:search header finished-----------------------------/-->
<!----------------------------part 2:search block started-----------------------------/-->

<div class="searchEntryArea simpleMode">
<div class="fieldBlock fieldBlockAirport fieldBlockOrigin">
<div class="fieldInput airportField fieldInputHasValue">
<input type="text" class="r9-textinput autocomplete selectTextOnFocus initialFormField r9-smarty-input " id="origin" name="origin" value="LAX" placeholder="From" maxlength="90" autocomplete="off" autocapitalize="off" autocorrect="off">
<div id="originDepartureSwitch" onclick="switchFlightDepartReturn()"></div>
<input type="hidden" id="origincode" name="origincode" value="LAX">
<input type="hidden" id="st_origin" name="st_origin" value="LAX">
<div class="customAirportOptions">
<div class="nearbyOption">
<span class="r9-checkbox-wrapper " id="nearbyO-wrapper">
<a id="nearbyO-icon" class="r9-checkbox-icon">
<input class="r9-checkbox-input newCheckbox" id="nearbyO" type="checkbox" name="nearbyO" value="y" tabindex="-1">
</a>
<label for="nearbyO" class="r9-checkbox-label" title="Include nearby">Include nearby</label>
</span>
</div>
</div>
</div>
</div>
<div class="fieldBlock fieldBlockAirport fieldBlockDestination">
<div class="fieldInput airportField">
<input type="text" class="r9-textinput autocomplete selectTextOnFocus middleFormField r9-smarty-input " id="destination" name="destination" value="" placeholder="To" maxlength="90" autocomplete="off" autocapitalize="off" autocorrect="off">
<input type="hidden" id="destcode" name="destcode" value="">
<input type="hidden" id="st_destination" name="st_destination" value="">
<div class="customAirportOptions">
<div class="nearbyOption">
<span class="r9-checkbox-wrapper " id="nearbyD-wrapper">
<a id="nearbyD-icon" class="r9-checkbox-icon">
<input class="r9-checkbox-input newCheckbox" id="nearbyD" type="checkbox" name="nearbyD" value="y" tabindex="-1">
</a>
<label for="nearbyD" class="r9-checkbox-label" title="Include nearby">Include nearby</label>
</span>
</div>
</div>
</div>
</div>
<div id="departreturn" class="fieldBlockEndWrapper">
<div class="fieldBlock fieldBlockDateEntry fieldBlockDepartDate flexAware flexAwareExact flexAwarePlusminusthree flexAwareOpenflex">
<div class="fieldInput dateField departDateField">
<div id="travel_dates-start-wrapper" class="r9-datepicker-wrapper r9-datepicker-twofields">
<span class="r9-datepicker-icon r9-icon-calendar-depart"></span>
<span id="travel_dates-start" class="r9-datepicker-section r9-datepicker-start">
<span tabindex="0" id="travel_dates-start-display" contenteditable="true" class="r9-datepicker-display" aria-label="Start Date">Fri 8/12</span>
<span id="travel_dates-start-placeholder" class="r9-datepicker-placeholder">Depart</span>
</span>
<span id="travel_dates-start-clear" class="r9-datepicker-clear"></span>
<input type="text" id="travel_dates-start-tab" tabindex="-1" class="r9-datepicker-tab" readonly="true">
<input type="text" id="depart_date" name="depart_date" value="" class="r9-datepicker-input r9-datepicker-start">
</div>
</div>
</div>
<div class="fieldBlock fieldBlockDateEntry fieldBlockReturnDate roundtriponly flexAware flexAwareExact flexAwarePlusminusthree" style="visibility: visible;">
<div class="fieldInput dateField returnDateField">
<div id="travel_dates-end-wrapper" class="r9-datepicker-wrapper r9-datepicker-twofields">
<span class="r9-datepicker-icon r9-icon-calendar-return"></span>
<span id="travel_dates-end" class="r9-datepicker-section r9-datepicker-end">
<span tabindex="0" id="travel_dates-end-display" contenteditable="false" class="r9-datepicker-display" aria-label="End Date">Fri 8/12</span>
<span id="travel_dates-end-placeholder" class="r9-datepicker-placeholder">Return</span>
</span>
<span id="travel_dates-end-clear" class="r9-datepicker-clear"></span>
<input type="text" id="travel_dates-end-tab" tabindex="-1" class="r9-datepicker-tab" readonly="true">
<input type="text" id="return_date" name="return_date" value="" class="r9-datepicker-input r9-datepicker-end">
</div>
</div>
</div>
<div class="fieldBlock fieldBlockTravelers">
<div id="travelers" class="travelers r9-dropdownDialog-wrapper">
<a href="javascript:void(0)" class="r9-dropdownDialog-trigger r9-dropdownDialog-hasValue">
<span class="r9-dropdownDialog-label">1 adult, Economy</span>
<span class="r9-dropdownDialog-icon"></span>
<input style="display: none" type="text" name="travelers" value="">
<span class="r9-dropdownDialog-placeholder"></span></a>
<div class="r9-dropdownDialog-content travelerSelectWindow">
<div class="fieldBlock fieldBlockCabinClass">
<span class="PTCTypeLabel">Cabin</span>
<a class="r9-dropdown-wrapper r9-dropdown defaultSelect middleFormField" id="cabin-wrapper">
<span id="cabin-status" class="r9-dropdown-status">Economy</span>
<span class="r9-dropdown-icon"></span>
<select id="cabin" name="cabin" class="r9-dropdown-select" title="Economy">
<option value="e" title="Economy" selected="selected">Economy</option>
<option value="p" title="Premium Economy">Premium Economy</option>
<option value="b" title="Business">Business</option>
<option value="f" title="First">First</option>
</select>
</a>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcAdults" data-for="Adults">
<span class="PTCTypeLabel">Adults</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-Adults">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-Adults-input" value="1" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">18-64</span>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcSeniors" data-for="Seniors">
<span class="PTCTypeLabel">Seniors</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-Seniors">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-Seniors-input" value="0" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">65+</span>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcYouth" data-for="Youth" data-age="17">
<span class="PTCTypeLabel">Youths</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-Youth">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-Youth-input" value="0" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">12-17</span>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcChildren" data-for="Children" data-age="11">
<span class="PTCTypeLabel">Children</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-Children">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-Children-input" value="0" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">2-11</span>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcInfants" data-for="Infants" data-age="1S">
<span class="PTCTypeLabel">Seat Infants</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-Infants">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-Infants-input" value="0" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">under 2</span>
<div class="clearfix"></div>
</div>
<div class="fieldInput fieldInputSelect fieldInputPTCType ptcLapInfants" data-for="LapInfants" data-age="1L">
<span class="PTCTypeLabel">Lap Infants</span>
<div class="r9NumberBox PTCNumberBox" id="travelers-LapInfants">
<button type="button" class="ui-button ui-button-gray bags-button-left decrementor">
<span class="incrdecrWrapper minus">
</span>
</button>
<input class="numberHolder" tabindex="-1" name="travelers-LapInfants-input" value="0" readonly="">
<button type="button" class="ui-button ui-button-gray bags-button-right incrementor">
<span class="incrdecrWrapper plus">
</span>
</button>
<div class="clear"></div>
</div>
<span class="PTCTypeAgeRange">under 2</span>
<div class="clearfix"></div>
</div>
<div class="closeDropdown">
<a class="closeLink" href="javascript:void(0)">Close</a>
</div>
<div style="display: none" class="ptcSpoof">
<input id="ptcChildren" type="hidden" name="children" value="0">
<input id="ptcAdults" type="hidden" name="adults" value="1">
<input id="ptcSeniors" type="hidden" name="seniors" value="0">
<input id="childAge1" type="hidden" name="childAge1" value="">
<input id="childAge2" type="hidden" name="childAge2" value="">
<input id="childAge3" type="hidden" name="childAge3" value="">
<input id="childAge4" type="hidden" name="childAge4" value="">
<input id="childAge5" type="hidden" name="childAge5" value="">
</div>
</div>
</div>
<div class="fieldBlockPTCWarnings">
<div class="infantInLapWarning" style="display: none;">
The price shown for each flight will be the average for all passengers including any infants. </div>
</div>
</div>
<div class="fieldBlock fieldBlockSubmitButton">
<button class="ui-button ui-button-huge finalFormField" id="fdimgbutton" type="submit">
<span>Search</span>
</button>
</div>
<div class="clear"></div>
<div class="moreSearchOptionsBlock clearfix">
<a class="toggleSearchOptions" id="moreOptionsLink">Show flexible dates</a>
</div>
</div>
</div>

<!----------------------------part 1:search block finished-----------------------------/-->

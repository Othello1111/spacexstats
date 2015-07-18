@extends('templates.main')

@section('title', 'Create Mission')
@section('bodyClass', 'create-mission')

@section('scripts')
    <script data-main="/src/js/common" src="/src/js/require.js"></script>
    <script>
        require(['common'], function() {
            require(['knockout', 'viewmodels/MissionViewModel'], function(ko, MissionViewModel) {
                ko.applyBindings(new MissionViewModel());
            });
        });
    </script>

    <script type="text/html" id="partFlight-template">
        <div>
            <h3 data-bind="text: heading"></h3>

            <label>Name</label>
            <input type="text" data-bind="textInput: part.name"/>

            <!-- ko if: part.type() == 'Booster' || part.type() == 'First Stage' -->
                <label>Landing Legs?</label>
                <input type="checkbox" data-bind="checked: firststage_landing_legs" />

                <label>Grid Fins?</label>
                <input type="checkbox" data-bind="checked: firststage_grid_fins" />

                <label>Engine</label>
                <select data-bind="value: firststage_engine, options: $root.dataLists.firstStageEngines"></select>

                <label>Engine Failures</label>
                <input type="text" data-bind="text: firststage_engine_failures" />

                <label>MECO time</label>
                <input type="text" data-bind="text: firststage_meco" />

                <label>Landing Coords (lat)</label>
                <input type="text" data-bind="text: firststage_landing_coords_lat" />

                <label>Landing Coords (lng)</label>
                <input type="text" data-bind="text: firststage_landing_coords_lng" />

                <label>Baseplate Color</label>
                <input type="text" data-bind="text: baseplate_color" />
            <!-- /ko -->

            <!-- ko if: part.type() == 'Upper Stage' -->
                <label>Engine</label>
                <select data-bind="value: upperstage_engine, options: $root.dataLists.upperStageEngines, optionsCaption: 'null'"></select>

                <label>Status</label>
                <select data-bind="value: upperstage_status, options: $root.dataLists.upperStageStatuses, optionsCaption: 'null'"></select>

                <label>SECO time</label>
                <input type="text" data-bind="text: upperstage_seco"/>

                <label>Decay Date</label>
                <datetime params="value: upperstage_decay_date, type: 'date', startYear: 2006, nullable: true"></datetime>

                <label>NORAD ID</label>
                <input type="text" data-bind="text: upperstage_norad_id"/>

                <label>International Designator</label>
                <input type="text" data-bind="text: upperstage_intl_designator"/>
            <!-- /ko -->

            <label>Landed?</label>
            <input type="checkbox" data-bind="checked: landed" />

            <label>Notes</label>
            <textarea data-bind="text: note"></textarea>
        </div>
    </script>

    <script type="text/html" id="payload-template">
        <div>
            <label>Payload Name</label>
            <input type="text" data-bind="text: name" />

            <label>Operator</label>
            <input type="text" data-bind="text: operator" />

            <label>Mass</label>
            <input type="text" data-bind="text: mass" />

            <label>Payload Name</label>
            <input type="checkbox" data-bind="text: primary" />

            <label>Gunter's Space Page Link</label>
            <input type="text" data-bind="text: link" />

            <button data-bind="click: $root.payloadSelection.removePayload">Remove This Payload</button>
        </div>
    </script>

    <script type="text/html" id="spacecraftFlight-template">
        <div>
            <h3 data-bind="text: spacecraft.name"></h3>

            <label>Name</label>
            <input type="text" data-bind="textInput: spacecraft.name"/>

            <label>Type</label>
            <select data-bind="value: spacecraft.type, options: $root.dataLists.spacecraftTypes"></select>

            <label>Flight Name</label>
            <input type="text" data-bind="text: iss_berth"/>

            <label>End Of Mission</label>

            <label>Return Method</label>
            <select data-bind="value: spacecraft.return_method, options: $root.dataLists.spacecraftReturnMethods"></select>

            <label>Upmass</label>
            <input type="text" data-bind="text: upmass"/>

            <label>Downmass</label>
            <input type="text" data-bind="text: downmass"/>

            <label>ISS Berth</label>

            <label>ISS Unberth</label>

            <fieldset>
                <label>Astronauts</label>

                <!-- ko with: $root.astronautSelection -->
                <select data-bind="value: selectedAstronaut, options: $root.dataLists.astronauts, optionsText: 'fullName', optionsCaption: 'New...'"></select>
                <button data-bind="click: addAstronaut">Add Astronaut</button>
                <!-- /ko -->

                <!-- ko template: { name: 'astronaut-template', foreach: astronautFlights, as: 'astronautFlight' } -->
                <!-- /ko -->
            </fieldset>

            <button data-bind="click: $root.spacecraftSelection.removeSpacecraft">Remove Spacecraft</button>
        </div>
    </script>

    <script type="text/html" id="astronaut-template">
        <div>
            <h3 data-bind="text: astronaut.full_name"></h3>
            <label>First Name</label>
            <input type="text" data-bind="textInput: astronaut.first_name" />

            <label>Last Name</label>
            <input type="text" data-bind="textInput: astronaut.last_name" />

            <label>Gender</label>
            <input type="radio" name="gender" value="Male" data-bind="checked: astronaut.gender" />Male
            <input type="radio" name="gender" value="Female" data-bind="checked: astronaut.gender" />Female

            <label>Deceased</label>
            <input type="checkbox" data-bind="text: astronaut.deceased" />

            <label>Date of Birth</label>
        </div>
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <h1>Create A Mission</h1>
        <main>
            <form data-bind="with: mission">

                <fieldset>
                    <legend>Mission</legend>

                    <label>Mission Name</label>
                    <input type="text" data-bind="value: name"/>

                    <label>Mission Type</label>
                    <span>Selecting the type of mission determines the mission icon and image, if it is not set.</span>
                    <select data-bind="value: mission_type_id, options: $root.dataLists.missionTypes, optionsText: 'name', optionsValue: 'mission_type_id'"></select>

                    <label for="">Contractor</label>
                    <input type="text" data-bind="value: contractor"/>

                    <label for="">Launch Date Time</label>
                    <input type="text" data-bind="value launch_date_time"/>

                    <label for="">Destination</label>
                    <select data-bind="value: destination_id, options: $root.dataLists.destinations, optionsText: 'destination', optionsValue: 'destination_id'"></select>

                    <label for="">Launch Site</label>
                    <select data-bind="value: launch_site_id, options: $root.dataLists.launchSites, optionsText: 'name', optionsValue: 'location_id'"></select>

                    <label for="">Summary</label>
                    <input type="text" data-bind="value: summary"/>
                </fieldset>

                <fieldset data-bind="with: $root.partSelection">
                    <legend>Parts</legend>
                    <div class="add-parts">
                        <div data-bind="click: filterByBoosters">Add a Booster</div>
                        <div data-bind="click: filterByFirstStages">Add a First Stage</div>
                        <div data-bind="click: filterByUpperStages">Add an Upper Stage</div>

                        <select data-bind="value: selectedPart, options: filteredParts, optionsText: 'name', optionsCaption: 'New...'"></select>
                        <button data-bind="click: addPart">Add Part</button>
                    </div>

                    <!-- ko template: { name: 'partFlight-template', foreach: $root.mission.partFlights, as: 'partFlight' } -->
                    <!-- /ko -->
                </fieldset>

                <fieldset data-bind="with: $root.payloadSelection">
                    <legend>Payloads</legend>
                    <button data-bind="click: addPayload">Add Payload</button>

                    <!-- ko template: { name: 'payload-template', foreach: $root.mission.payloads, as: 'payload' } -->
                    <!-- /ko -->
                </fieldset>

                <fieldset data-bind="with: $root.spacecraftSelection">
                    <legend>Spacecraft</legend>
                    <button data-bind="click: addSpacecraft">Add Spacecraft</button>

                    <!-- ko template: { name: 'spacecraftFlight-template', foreach: $root.mission.spacecraftFlight, as: 'spacecraftFlight' } -->
                    <!-- /ko -->
                </fieldset>

                <input type="submit" data-bind="click: $root.run" />
            </form>

        </main>
    </div>
@stop
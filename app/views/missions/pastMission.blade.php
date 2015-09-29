@extends('templates.main')
@section('title', $mission->name)

@section('content')
<body class="past-mission" ng-controller="pastMissionController" ng-strict-di>

    @include('templates.flashMessage')
    @include('templates.header')

    <div class="content-wrapper">
        <h1>{{ $mission->name }}</h1>
        <main>
            <nav class="sticky-bar">
                <ul class="container">
                    <li class="grid-1">Article</li>
                    <li class="grid-1">Details</li>
                    <li class="grid-1">Timeline</li>
                    <li class="grid-1">Images</li>
                    <li class="grid-1">Videos</li>
                    <li class="grid-1">Documents</li>
                    <li class="grid-1">Articles</li>
                    <li class="grid-1">Analytics</li>
                    <li class="grid-3 actions">
                        <a class="link" href="/missions/{{ $mission->slug }}/edit"><i class="fa fa-pencil"></i></a>
                        <i class="fa fa-twitter"></i>
                        <i class="fa fa-rss"></i>
                    </li>
                    <li class="grid-2">{{ $mission->status }} - {{ $mission->outcome }}</li>
                </ul>
            </nav>

            <section class="highlights">
                @if(isset($pastMission))
                    <div class="past-mission-link">
                        {{ link_to_route('missions.get', $pastMission->name, $pastMission->slug) }}
                        <span>Previous Mission</span>
                    </div>
                @endif
                @if(isset($futureMission))
                    <div class="future-mission-link">
                        {{ link_to_route('missions.get', $futureMission->name, $futureMission->slug) }}
                        <span>Next Mission</span>
                    </div>
                @endif
            </section>

            {{ $mission->present()->article() }}

            <h2>Details</h2>
            @include('templates.missionCard', ['size' => 'large', 'mission' => $mission])
            <div class="grid-8">
                <h3>Flight Details</h3>
                @if(count($mission->spaceflightFlight))
                    <h3>Dragon</h3>
                @endif
                <h3>Satellites</h3>
                <h3>Upper Stage</h3>
            </div>
            <div class="grid-4">
                <h3>Library</h3>
                <ul class="library">

                    <li id="launch-video">
                        <span>Watch the Launch</span>
                    </li>

                    @if($mission->missionPatch()->count() == 1)
                        <li id="mission-patch">
                            <img src="{{ $mission->missionPatch->thumb_small }}"/>
                            <span>{{ $mission->name }} Mission Patch</span>
                        </li>
                    @endif

                    <li id="press-kit">
                        <span>Press Kit</span>
                    </li>

                    @if($mission->spacecraftFlight()->count() == 1)
                        <li id="cargo-manifest">
                            <span>Cargo Manifest</span>
                        </li>
                    @endif

                    <li id="prelaunch-press-conference">
                        <span>Prelaunch Press Conference</span>
                    </li>

                    <li id="postlaunch-press-conference">
                        <span>Postlaunch Press Conference</span>
                    </li>

                    <li id="reddit-discussion">
                        <span>/r/SpaceX Reddit Live Thread</span>
                    </li>

                    <li id="flightclub-link">
                        <span>FlightClub Simulation</span>
                    </li>

                    <li id="raw-data-download">
                        <span>{{ link_to_route('missions.raw', 'Raw Data Download', $mission->slug) }}</span>
                    </li>

                    <li id="mission-collection">
                        <span>{{ $mission->name }} Mission Collection</span>
                    </li>

                </ul>
            </div>
            <h2>Timeline</h2>
            <h3>Prelaunch</h3>
            <h3>Launch</h3>
            <h3>Postlaunch</h3>

            <h2>Images</h2>
            <section class="images">
            </section>
            <h2>Videos</h2>
            <section class="videos">
            </section>
            <h2>Documents</h2>
            <section class="documents">
            </section>
            <h2>Articles</h2>
            <section class="articles">
            </section>

            <h2>Analytics</h2>
            <section class="analytics">
                <chart class="dataplot" data="altitudeVsTime" axis-key="timestamp" y-axis-key="altitude" title="Altitude vs. Time" width="500px" height="500px" padding="50"></chart>
                <ul>
                    <li>Data plots</li>
                    <li>Upper Stage Tracking</li>
                    <li>Estimators for Data plots</li>
                    <li></li>
                    <li></li>
                </ul>
            </section>
        </main>
    </div>
</body>
@stop
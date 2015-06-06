@extends('templates.main')

@section('title', $mission->name)
@section('bodyClass', 'future-mission')

@section('scripts')
	@if (!is_null($mission->launch_exact))
		{{ HTML::script('/assets/js/viewmodels/FutureMissionViewModel.js') }}
		<script type="text/javascript">
			$(document).ready(function() {
				ko.applyBindings(new FutureMissionViewModel('{{ $mission->slug }}', '{{ $mission->present()->launchDateTime(DateTime::ISO8601) }}'));
			});
		</script>
	@endif
@stop

@section('content')
<div class="content-wrapper">
	<h1>{{ $mission->name }}</h1>
	<main>
		<nav class="sticky-bar">
			<ul class="container">
				<li class="grid-1">Countdown</li>
				<li class="grid-1">Details</li>
				<li class="grid-1">Timeline</li>
				<li class="grid-1">Images</li>
				<li class="grid-1">Videos</li>
				<li class="grid-1">Articles</li>
				<li class="grid-2 prefix-3 actions">
					@if (Auth::isAdmin())
						<a href="/missions/{{$mission->slug}}/edit"><i class="fa fa-pencil"></i></a>
					@endif
					<i class="fa fa-twitter"></i>
					@if (Auth::isMember())
						<a href="/users/{{Auth::user()->username}}/edit#email-notifications"><i class="fa fa-envelope-o"></i></a>
					@else
						<a href="/docs#email-notifications"><i class="fa fa-envelope-o"></i></a>
					@endif
					<i class="fa fa-calendar"></i>
					<a href="http://www.google.com/calendar/render?cid={{ Request::url() }}"><i class="fa fa-google"></i></a>
					<i class="fa fa-rss"></i>
				</li>
				<li class="grid-1">Status</li>
			</ul>
		</nav>
		<section class="highlights">
			@if (!is_null($mission->launch_exact))
				<div class="webcast-status" data-bind="css: webcast.status, visible: webcast.status !== 'webcast-inactive'">
					<span data-bind="text: webcast.publicStatus"></span><span class="live-viewers" data-bind="text: webcast.publicViewers, visible: webcast.status() === 'webcast-live'"></span>
				</div>
				<div class="display-date-time">
					<div class="launch" data-bind="text: launchDateTime"></div>
					<div class="timezone">
						<span class="timezone-current">UTC</span>
						<ul class="timezone-list">
							<li class="timezone-option">Local</li>
							<li class="timezone-option">ET</li>
							<li class="timezone-option">PT</li>
							<li class="timezone-option active">UTC</li>
						</ul>
					</div>
				</div>
			@endif
		</section>
		<section class="hero hero-centered" id="countdown">
		@if (!is_null($mission->launch_exact))
			<table class="countdown">
				<tr>
					<td class="value days" data-bind="text: days"></td>
					<td class="value hours" data-bind="text: hours"></td>
					<td class="value minutes" data-bind="text: minutes"></td>
					<td class="value seconds" data-bind="text: seconds"></td>
				</tr>
				<tr>
					<td class="unit days" data-bind="text: daysText"></td>
					<td class="unit hours" data-bind="text: hoursText"></td>
					<td class="unit minutes" data-bind="text: minutesText"></td>
					<td class="unit seconds" data-bind="text: secondsText"></td>
				</tr>
			</table>
		@endif			
		</section>
		<p>{{ $mission->summary }}</p>
		<h2>Details</h2>
        <section class="details">
            <div id="live-tweets">

            </div>
        </section>
		<h2>Timeline</h2>
        <section class="timeline">
            <canvas></canvas>
        </section>
		<h2>Images</h2>
        <section class="images">

        </section>
		<h2>Videos</h2>
        <section class="videos">

        </section>
        @if (Auth::isSubscriber())
            <h2>Articles</h2>
            <section class="articles">

            </section>
        @endif
	</main>
</div>
@stop
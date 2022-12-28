{{-- @dd($data) --}}
@extends('layouts.front.app')

@section('content')

<!-- Banner Section -->
{{-- <section id="banner" class="banner-section">
	<div class="container">
		<div class="row banner-row bg-white pt-96 pb-96">
			<div class="col-12 text-center">
				<h1>Historical Records</h1>
			</div>
		</div>
	</div>
</section> --}}
<!-- Banner Section -->

<section id="handicapper" class="handicapper pt-120 pb-120">
	<div class="container">
		<div class="row mt-80">
			<div class="col-12 text-center">
				<h2>Historical Records</h2>
			</div>
		</div>
		<div class="row mt-40">
			<table class="top">
				<thead>
					<tr>
                        <th class="border-gray-200">Sports Bettor</th>
                        <th class="border-gray-200">Sport</th>
                        <th class="border-gray-200">League</th>
                        <th class="border-gray-200">Bet On</th>
                        <th class="border-gray-200">Market</th>
                        <th class="border-gray-200">Selection</th>
                        <th class="border-gray-200">Odds</th>
                        <th class="border-gray-200">Bet Result</th>
                        <th class="border-gray-200">Risk</th>
                        <th class="border-gray-200">Units</th>
                    </tr>
				</thead>
					<tbody>
						@forelse ($data as $item)
                            <tr>
                                <td><span class="fw-normal"><a href="{{ route('handicappers.profile', $item->user_id) }}">{{ $item->name }}</a></span></td>
                                <td><span class="fw-normal">{{ $item->sport }}</span></td>
                                <td><span class="fw-normal">{{ $item->league }}</span></td>
                                <td><span class="fw-normal">{{ $item->odd_name }}</span></td>
                                <td><span class="fw-normal">{{ $item->market_name }}</span></td>
                                <td><span class="fw-normal"> @if($item->wagered_team == 'home_team')  {{ $item->home_team }}  @else  {{ $item->away_team }} @endif </span></td>
                                <td><span class="fw-normal">{{ $item->odds > 0 ? '+' . $item->odds : $item->odds }}</span></td>
                                <td><span class="fw-normal"><button class="btn @if($item->status == 1) btn-warning @else @if($item->is_won == 1) btn-success @elseif($item->is_won == 0) btn-danger @elseif($item->is_won == 2) btn-warning @endif @endif" disabled>@if($item->status == 1) Pending @else @if($item->is_won == 1) Won @elseif($item->is_won == 0) Lost @elseif($item->is_won == 2) Refunded @endif @endif</button></span></td>
                                <td><span class="fw-normal">{{ $item->risk }}</span></td>
                                <td><span class="fw-normal">{{ $item->is_won == 1 ? '+' . $item->to_win : '-' . $item->to_win }}</span></td>
                            </tr>
                        @empty
                        <tr><td>No recent picks</td></tr>
                        @endforelse
                        {{-- <tr v-else v-for="item, index in data.data" v-bind:key="item.id">
                            <td>{{ index + 1 }}</td>
                            <td><a :href="/handicappers/ + item.id"><img :src="'images/profile/' + (item.image ?? 'default-avatar.jpg')" class="rounded-circle" width="80" height="80" style="object-fit: contain;" alt="Profile Image"></a></td>
                            <td><a :href="/handicappers/ + item.id">{{ item.name }}</a></td>
							<td>{{ item.wins ?? '-' }}</td>
							<td>{{ item.losses ?? '-' }}</td>
							<td style="text-align: center;" >{{ item.win_loss_percentage ? item.win_loss_percentage + '%' : '-' }}</td>
							<td>{{ item.units ?? '-' }}</td>
							<td>{{ item.roi ? item.roi + '%' : '-' }}</td>
                        </tr> --}}
				</tbody>
			</table>
		</div>
	</div>
</section>

@endsection
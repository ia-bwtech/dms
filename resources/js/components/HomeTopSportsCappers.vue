<template>
    <section id="top" class="top-section pt-120 pb-120">
	<div class="container">
		<!-- <div class="row">
			<form class="option-form" action="" method="">
				<div class="row justify-content-center">
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<label>Sports</label>
						<select id="league" class="league-option">
							<option v-for="league in leagues" :key="league.id" :value="league.id"><span v-html="league.icon"></span> {{ league.name }}</option>
						</select>
					</div>
					<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12">
						<label>Date Range</label>
						<select id="league" class="league-option">
							<option value="Current Season">1 day</option>
							<option value="Current Season">7 days</option>
							<option value="Current Season">14 days</option>
							<option value="Current Season">30 days</option>
							<option value="Current Season">Season</option>
							<option value="Current Season">All time</option>
						</select>
					</div>
				</div>
			</form>
		</div> -->
		<div class="row mt-80">
			<div  class="col-12 text-center">
				<h2>Top 5 {{ this.league }} Sports Bettors*</h2> <small>*Minimum 10 Units Won</small>
                <!-- <span ></span> -->
                <ul class="league-lists">
                    <li class="active" @click="setLeague(league)" :value="league.name" v-for="league in leagues" :key="league.id"><span v-html="league.icon"></span> {{ league.name }}</li>
                </ul>
			</div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 date-range-col ">
                <label>Date Range</label>
                <select @change="getData()" v-model="daterange" id="league" class="league-option">
                    <option value="7">7 days</option>
                    <option value="14">14 days</option>
                    <option value="30">30 days</option>
                    <option value="all">All time</option>
                </select>
            </div>
		</div>
		<div class="row mt-30">
			<table class="top">
				<thead>
					<tr>
						<th>Rank</th>
						<th>Icon</th>
						<th>Name</th>
						<th>Wins/Losses</th>
						<th>Win%</th>
						<th>Units</th>
						<th>ROI</th>
					</tr>
				</thead>
				<tbody>
                    <tr v-if="isloading">
                        <td colspan="8">
                            <content-placeholders :rounded="true">
                                <content-placeholders-heading :img="true" />
                                <content-placeholders-text :lines="3" />
                            </content-placeholders>
                        </td>
                    </tr>
                    <tr v-else-if="data.length == 0">
                        No data available
                    </tr>
                    <tr v-else v-for="item, index in data" v-bind:key="item.user_id">
                        <td>{{ index+1 }}</td>
                        <td><a :href="/handicappers/ + item.user_id"><img :src="'images/profile/' + (item.image ?? 'default-avatar.jpg')" class="rounded-circle" width="80" height="80" style="object-fit: contain;" alt="Profile Image"></a></td>
                        <td><a :href="/handicappers/ + item.user_id">{{ item.name }}</a></td>
                        <td>{{ item.wins + ' - ' + item.losses }}</td>
                        <td>{{ item.win_loss_percentage + '%' ?? '-' }}</td>
                        <td>{{ item.net_units + 'u' ?? '-' }}</td>
                        <td>{{ item.roi + '%' ?? '-' }}</td>
                    </tr>
                </tbody>
			</table>
		</div>
	</div>
</section>
</template>

<script>

	export default {
        data() {
            return {
                isloading: true,
                data: {},
                leagues: {},
                league: 'MLB',
                sport: '',
                daterange: 'all'
            }
        },

        created() {
            this.league = 'MLB';
            this.sport = 'baseball';
            this.getLeagues();
            this.getData();
        },

        methods: {
            getLeagues() {
                axios.get(`/api/leagues`)
                .then(res => {
                    this.leagues = res.data;
                })
            },
            
            getData() {
                this.isloading = true;
                axios.get(`/api/top-sports/${this.league}/${this.sport}/${this.daterange}`)
                .then(res => {
                    this.data = res.data;
                    this.isloading = false;
                })
            },

            setLeague(league) {
                if(league == 'allleagues') {
                    this.league = "allleagues";
                    this.sport = 'allsports';
                    this.getData();
                }
                else {
                    this.league = league.name;
                    this.sport = league.sport.name;
                    this.getData();
                }
            }
        },

		props: [
            'auth'
        ],
        
        mounted() {
            
        }
    }
</script>
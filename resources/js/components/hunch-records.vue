<template>
    <section id="record" class="record-section pb-120">
	<div class="container">
		<div class="recordhead row align-items-center">
			<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-xs-12">
				<div class="record-head-box">
					<img src="assets/images/header-logo.png" alt="Logo" class="img-fluid">
					<h2>Records</h2>
				</div>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-xs-12 d-flex justify-content-end">
				<div class="cat-select-box bets-selection">
					<select v-model="league" @change="getData()" id="cat" class="league-option">
                        <option value="allleagues">&#127941; All Leagues</option>
                        <option v-for="league in leagues" :value="league.name" :key="league.id"><span v-html="league.icon"></span> {{ league.name }}</option>
                    </select>
				</div>
			</div>	
		</div>
		<div class="row mt-30">
			<table class="recordtable">
				<thead>
					<tr>
						<th>Wins/Losses</th>
						<th>Win %</th>
						<th>Units</th>
						<th>ROI</th>
					</tr>
				</thead>
				<tbody>
                    <tr v-if="isloading">
                        <td colspan="5">
                            <content-placeholders :rounded="true">
                                <content-placeholders-heading :img="true" />
                                <content-placeholders-text :lines="3" />
                            </content-placeholders>
                        </td>
                    </tr>
                    <tr v-else>
                        <td>{{ data.api_wins + ' - ' + data.api_losses }}</td>
                        <td>{{ data.api_win_loss_percentage + '%' ?? '-' }}</td>
                        <td>{{ data.api_net_units + 'u' ?? '-' }}</td>
                        <td>{{ data.api_roi + '%' ?? '-' }}</td>
                    </tr>
                    <!-- <tr v-else v-for="item in data" v-bind:key="item.id">
                        <td>{{ item.league }}</td>
                        <td>{{ item.wins + ' - ' + item.losses }}</td>
                        <td>{{ item.win_loss_percentage + '%' ?? '-' }}</td>
                        <td>{{ item.net_units + 'u' ?? '-' }}</td>
                        <td>{{ item.roi + '%' ?? '-' }}</td>
                    </tr> -->
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
                league: 'allleagues',
                sport: '',
            }
        },

        created() {
            this.league = 'allleagues';
            this.sport = 'allsports';
            this.getLeagues();
            this.getData();
        },

        methods: {
            getData() {
                this.isloading = true;
                
                if(this.league != 'allleagues') {
                    if(this.leagues.length) {
                        for(let i=0; i< this.leagues.length; i++) {
                            if(this.leagues[i].name == this.league) {
                                this.sport = this.leagues[i].sport.name;
                            }
                        }
                    }
                }
                else {
                    this.sport = 'allsports';
                }
                
                axios.get(`/api/hunch/records/${this.league}/${this.sport}`)
                .then(res => {
                    this.data = res.data;
                    this.isloading = false;
                })
            },

            getLeagues() {
                axios.get(`/api/leagues`)
                .then(res => {
                    this.leagues = res.data;
                })
            },

            // setLeague(league) {
            //     console.log(league);
            //     this.league = league.name;
            //     this.sport = league.sport.name;
            //     this.getData();
            // },
        },

		props: [
            'auth'
        ],
        
        mounted() {
            
        }
    }
</script>
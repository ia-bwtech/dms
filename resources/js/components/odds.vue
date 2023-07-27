<template>
  <div>
    <section
      id="banner"
      class="banner-section banner-row banner-row-handicapperprofile banner-row-my-rankig odds-vue"
    >
      <div class="container-fluid">
        <div class="row">
          <div class="col-3">
            <div class="pro-image">
              <img
                :src="'images/profile/' + (auth.image ?? 'default-avatar.jpg')"
                width="316px"
                height="328px"
                class="sportsbettor-left-img"
              />
            </div>
          </div>
          <div class="col-9">
            <div class="row align-items-center">
              <div class="name-pro">
                <h1>{{ auth.name ?? "-" }}</h1>
              </div>
              <table class="table bg-dark">
                <thead class="text-center text-white">
                  <th class="border-bottom-0">Total Bets</th>
                  <th class="border-bottom-0">Wins</th>
                  <th class="border-bottom-0">Losses</th>
                  <th class="border-bottom-0">Win %</th>
                  <th class="border-bottom-0">ROI</th>
                </thead>
                <tbody class="text-center text-white font-weight-bold">
                  <tr>
                    <td>{{ auth.verified_wins + auth.verified_losses }}</td>
                    <td>{{ auth.verified_wins ?? "-" }}</td>
                    <td>{{ auth.verified_losses ?? "-" }}</td>
                    <td>{{ auth.verified_win_loss_percentage ?? "-" }}</td>
                    <td>{{ auth.verified_roi ?? "-" }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row"></div>
      </div>
    </section>

    <div class="main-content">
      <div class="container-fluid">
        <div class="row">
          <section
            id="mybets"
            class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7"
          >
            <a href="#track-bets-col" id="btn-mobile-only"
              >Make Bets <br /><i class="fa-solid fa-arrow-down"></i
            ></a>
            <h2 class="mybets-title">
              <img src="/assets/images1/bet.png" class="mybet" /> My Bets
            </h2>
            <div class="mybets-warp">
              <div
                v-if="pendingBetsLoading"
                class="mybets-item mybets-placeholders"
              >
                <content-placeholders :rounded="true">
                  <content-placeholders-heading :img="true" />
                  <content-placeholders-text :lines="3" />
                </content-placeholders>
              </div>
              <div
                v-else-if="pendingBets.length == 0"
                class="mybets-item mybets-null"
              >
                <div class="">
                  <h3>No current Active Bets</h3>
                </div>
              </div>
              <div
                v-else
                v-for="pendingBet in pendingBets"
                :key="pendingBet.id"
                class="mybets-item mybets-block"
              >
                <div class="">
                  <h3>
                    {{ pendingBet.odd_name + " (" + pendingBet.odds + ")" }}
                  </h3>
                  <div class="linebw-warp">
                    <p>{{ pendingBet.market_name }}</p>
                    <span class="line"></span>
                    <span class="prime-color">{{ pendingBet.risk + "u" }}</span>
                  </div>
                  <div class="vs-warp">
                    {{ pendingBet.home_team }} <span class="vs-br">VS</span>
                    {{ pendingBet.away_team }}
                  </div>
                  <p class="prime-color">Pending</p>
                </div>
              </div>
            </div>
          </section>

          <section
            id="netunit"
            class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5"
          >
            <div class="row net-units-row">
              <div class="col-xl-6">
                <h2 class="netunit-title">Net Units</h2>
              </div>
              <div class="col-xl-6">
                <div id="verified-col" class="verified">
                  <!-- <p>VERIFIED</p> -->
                  <verified-component :auth="auth"></verified-component>
                  <!-- <label class="switch-new">
                    <input type="checkbox" />
                    <span class="slider-new round-new"></span>
                  </label> -->
                </div>
              </div>
            </div>
            <div class="netunit-warp">
              <div
                v-for="item in units"
                :key="item.id"
                @click="setStatsDetails(item, item.name)"
                data-bs-toggle="modal"
                data-bs-target="#statsmodal"
                class="netunit-item"
              >
                <h3>{{ item.name }}</h3>
                <h3 class="mb-1">
                  <span v-if="item.net_units > 0" class="success-color"
                    >{{ item.net_units }}u</span
                  ><span v-else class="danger-color"
                    >{{ item.net_units }}u</span
                  >
                </h3>
                <small>{{ item.wins + "-" + item.losses }}</small>
                <small class="prime-color"
                  >W/L%: {{ item.win_loss_percentage + "%" }}</small
                >
                <small class="prime-color">ROI%: {{ item.roi + "%" }}</small>
              </div>
            </div>
          </section>

          <section
            id="trackbets"
            class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-xs-7"
          >
            <div class="trackbets-head">
              <h2 class="trackbets-title">Track Your Bets</h2>
              <div class="track-bets trackbets-warp">
                <div class="trackbets-date">
                  <label>Date</label>
                  <select @change="getOdds(date)" v-model="date">
                    <option :value="moment().format('YYYY-MM-DD')">
                      {{ moment().format("dddd, MMMM Do") }}
                    </option>
                    <option :value="moment().add(1, 'd').format('YYYY-MM-DD')">
                      {{ moment().add(1, "d").format("dddd, MMMM Do") }}
                    </option>
                  </select>
                  <!-- <input type="date" v-model="date" @change="limitDate()"> -->
                </div>
                <div class="trackbets-cat">
                  <label>Leagues</label>
                  <select v-model="leagueFilter" @change="getOdds()">
                    <option
                      v-for="item in leagues"
                      :key="item.id"
                      :value="item.name"
                    >
                      <span v-html="item.icon"></span> {{ item.name }}
                    </option>
                  </select>
                </div>
              </div>
            </div>
            <div class="trackbets-tabs">
              <div class="box-menu">
                <ul class="">
                  <li class="active"><a href="#Game">Game</a></li>
                  <li>
                    <a href="#F5">
                      <span v-if="sport == 'baseball'">F5</span>
                      <span
                        v-else-if="
                          sport == 'soccer' ||
                          sport == 'basketball' ||
                          sport == 'football'
                        "
                        >1st H</span
                      >
                    </a>
                  </li>
                  <!-- <li v-show="hockeyShow">
					<a href="#F5">1P</a>
					</li> -->
                </ul>
              </div>
              <div class="tab-content">
                <div class="box" id="Game" style="display: block">
                  <div class="row m-0">
                    <span v-if="isloading">
                      <content-placeholders :rounded="true">
                        <content-placeholders-heading :img="true" />
                        <content-placeholders-text :lines="3" />
                      </content-placeholders>
                    </span>
                    <span v-else-if="noGames">
                      <p>
                        No games available. Please try a different date or
                        league.
                      </p>
                    </span>
                    <span v-else v-for="item in data" :key="item.id">
                      <div class="bet-detail">
                        <div class="bet-date">
                          <span v-if="item.is_live == 1" style="font-size: 12px"
                            >&#128994; </span
                          ><span
                            >{{
                              moment(item.start_date).format(
                                "hh:mm a YYYY-MM-DD"
                              )
                            }}
                            - Bet MGM</span
                          >
                        </div>
                        <div class="bet-description">
                          <div class="game-name">
                            <div class="team-name">
                              <img
                                :src="
                                  item.home_logo
                                    ? item.home_logo
                                    : 'images/teams/default-team.png'
                                "
                                alt="Team Logo"
                              />
                              <p :title="item.home_team">
                                {{ item.home_team }}
                              </p>
                            </div>
                          </div>
                          <!-- Home MoneyLine Odds -->
                          <div class="spread game-box position-relative">
                            <span v-if="item.is_live == false && item.odds.length" data-imran="hello" :data-odds-length="item.odds.length">
                              <!-- <label for="">{{ item.odds.length }}</label> -->
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span v-if="odd.market_name == 'Moneyline' && odd.name.includes(item.home_team)">
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span v-else-if="item.is_live == true && item.odds.length">
                              <!-- <label for="">{{ item.odds.length }}</label> -->
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Moneyline' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- Home Point Spread OR Asian Handicap OR Run Line Odds OR Puck Line -->
                          <div class="total game-box">
                            <!-- testblock -->
                            <!-- <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Run Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Asian Handicap' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Point Spread' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Puck Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span> -->
                            <!-- /.testblock -->

                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Run Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Asian Handicap' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Point Spread' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Puck Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Run Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Asian Handicap' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Point Spread' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Puck Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- Home Total Points or Total Goals or Total Runs Odds -->
                          <div class="mi game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Total Runs' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Points' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Goals' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Total Runs' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Points' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Goals' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                        </div>
                        <div class="bet-description mt-3">
                          <div class="game-name">
                            <div class="team-name">
                              <img
                                :src="
                                  item.away_logo
                                    ? item.away_logo
                                    : 'images/teams/default-team.png'
                                "
                                alt="Team Logo"
                              />
                              <p>{{ item.away_team }}</p>
                            </div>
                          </div>
                          <!-- Away MoneyLine Odds -->
                          <div class="spread game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <p v-for="odd in item.odds" :key="odd.id">
                                <!-- <span v-if="item.sport == 'hockey'">
									<span v-if="odd.market_name == 'Moneyline 3-Way' && odd.name.includes(item.away_team)">
									<button @click="setBetDetails(item.home_team, item.away_team, 'away_team', odd.price, odd.market_name, odd.name, item.game_id, item.sport, item.league, odd.id), calculateToWin()" type="button" data-bs-toggle="modal" data-bs-target="#datamodal">{{ odd.price > 0 ? '+' + odd.price.toString() : odd.price }} <p><small>M 3-Way</small></p></button>
									</span>
								</span> -->
                                <span
                                  v-if="
                                    odd.market_name == 'Moneyline' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <!-- <button @click="showError()" type="button">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button> -->
                              <p v-for="odd in item.odds" :key="odd.id">
                                <!-- <span v-if="item.sport == 'hockey'">
									<span v-if="odd.market_name == 'Moneyline 3-Way' && odd.name.includes(item.away_team)">
									<button @click="showError()" type="button">{{ odd.price > 0 ? '+' + odd.price.toString() : odd.price }} <p><small>M 3-Way</small></p></button>
									</span>
								</span> -->
                                <span
                                  v-if="
                                    odd.market_name == 'Moneyline' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- Away Point Spread OR Asian Handicap OR Run Line Odds OR Puck Line -->
                          <div class="total game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Run Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Asian Handicap' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Point Spread' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Puck Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Run Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Asian Handicap' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Point Spread' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Puck Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- Away Total Points or Total Goals or Total Runs Odds -->
                          <div class="mi game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Total Runs' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Points' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Goals' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == 'Total Runs' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Points' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == 'Total Goals' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                        </div>
                      </div>
                    </span>
                  </div>
                </div>
                <!-- F5 -->
                <div class="box" id="F5" style="display: none">
                  <div class="row m-0">
                    <span v-if="isloading">
                      <content-placeholders :rounded="true">
                        <content-placeholders-heading :img="true" />
                        <content-placeholders-text :lines="3" />
                      </content-placeholders>
                    </span>
                    <span
                      v-else
                      v-for="item in data"
                      :key="item.id"
                      class="bet-warpitem"
                    >
                      <div class="bet-detail">
                        <div class="bet-date">
                          <p>
                            {{
                              moment(item.start_date).format(
                                "hh:mm a YYYY-MM-DD"
                              )
                            }}
                            - Bet MGM
                          </p>
                        </div>
                        <div class="bet-description">
                          <div class="game-name">
                            <div class="team-name">
                              <img
                                :src="
                                  item.home_logo
                                    ? item.home_logo
                                    : 'images/teams/default-team.png'
                                "
                                alt="Team Logo"
                              />
                              <p>{{ item.home_team }}</p>
                            </div>
                          </div>
                          <!-- F5 Home MoneyLine Odds -->
                          <div class="spread game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Moneyline' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <!-- <span v-if="item.odds.length">
								<p v-for="odd in item.odds" :key="odd.id"><span v-if="odd.market_name == 'Moneyline' && odd.name.includes(item.home_team)">{{ odd.price > 0 ? '+' + odd.price.toString() : odd.price }}</span></p>
							</span> -->
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <!-- <button @click="showError()" type="button">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button> -->
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Moneyline' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                            <!-- <p>{{ item.home_money_line ? item.home_money_line : 'N/A' }}</p> -->
                            <!-- <button type="button" data-toggle="modal" data-target="#datamodal" class="btn btn-outline-primary">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button> -->
                            <!-- <span v-if="item.is_live == false">
								<span v-if="item.home_money_line != undefined">
								<button @click="setBetDetails(item.teams.home.name, item.teams.away.name, item.teams.home.name, item.teams.home.id, item.game_id, item.home_money_line, item.odds[0].bookmakers[0].bets[0].id), calculateToWin()" type="button" data-bs-toggle="modal" data-bs-target="#datamodal">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button>
								</span>
								<span v-else>
								N/A
								</span>
							</span>
							<span v-else> <button @click="showError()" type="button">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button> </span> -->
                          </div>
                          <!-- F5 Home Spread Odds -->
                          <div class="total game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Run Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Asian Handicap' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Point Spread' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Run Line' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Asian Handicap' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Point Spread' &&
                                    odd.name.includes(item.home_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- F5 Home Total Odds -->
                          <div class="mi game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Total Runs' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Total Points' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == '1st Half Total Goals' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'home_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Total Runs' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Total Points' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == '1st Half Total Goals' &&
                                    odd.name.includes('Over')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                        </div>
                        <div class="bet-description mt-3">
                          <div class="game-name">
                            <div class="team-name">
                              <img
                                :src="
                                  item.away_logo
                                    ? item.away_logo
                                    : 'images/teams/default-team.png'
                                "
                                alt="Team Logo"
                              />
                              <p>{{ item.away_team }}</p>
                            </div>
                          </div>
                          <!-- F5 Away MoneyLine Odds -->
                          <div class="spread game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Moneyline' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <!-- <button @click="showError()" type="button">{{ item.home_money_line ? item.home_money_line : 'N/A' }}</button> -->
                              <p v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Moneyline' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}
                                  </button>
                                </span>
                              </p>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- F5 Away Spread Odds -->
                          <div class="total game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Run Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Asian Handicap' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Point Spread' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Run Line' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Asian Handicap' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Point Spread' &&
                                    odd.name.includes(item.away_team)
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.bet_points > 0
                                        ? "+" + odd.bet_points.toString()
                                        : odd.bet_points
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                          <!-- F5 Away Total Odds -->
                          <div class="mi game-box">
                            <span
                              v-if="item.is_live == false && item.odds.length"
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Total Runs' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Total Points' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == '1st Half Total Goals' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button
                                    @click="
                                      setBetDetails(
                                        item.home_team,
                                        item.away_team,
                                        'away_team',
                                        odd.price,
                                        odd.market_name,
                                        odd.name,
                                        item.game_id,
                                        item.sport,
                                        item.league,
                                        odd.id
                                      ),
                                        calculateToWin()
                                    "
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#datamodal"
                                  >
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span
                              v-else-if="
                                item.is_live == true && item.odds.length
                              "
                            >
                              <span v-for="odd in item.odds" :key="odd.id">
                                <span
                                  v-if="
                                    odd.market_name == '1st Half Total Runs' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name ==
                                      '1st Half Total Points' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                                <span
                                  v-else-if="
                                    odd.market_name == '1st Half Total Goals' &&
                                    odd.name.includes('Under')
                                  "
                                >
                                  <button @click="showError()" type="button">
                                    {{
                                      odd.name > 0
                                        ? "+" + odd.name.toString()
                                        : odd.name
                                    }}<br />
                                    <small>{{
                                      odd.price > 0
                                        ? "+" + odd.price.toString()
                                        : odd.price
                                    }}</small>
                                  </button>
                                </span>
                              </span>
                            </span>
                            <span v-else>
                              <p>N/A</p>
                            </span>
                          </div>
                        </div>
                      </div>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <section
            id="netunileague"
            class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5"
          >
            <h2 class="net-units-by-league">Net Units by League</h2>
            <div class="netunileague-warp">
              <div
                v-for="item in sports_units"
                :key="item.id"
                @click="setStatsDetails(item, item.league)"
                data-bs-toggle="modal"
                data-bs-target="#statsmodal"
                class="netunileague-item"
              >
                <span
                  class="league-icon"
                  v-html="item.league_icon"
                  style="font-size: 50px"
                ></span>
                <div class="league-icon-desc">
                  <h5>{{ item.league }}</h5>
                  <h3
                    :class="
                      item.net_units > 0 ? 'success-color' : 'danger-color'
                    "
                  >
                    {{ item.net_units }}u
                  </h3>
                  <small class="gray-text">{{
                    item.wins + "-" + item.losses
                  }}</small>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

    <!-- Data Modal -->
    <div
      class="modal fade bd-example-modal-lg"
      id="datamodal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-lg modal-dialog-scrollable"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
              Bet Slip
            </h5>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              ×
            </button>
          </div>
          <form @submit.prevent="placeBet()" enctype="multipart/form-data">
            <div class="modal-body">
              <p>{{ odd_name }}</p>
              <br />
              <div class="row">
                <div class="form-group col-md-4">
                  <label for="">Odds</label>
                  <input
                    v-model="odds"
                    style="background-color: #e5e5e5"
                    type="number"
                    readonly
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="">Risk</label>
                  <input
                    @change="calculateToWin()"
                    v-model="risk"
                    style="background-color: #e5e5e5"
                    type="number"
                    min="1"
                    max="5"
                  />
                </div>
                <div class="form-group col-md-4">
                  <label for="">To Win</label>
                  <input
                    v-model="to_win"
                    style="background-color: #e5e5e5"
                    type="text"
                    readonly
                  />
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close</button
              ><button
                :disabled="disableButton"
                class="btn btn-success btn-lg"
                type="submit"
              >
                Track Bet
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Stats Modal -->
    <div
      class="modal fade bd-example-modal-lg"
      id="statsmodal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalScrollableTitle"
      aria-hidden="true"
    >
      <div
        class="modal-dialog modal-lg modal-dialog-scrollable"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalScrollableTitle">
              {{ stats_modal.name }} Stats
            </h5>
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              ×
            </button>
          </div>
          <form @submit.prevent="placeBet()" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="custom-1k22v0u e17ni7210">
                <div class="custom-yyq9fm ez1k6ur0">
                  <span>{{ stats_modal.net_units }}u</span
                  ><svg
                    viewBox="0 0 24 24"
                    width="15"
                    height="15"
                    xmlns="http://www.w3.org/2000/svg"
                    class="net-units-module__arrow custom-inrq evhdyr10"
                    fill="#b82132"
                    stroke="#b82132"
                    stroke-width="0"
                  >
                    <title>Right Arrow</title>
                    <path
                      d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z"
                    ></path>
                  </svg>
                </div>
                <div class="net-unit-performance__details">
                  <div class="net-unit-performance__roi">
                    ROI <span>{{ stats_modal.roi }}%</span>
                  </div>
                  <div class="net-unit-performance__record">
                    Record
                    <span>{{
                      stats_modal.wins + " - " + stats_modal.losses
                    }}</span>
                  </div>
                  <div class="net-unit-performance__wins">
                    Wins <span>{{ stats_modal.win_loss_percentage }}%</span>
                  </div>
                </div>
              </div>
              <div class="custom-1ajbsre e1fgk38m0">
                <div
                  v-for="bet in stats_modal.bets"
                  :key="bet.id"
                  class="pick-list__bet-cell custom-f3mmnx e15xu35g0"
                >
                  <div class="custom-1lle6oa e1j6txfk1">
                    <div class="base-pick__pick">
                      <div class="base-pick__info">
                        <div class="base-pick__pick-name">
                          <span class="base-pick__name">{{
                            bet.odd_name
                          }}</span>
                          <span class="base-pick__secondary-text">{{
                            bet.odds
                          }}</span>
                        </div>
                        <div class="base-pick__details">
                          <div class="custom-1aid2sb edrhi880">
                            <div>
                              {{ bet.home_team + " vs " + bet.away_team }}
                            </div>
                            <!-- <img class="game-pick-details__team-icon" width="14" alt="BUF Team Abbreviation" src="https://static.sprtactn.co/teamlogos/nfl/100/buf.png"> -->
                            <!-- <span> 'vs </span> -->
                            <!-- <img class="game-pick-details__team-icon" width="14" alt="LAR Team Abbreviation" src="https://static.sprtactn.co/teamlogos/nfl/100/la.png"> -->
                            <!-- <div> {{ bet.away_team }}</div> -->
                          </div>
                        </div>
                        <div>
                          <div class="base-pick__units">{{ bet.to_win }}u</div>
                          <div class="base-pick__status">5:20 AM</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-secondary"
                data-bs-dismiss="modal"
              >
                Close
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
// import { threadId } from 'worker_threads';
export default {
  data() {
    return {
      date: moment().format("YYYY-MM-DD"),
      data: {},
      isloading: true,
      noGames: false,
      risk: "1",
      odds: "",
      to_win: "",
      team_id: "",
      game_id: "",
      home_team: "",
      away_team: "",
      wagered_team: "",
      bet_id: "",
      stats: {},
      time: moment().format("YYYY-MM-DD"),
      market_name: "",
      odd_name: "",
      sport: "",
      league: "",
      opposite_spread_calculation: "",
      leagues: {},
      // leagueFilter: {
      //  leagueName: 'mlb',
      //  sportName: 'baseball'
      // },
      // leagueFilter: {
      //  created_at: '',
      //  icon: '',
      //  id: '',
      //  name: 'MLB',
      //  sport: {},
      //  sport_id: '',
      //  updated_at: '',
      // },
      leagueFilter: "",
      sportFilter: "",
      ok: true,
      baseballActive: true,
      // soccerBasketballActive: false,
      hockeyActive: false,
      gameShow: true,
      f5Show: false,
      hockeyShow: false,
      disableButton: false,
      units: {},
      sports_units: [],
      stats_modal: {
        name: "",
        net_units: "",
        wins: "",
        losses: "",
        win_loss_percentage: "",
        roi: "",
        bets: [],
      },
      pendingBets: {},
      pendingBetsLoading: true,
    };
  },
  created() {
    this.moment = moment;
    // this.moment = moment.tz.setDefault('America/New_York');
    // this.getCurrentDate();
    if (this.league_prop == "NCAA" && this.sport_prop == "football") {
      this.leagueFilter = "NCAAF";
      this.sportFilter = "football";
    } else if (this.league_prop == "NCAA" && this.sport_prop == "basketball") {
      this.leagueFilter = "NCAAB";
      this.sportFilter = "basketball";
    } else {
      this.leagueFilter = this.league_prop;
      this.sportFilter = this.sport_prop;
    }
    this.getData();
    this.getPendingBets();
    this.getOdds(this.date);
  },
  methods: {
    // log(item) {
    //  console.log(item)
    // },
    toggleDisplay(show) {
      if (this.gameShow == show) {
        this.gameShow = true;
        this.f5Show = false;
      } else if (this.f5Show == show) {
        this.gameShow = false;
        this.f5Show = true;
      }
    },
    test() {
      console.log(this.time + " 00:00");
      console.log("time now: " + moment().format("MMMM Do YYYY, h:mm:ss a"));
    },
    limitDate() {
      if (moment().subtract(1, "d").isAfter(this.date)) {
        alert("Odds are only available for today or tomorrow");
        var date = new Date().toLocaleDateString("en-US", {
          year: "numeric",
          month: "2-digit",
          day: "2-digit",
        });
        this.date = moment(date).format("YYYY-MM-DD");
        return;
      }
      if (moment().add(1, "d").isBefore(this.date)) {
        alert("Odds are only available for today or tomorrow");
        var date = new Date().toLocaleDateString("en-US", {
          year: "numeric",
          month: "2-digit",
          day: "2-digit",
        });
        this.date = moment(date).format("YYYY-MM-DD");
        return;
      }
      this.getOdds(this.date);
      // console.log('yesterday: ' + moment().subtract(1, 'd').format('YYYY-MM-DD'));
      // var previousDay = console.log('previous day: ' + moment(this.date).subtract(1, 'd').format('YYYY-MM-DD'));
      // var nextDay = console.log('next day: ' + moment(this.date).add(1, 'd').format('YYYY-MM-DD'));
    },
    // getCurrentDate() {
    //     var date = new Date().toLocaleDateString('en-US', {year: 'numeric', month: '2-digit', day: '2-digit'});
    //     this.date = moment(date).format('YYYY-MM-DD');
    //     console.log(this.date);
    // },
    getPendingBets() {
      this.pendingBetsLoading = true;
      axios
        .get(`/api/pending-bets?user_id=${this.auth.id}`)
        .then((res) => {
          this.pendingBets = res.data;
          this.pendingBetsLoading = false;
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
    },
    getOdds(date) {
      this.isloading = true;
      if (this.leagues.length) {
        for (let i = 0; i < this.leagues.length; i++) {
          if (this.leagues[i].name == this.leagueFilter) {
            this.sportFilter = this.leagues[i].sport.name;
          }
        }
      }
      axios
        .get(
          "/api/odds/local?date=" +
            this.date +
            "&league=" +
            this.leagueFilter +
            "&sport=" +
            this.sportFilter
        )
        .then((res) => {
          this.data = res.data.games;
           //console.log(this.data);
          // console.log(res.data.total_games);
          if (res.data.total_games == 0) {
            this.noGames = true;
            this.isloading = false;
            return;
          } else {
            this.noGames = false;
            this.sport = this.data[0].sport;
            this.league = this.data[0].league;
          }
          // if(this.data.length > 0) {
          //  this.sport = this.data[0].sport;
          //  this.league = this.data[0].league;
          // }
          this.isloading = false;
        })
        .catch((err) => {
          alert(err);
          console.log(err);
        });
    },
    getData() {
      axios
        .get(`/api/leagues`)
        .then((res) => {
          this.leagues = res.data;
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
      axios
        .get(`/api/stats/${this.auth.id}`)
        .then((res) => {
          this.stats = res.data.stats;
          // console.log('my stats: ' + this.stats);
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
      axios
        .get(`/api/net-units/${this.auth.id}`)
        .then((res) => {
          this.units = res.data;
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
      axios
        .get(`/api/net-units-sports/${this.auth.id}`)
        .then((res) => {
          this.sports_units = res.data;
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
    },
    setBetDetails(
      homeTeam,
      awayTeam,
      wageredTeam,
      odds,
      market_name,
      odd_name,
      game_id,
      sport,
      league,
      bet_id
    ) {
      this.home_team = homeTeam;
      this.away_team = awayTeam;
      this.wagered_team = wageredTeam;
      // this.team_id = wageredTeamId;
      this.game_id = game_id;
      this.odds = odds;
      this.bet_id = bet_id;
      this.market_name = market_name;
      this.odd_name = odd_name;
      this.sport = sport;
      this.league = league;
      // if(this.market_name == 'Run Line' || this.market_name == '1st Half Run Line') {
      //  if(this.odd_name.includes('+')) {
      //  }
      // }
      console.log("setting bet details");
    },
    calculateToWin() {
      console.log("calculating to win");
      if (this.risk < 0) {
        this.odds;
      }
      if (this.odds > 0) {
        if (this.risk < 0) {
          this.to_win = (this.odds / 100) * 1;
        } else {
          this.to_win = (this.odds / 100) * this.risk;
        }
      } else if (this.odds < 0) {
        if (this.risk < 0) {
          this.to_win = (-100 / this.odds) * 1;
        } else {
          this.to_win = parseFloat((-100 / this.odds) * this.risk).toFixed(2);
        }
      }
    },
    placeBet() {
      this.disableButton = true;
      let formData = new FormData();
      formData.append("risk", this.risk);
      formData.append("odds", this.odds);
      formData.append("to_win", this.to_win);
      formData.append("home_team", this.home_team);
      formData.append("away_team", this.away_team);
      formData.append("wagered_team", this.wagered_team);
      // formData.append('team_id', this.team_id);
      formData.append("user_id", this.auth.id);
      formData.append("game_id", this.game_id);
      formData.append("bet_id", this.bet_id);
      formData.append("market_name", this.market_name);
      formData.append("odd_name", this.odd_name);
      formData.append("sport", this.sport);
      formData.append("league", this.league);
      axios
        .post("/api/bet", formData, {
          headers: {
            "content-type": "multipart/form-data",
          },
        })
        .then((data) => {
          if (data.data.status == true) {
            Swal.fire("Success!", "Bet placed successfully!", "success");
            this.disableButton = false;
            window.location.href =
              "/my-ranking?league=" + this.league + "&sport=" + this.sport;
          } else if (data.data.status == false) {
            Swal.fire({
              icon: "error",
              title: "Error!",
              text: data.data.message,
            });
            this.disableButton = false;
          }
        })
        .catch((error) => {
          alert(error.response.data.message);
          this.disableButton = false;
        });
    },
    setStatsDetails(item, name) {
      this.stats_modal.name = name;
      this.stats_modal.net_units = item.net_units;
      this.stats_modal.wins = item.wins;
      this.stats_modal.losses = item.losses;
      this.stats_modal.win_loss_percentage = item.win_loss_percentage;
      this.stats_modal.roi = item.roi;
      this.stats_modal.bets = item.bets;
    },
    showError() {
      Swal.fire("Warning!", "This bet is currently not available", "danger");
    },
  },
  props: ["auth", "league_prop", "sport_prop"],
  mounted() {
    // console.log(this.auth.id);
  },
};
</script>

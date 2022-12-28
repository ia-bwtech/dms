<template>
  <section id="handicapper" class="handicapper pt-30 pb-120">
    <div class="container">
      <div class="row mt-80">
        <div class="col-12 text-center">
          <h2>
            Top
            <span v-if="this.league != 'allleagues'">{{ this.league }}</span>
            Sports Bettors
          </h2>
        </div>
        <ul class="league-lists pb-4">
          <li
            class="active"
            @click="setLeague('allleagues')"
            value="allleagues"
          >
            &#127941; <br />
            All Leagues
          </li>
          <li
            class="active"
            @click="setLeague(league)"
            :value="league.name"
            v-for="league in leagues"
            :key="league.id"
          >
            <span v-html="league.icon"></span> {{ league.name }}
          </li>
        </ul>
        <input
          type="text"
          class="form-control w-25"
          v-model="query"
          placeholder="Search Bettors"
          v-on:keyup="searchAfterDebounce"
        />
        <div
          class="col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 date-range-col"
        >
          <label>Date Range</label>
          <select
            @change="getData()"
            v-model="daterange"
            id="league"
            class="league-option"
          >
            <option value="7">7 days</option>
            <option value="14">14 days</option>
            <option value="30">30 days</option>
            <option value="all">All time</option>
          </select>
        </div>
      </div>
      <div class="row mt-40">
        <table class="top">
          <thead>
            <tr>
              <th>Rank</th>
              <th>Icon</th>
              <th>Name</th>
              <th>Wins</th>
              <th>Losses</th>
              <th>Win/Loss Percentage</th>
              <th @click="getBySorted('net_units')">Units <i class="fas fa-sort"></i></th>
              <th @click="getBySorted('roi')">ROI <i class="fas fa-sort"></i></th>
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
            <tr v-else v-for="(item, index) in data.data" v-bind:key="item.id">
              <td v-if="currentPage==1">{{ index + 1 }}</td>
              <td v-else-if="currentPage!=1">{{currentPage}}{{ index + 1 }}</td>

              <td>
                <a :href="/handicappers/ + item.user_id"
                  ><img
                    :src="
                      'images/profile/' + (item.image ?? 'default-avatar.jpg')
                    "
                    class="rounded-circle"
                    width="80"
                    height="80"
                    style="object-fit: contain"
                    alt="Profile Image"
                /></a>
              </td>
              <td>
                <a :href="/handicappers/ + item.user_id">{{ item.name }}</a>
              </td>
              <td>{{ item.wins ?? "-" }}</td>
              <td>{{ item.losses ?? "-" }}</td>
              <td style="text-align: center">
                {{ item.win_loss_percentage + "%" }}
              </td>
              <td>{{ item.net_units ?? "-" }}</td>
              <td>{{ item.roi + "%" }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="leaderboard-pagination">
        <pagination
          :limit="50"
          :data="data"
          @pagination-change-page="getData"
        ></pagination>
      </div>
    </div>
  </section>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";

export default {
  data() {
    return {
      isloading: true,
      data: {},
      pagination: {},
      query: "",
      currentPage: "",
      checked: true,
      leagues: {},
      league: "MLB",
      sport: "",
      daterange: "all",
    };
  },

  components: {
    Pagination: LaravelVuePagination,
  },

  created() {
    this.league = "allleagues";
    this.sport = "allsports";
    this.getLeagues();
    this.getData();
  },

  methods: {
    check($event) {
      console.log($event.target.checked);
    },
    getBySorted(sortBy, page = 1) {
      this.currentPage = page;
      this.isloading = true;
      axios
        .get(
          `/api/leaderboard/${this.league}/${this.sport}/${this.daterange}/${sortBy}?page=${page}`
        )
        .then((res) => {
          this.isloading = false;
          this.data = res.data;
        });
    },

    getData(page = 1) {
      this.currentPage = page;
      this.isloading = true;
      axios
        .get(
          `/api/leaderboard/${this.league}/${this.sport}/${this.daterange}?page=${page}`
        )
        .then((res) => {
          this.isloading = false;
          this.data = res.data;
        });
    },

    getLeagues() {
      axios.get(`/api/leagues`).then((res) => {
        this.leagues = res.data;
      });
    },

    //asyncdata
    searchAfterDebounce: _.debounce(
      function () {
        this.isloading = true;
        this.search();
      },
      500 // 500 milliseconds
    ),

    //search data
    search() {
      if (this.query.length > 1) {
        axios
          .get(
            `/api/leaderboard/search?search=${this.query}&league=${this.league}&sport=${this.sport}&date=${this.daterange}`
          )
          .then((res) => {
            this.isloading = false;
            this.data = res;
          });
      } else {
        this.isloading = false;
        this.getData();
      }
    },

    setLeague(league) {
      if (league == "allleagues") {
        this.league = "allleagues";
        this.sport = "allsports";
        this.getData();
      } else {
        this.league = league.name;
        this.sport = league.sport.name;
        this.getData();
      }
    },
  },

  props: [],

  mounted() {},
};
</script>

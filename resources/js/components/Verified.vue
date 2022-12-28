<template>
    <div>
        <div class="form-check form-switch">
            <input :disabled="checkDisabled" v-model="checked" @change="changeVerifiedStatus($event)" class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
            <label class="form-check-label" for="flexSwitchCheckChecked">{{ checked == true ? 'Verified' : 'Unverified' }}</label>
            <div class="tooltip text-white">Hover over me
                <span class="tooltiptext">Tooltip text</span>
            </div>
        </div>
    </div>
</template>

<script>

	export default {
        data() {
            return {
                checkedStatus: '',
                checked: false,
                checkDisabled: false,
            }
        },

        created() {
            this.getData();
        },

        methods: {
            changeVerifiedStatus(event) {
                
                this.checkDisabled = true;
                if(event.target.checked == true) {
                    var verifiedStatus = 1;
                }
                else if(event.target.checked == false) {
                    var verifiedStatus = 0;
                }
                
                let formData = new FormData();
				formData.append('id', this.auth.id);
                formData.append('status', verifiedStatus);
                
                axios.post('/api/verified/status',
					formData, {
						headers: {
							'content-type': 'multipart/form-data'
						}
					}
				)
                .then(res => {
                    location.reload();
                }

                )
            },

            getData() {
                axios.get(`/api/stats/${this.auth.id}`)
                .then(res => {
                    this.checkedStatus = res.data.stats.is_verified;
                    if(this.checkedStatus == 1) {
                        this.checked = true;
                    }
                    else {
                        this.checked = false;
                    }
                })
            }
        },

		props: [
            'auth'
        ],
        
        mounted() {
            
        }
    }
</script>
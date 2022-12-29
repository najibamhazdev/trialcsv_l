<template>
    <div class="container">
        <div class="row jutify-content-center">
            <div class="col-md-8">
                <div v-if="error !== null" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                    
                </div>
                <div class="col-md-12">
                    <h3>Agent Information </h3>
                </div>
                
                <div class="col-md-4 profile-picture" >
                    <div id="photo" ><img :src="contact['mug']" class="contact-img" style="max-width: 250px; height: auto;" /></div>
                </div>
                <div class="col-md-8 profile-details">
                    <div class="col-md-12">
                        <h3 class="contact-name">{{ contact['first_name'] }} {{ contact['last_name'] }}</h3>
                    </div>
                    <div class="col-md-12">
                        <label class="col-md-1" for="phone"><strong>Phone: </strong> </label><a href="tel:{{ contact['phone'] }}" >{{ contact['phone'] }}</a>
                    </div>
                    <div class="col-md-12">
                        <label class="col-md-1" for="phone"><strong>Email: </strong></label> <a href="mail:{{ contact['email'] }}" >{{ contact['email'] }}</a>
                    </div>
                    <div class="col-md-12">
                        <label class="col-md-1" for="Role"><strong>Roles:</strong></label>               <ul>
                            <li v-for="role in lastroles" :key="role">{{ role }}</li>
                        </ul> 
                    </div>
                </div>

                <div class="button">
                    <button @click="exportvcf" color="primary">Save Contact</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                contact:"",
                lastroles:"",
                error: null
            }
        },
        mounted(){
            axios
                .get(`/contact/${this.$route.params.name}`)
                
                .then(response => {
                    this.contact = response.data;
                    this.lastroles = this.contact['roles'].slice(0, 3);
                })
                .catch(function(error) {
                            console.log(error);
                    });
        },
        computed: {
            roleLimited() {
                return contact['roles'].slice(0, 3)
            }
        },

        methods: {
            exportvcf(){
                axios
                .get(`/contact/${this.$route.params.name}/exportvcf`).then(response=>{
                    console.log('resL ',response.data)
                    var FILE = window.URL.createObjectURL(new Blob([response.data]));
                     console.log(FILE);
                     var docUrl = document.createElement('a');
                     docUrl.href = FILE;
                     docUrl.setAttribute('download', this.contact.first_name+'_'+this.contact.last_name+'.vcf');
                     document.body.appendChild(docUrl);
                     docUrl.click();
                })
                .catch(function(error) {
                            console.log(error);
                    });    
            }
        },

        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                return next('dashboard');
            }
            next();
        }
    }
</script>
<style>
.profile-picture, .profile-details{
    float: left;
}
</style>

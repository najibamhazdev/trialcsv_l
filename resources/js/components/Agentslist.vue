<template>

<div class="table-responsive">
        <table class="table table-striped table-hover  ">
            <thead >
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Full Name</th> 
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Roles</th>
                </tr>
            </thead>
            <tbody >
            <tr v-for="(contact,index) in contacts" :key="contact.id">
                <td>{{ index+1 }}</td>
                <td>
                    <img :src="contact.mug" class="card-img agent-img" v-if="contact.mug!=null"  />
                    <img v-bind:src="'/img/' + photo.profile" class="card-img agent-img" v-else /> 
                </td>
                <td><router-link :to="{ name: 'contactdetails', params: { name: contact.first_name }}">{{ contact.first_name }} {{ contact.last_name }}</router-link></td>
                <td>{{ contact.email }}</td>
                <td>{{ contact.phone }}</td>
                <td v-if="contact.roles"><span v-for="role in contact.roles.slice(0, 3)">{{ role }}, </span></td>
            </tr>
            </tbody>
        </table>

    </div>

</template>
<script>
    export default {
        name: "Agentslist",
        
        data() {
            return {
                contacts:null,
                contact:null,
                name:null,
                params:null,
                photo: {
                        profile: 'profile.jpg'
                    }
            }
        },
        methods:{

            checkavailability(url){
                
            }
        },
        mounted(){
            axios
                .get('/contacts')
                .then(response => (this.contacts = response.data))
                .catch(function(error) {
                        console.log(error);
                });

                
        }
    }
</script>
<style>
    .agent-img{
        width: 120px;
        height: auto;
    }
</style>
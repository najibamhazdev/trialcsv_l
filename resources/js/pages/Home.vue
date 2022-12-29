<template>
    <div class="row">
        <h1>List of Agents</h1> 
    </div>
    
    <Agentslist></Agentslist>
    
</template>

<script>
import Agentslist from  '../components/Agentslist';

export default {
    
    name: "Home",
    components:{
        Agentslist,
    },
    data() {
        return {
            contacts:null,
            contact:null,
            name:null,
            params:null
        }
    }
    
    }
</script>
<style>
table{
    width: 100%;
}
</style>
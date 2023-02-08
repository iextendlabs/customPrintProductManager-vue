<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-12">
                        <div class="pt-5 pr-5 pl-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">View Order</h1>
                            </div>
                            <button type="button" @click="download(invoice)" class="btn btn-warning">Download Invoice</button>
                            <button type="button" @click="updateOrder(id,0)" class="btn btn-primary">Mark as Padding</button>
                            <button type="button" @click="updateOrder(id,1)" class="btn btn-success">Mark as Delivered</button>
                            <button type="button" @click="back()" class="btn btn-info">Back</button><br><br>
                            <!-- <img :src="image" alt="image" height="auto" width="100%"> -->
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-8 px-5">
                        <div class="card">
                        <img id="pic" :src="image" alt="image" height="auto" width="100%"/>   
                        <div class="zoomIn zoom" @click="zoomIn">+</div>
                        <div class="zoomOut zoom" @click="zoomOut">−</div>                
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>   
</template>
<script>
export default {
    data(){
        return{
            note:'',
            image:'',
            id:'',
            invoice:'',
            api:'http://127.0.0.1:8000/api/order',
        }
    },
    mounted(){
        this.showOrder()
    },
    methods:{
        async showOrder(){
            await this.axios.get(this.api+'/'+this.$route.params.id).then(response=>{
                this.id = response.data.id
                this.invoice = response.data.invoice
                this.note = response.data.note
                this.image = '/orderimage/'+response.data.image
            }).catch(error=>{
                console.log(error)
            })
        },

        async updateOrder(id,status){
             let formData = new FormData();
             formData.append('status', status);
             formData.append('_method', 'PUT')
            await this.axios.post(this.api+'/'+this.$route.params.id, formData).then(response=>{
                this.showOrder()
            }).catch(error=>{
                console.log(error)
            })
        },

        download(file){
            window.open(`/downloadInvoice/${file}`, "_blank");
        },

        back(){
            this.$router.push({
                name: 'orderIndex'
            });
        },

        zoomIn(){
            var pic = document.getElementById("pic");
            var width = pic.clientWidth;
            pic.style.width = width + 100 + "px";
        },

        zoomOut(){
            var pic = document.getElementById("pic");
            var width = pic.clientWidth;
            pic.style.width = width - 100 + "px";
        }
    }
}
</script>

<style scoped>
    .zoomIn {
        top: 16px;
    }
    .zoomOut {
        top: 45px;
    }
    .zoom{
        position: absolute;
        left: 20px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        background: #000000;
        padding: 0px 7px;
        color: white;
        cursor: pointer;
        line-height: 20px;
        text-align: center;
    }
</style>
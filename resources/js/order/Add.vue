<template>
    <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Add Order</h1>
                                <button type="button" v-on:click="back()" class="btn btn-info">Back</button><br><br>
                            </div>
                            <form @submit="create" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Image</label><br>
                                            <input type="file" name="image" @change="uploadImage"><br><br>
                                            <img :src="avatar" alt="image" height="100px" width="100px">
                                            <p class="errors">{{errors.image}}</p>
                                        </div><hr>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Invoice</label><br>
                                            <input type="file" name="invoice" @change="uploadInvoice">
                                            <p class="errors">{{errors.invoice}}</p>
                                        </div><hr>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>Note</label>
                                            <textarea cols="30" rows="5" class="form-control" v-model="note" style="width:50%;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
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
            invoice:'',
            api:'http://127.0.0.1:8000/api/order',
            avatar:'/no-image.png',
            errors:[]
        }
    },

    methods:{
        uploadImage(e){
            this.image = e.target.files[0];
            let render = new FileReader;
            render.readAsDataURL(this.image);
            render.onload = e => {
                this.avatar = e.target.result;
            }
        },

        uploadInvoice(e){
            this.invoice = e.target.files[0];
        },

        async create(e){
            e.preventDefault();
            let currentObj = this;
 
            const config = {
                headers: { 'content-type': 'multipart/form-data' }
            }
 
            let formData = new FormData();
            formData.append('note', this.note);
            formData.append('image', this.image);
            formData.append('invoice', this.invoice);

            await this.axios.post(this.api, formData, config).then(response=>{
                this.$router.push({
                                    name: 'orderIndex'
                                });
            }).catch(error=>{
                this.errors = error.response.data.errors
            })
        },

        back(){
            this.$router.push({
                name: 'orderIndex'
            });
        }
    }
}
</script>
<style>
.errors{
    color: red;
}
</style>
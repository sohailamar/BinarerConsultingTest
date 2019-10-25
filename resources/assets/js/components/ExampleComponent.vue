<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Laravel 5.6 + Vue JS Profile Submission Task</div>

                    <div class="card-body">
                        <div v-if="success != ''" class="alert alert-success" role="alert">
                            {{success}}
                        </div>
                        <form @submit="formSubmit" enctype="multipart/form-data">
                            <p v-if="errors.length">
                                <b>Please correct the following error(s):</b>
                            <ul>
                                <li v-for="error in errors">{{ error }}</li>
                            </ul>
                            </p>
                            <strong>Name:</strong>
                            <input type="text" class="form-control" v-model="name">
                            <strong>Email :</strong>
                            <input type="text" class="form-control" v-model="email">
                            <strong>Phone Number:</strong>
                            <input type="tel" class="form-control" v-model="phone" v-mask="'(###) ###-####'" />
                            <strong>Address :</strong>
                            <input type="text" class="form-control" v-model="address">
                            <strong>Zip Code:</strong>
                            <input type="tel" class="form-control" v-model="zip" v-mask="'#####'" />
                            <strong>Image:</strong>
                            <input type="file" class="form-control" v-on:change="onImageChange">

                            <button class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                name: '',
                errors:[],
                image: '',
                email: '',
                phone: '',
                address: '',
                zip: '',
                success: ''
            };
        },
        methods: {
            onImageChange(e){
                this.image = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                this.errors = [];
                if (!this.name) {
                    this.errors.push("Name required.");
                }
                if (!this.phone) {
                    this.errors.push("phone required.");
                }
                if (!this.address) {
                    this.errors.push("address required.");
                }
                if (!this.zip) {
                    this.errors.push("zip required.");
                }

                if (!this.image) {
                    this.errors.push("image required.");
                }
                if (!this.email) {
                    this.errors.push('Email required.');
                } else if (!this.validEmail(this.email)) {
                    this.errors.push('Valid email required.');
                }

                if (!this.errors.length) {
                    //return true;
                }


                let currentObj = this;

                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }

                let formData = new FormData();
                formData.append('image', this.image);
                formData.append('name', this.name);
                formData.append('phone', this.phone);
                formData.append('zip', this.zip);
                formData.append('address', this.address);
                formData.append('email', this.email);

                axios.post('/submitProfile', formData, config)
                    .then(function (response) {
                        console.log(response);
                        currentObj.success = response.data.msg;
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>
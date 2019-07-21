<template>
    <div class="container">
        <div class="row" v-if="$gate.isVip()">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="/img/vip.png"
                                alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center text-bold">{{ this.form.name }}</h3>

                        <p class="text-muted text-center text-uppercase">{{ this.form.user_group }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Joined</b> <a class="float-right">{{ this.form.created_at | formatDate }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Last Updated</b> <a class="float-right">{{ this.form.updated_at | relativeTime }}</a>
                            </li>
                            <li class="list-group-item" v-html="isSubscribed(this.form.active_subscription)">

                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills ml-3">
                            <li class="nav-item">
                                <h3>Other Details</h3>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="tab-pane active" id="settings">
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">Name</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.name" disabled readonly type="text" class="form-control" id="name" name="name" placeholder="Name" :class="{ 'is-invalid' : form.errors.has('name')}">
                                        </div>
                                        <has-error :form="form" field="name"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="username" class="col-sm-3 control-label">Username</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.username" disabled readonly type="text" class="form-control" id="username" name="username" placeholder="Username" :class="{ 'is-invalid' : form.errors.has('username')}">
                                        </div>
                                        <has-error :form="form" field="username"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-3 control-label">Email</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.email" disabled readonly type="text" class="form-control" id="email" name="email" placeholder="Email" :class="{ 'is-invalid' : form.errors.has('email')}">
                                        </div>
                                        <has-error :form="form" field="email"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="mac_address" class="col-sm-3 control-label">Mac Address</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.mac_address" type="text" class="form-control" id="mac_address" name="mac_address" placeholder="Mac Address" :class="{ 'is-invalid' : form.errors.has('mac_address')}">
                                        </div>
                                        <has-error :form="form" field="mac_address"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="ip_address" class="col-sm-3 control-label">IP Address</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.ip_address" type="text" class="form-control" id="ip_address" name="ip_address" placeholder="IP Address" :class="{ 'is-invalid' : form.errors.has('ip_address')}">
                                        </div>
                                        <has-error :form="form" field="ip_address"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">Password</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.password" type="text" class="form-control" id="password" name="password" placeholder="Password" :class="{ 'is-invalid' : form.errors.has('password')}">
                                        </div>
                                        <has-error :form="form" field="password"></has-error>
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation" class="col-sm-3 control-label">Confirm Password</label>

                                        <div class="col-sm-9">
                                            <input v-model="form.password_confirmation" type="text" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" :class="{ 'is-invalid' : form.errors.has('password_confirmation')}">
                                        </div>
                                        <has-error :form="form" field="password_confirmation"></has-error>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-9">
                                            <button @click.prevent="updateProfile()" type="submit" class="btn btn-success">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <div v-if="!$gate.isVip()">
            <not-found></not-found>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                form : new Form({
                    id : '',
                    name : '',
                    username : '',
                    email : '',
                    password : '',
                    mac_address : '',
                    ip_address : '',
                    active_subscription : false,
                    user_group : '',
                    created_at : '',
                    updated_at : '',
                })
            }
        },
        created() {
            Event.$on('afterEvent', () => {
                this.getUserProfile();
            })
            this.getUserProfile();
        },
        methods: {
            isSubscribed(status){
                if (status === '1') {
                    return "<span class='badge badge-success'>Subscribed</span>"
                }else{
                    return "<span class='badge badge-danger'>Not Subscribed</span>"
                }
            },
            getUserProfile(){
                this.$Progress.start()
                axios.get('api/profile')
                .then(( {data} ) => {
                        this.form.fill(data)
                        this.$Progress.finish()
                    }
                );
            },
            updateProfile(){
                this.$Progress.start()
                  this.form.put('api/profile/')
                    .then((response) => {
                        console.log(response);
                        if(response.data.success){
                            toast.fire({
                                type: 'success',
                                title: 'User updated successfully'
                            })
                            Event.$emit('afterEvent');
                            this.$Progress.finish()
                        }else{
                            toast.fire({
                                type: 'warning',
                                title: response.data.message,
                            })
                            this.$Progress.fail()
                        }
                    })
                    .catch(() => {
                        toast.fire({
                                type: 'warning',
                                title: 'Error on updating user.',
                            })
                        this.$Progress.fail()
                        
                    })
            },
        }
    }
</script>
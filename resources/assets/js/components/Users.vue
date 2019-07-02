<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-list-alt"></i> User List</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#userModal">
                                <i class="fas fa-user-plus"></i> &nbsp; Add New
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>MAC Address</th>
                                    <th>IP Address</th>
                                    <th>Subscription</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>John Doe</td>
                                    <td>sample@sample.com</td>
                                    <td>ASAHSJHAJSHA</td>
                                    <td>192.168.1.1</td>
                                    <td>Subscribed</td>
                                    <td>
                                        <a href="#">
                                            <i class="fas fa-user-edit text-success"></i>
                                        </a>
                                        &nbsp;
                                        <a href="#">
                                            <i class="fas fa-user-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel">Add New User</h5> 
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form role="form" @submit.prevent="createUser">
                    <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input v-model="form.email" type="email" name="email"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input v-model="form.password" type="password" name="password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input v-model="form.confirm_password" type="password" name="confirm_password"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('confirm_password') }">
                                <has-error :form="form" field="confirm_password"></has-error>
                            </div>
                            <div class="form-group">
                                <label>MAC Address</label>
                                <input v-model="form.mac_address" type="text" name="mac_address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('mac_address') }">
                                <has-error :form="form" field="mac_address"></has-error>
                            </div>
                            <div class="form-group">
                                <label>IP Address</label>
                                <input v-model="form.ip_address" type="text" name="ip_address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('ip_address') }">
                                <has-error :form="form" field="ip_address"></has-error>
                            </div>
                            <div class="form-group">
                                <label>IP Address</label>
                                <input v-model="form.ip_address" type="text" name="ip_address"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('ip_address') }">
                                <has-error :form="form" field="ip_address"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="type">Active Subscription</label>
                                <select v-model="form.active_subscription" name="active_subscription" id="active_subscription" class="form-control" :class="{ 'is-invalid' : form.errors.has('active_subscription')}">
                                    <option value="">Select Subscription</option>
                                    <option value="1">Suscribed</option>
                                    <option value="0">Not Subscribed</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="type">User Group</label>
                                <select v-model="form.user_group" name="user_group" id="user_group" class="form-control" :class="{ 'is-invalid' : form.errors.has('user_group')}">
                                    <option value="">Select Subscription</option>
                                    <option value="1">Suscribed</option>
                                    <option value="0">Not Subscribed</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form : new Form({
                    name : '',
                    email : '',
                    password : '',
                    mac_address : '',
                    ip_address : '',
                    active_subscription : false,
                    user_group : '',
                })
            }
        },
        methods: {
            createUser() {
                // Submit the form via a POST request
                this.form.post('api/user');
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-list-alt"></i> User List</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click.prevent="newUserModal">
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
                                <tr v-for="user in users.data" :key="user.id">
                                    <td>{{ user.name }} <span class="ml-3" v-html="getUserGroup(user.user_group)"></span> </td>
                                    <td>{{ user.email }}</td>
                                    <td>{{ user.mac_address }}</td>
                                    <td>{{ user.ip_address }}</td>
                                    <td v-html="isSubscribed(user.active_subscription)"></td>
                                    <td>
                                        <a href="#" @click="editUserModal(user)">
                                            <i class="fas fa-user-edit text-success"></i>
                                        </a>
                                        &nbsp;
                                        <a href="#" @click="deleteUser(user.id)">
                                            <i class="fas fa-user-times text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination :data="users" @pagination-change-page="getResults">
                            <span slot="prev-nav">&lt; Previous</span>
                            <span slot="next-nav">Next &gt;</span>
                        </pagination>
                    </div>
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
                        <h5 v-show="!editUser" class="modal-title" id="userModalLabel">Add New User</h5>
                        <h5 v-show="editUser" class="modal-title" id="userModalLabel">Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="userForm" role="form" @submit.prevent="editUser ? updateUser() : createUser()">
                    <div class="modal-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input v-model="form.name" type="text" name="name"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input v-model="form.username" type="text" name="username"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('username') }">
                                <has-error :form="form" field="username"></has-error>
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
                                <input v-model="form.password_confirmation" type="password" name="password_confirmation"
                                       class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                <has-error :form="form" field="password_confirmation"></has-error>
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
                                <label for="type">Active Subscription</label>
                                <select v-model="form.active_subscription" name="c" id="active_subscription" class="form-control" :class="{ 'is-invalid' : form.errors.has('active_subscription')}">
                                    <option value="">Select Subscription</option>
                                    <option value="1">Suscribed</option>
                                    <option value="0">Not Subscribed</option>
                                </select>
                                <has-error :form="form" field="active_subscription"></has-error>
                            </div>
                            <div class="form-group">
                                <label for="type">User Group</label>
                                <select v-model="form.user_group" name="user_group" id="user_group" class="form-control" :class="{ 'is-invalid' : form.errors.has('user_group')}">
                                    <option value="">Select Subscription</option>
                                    <option value="admin">Admin</option>
                                    <option value="support">Support</option>
                                    <option value="vip">VIP</option>
                                </select>
                                <has-error :form="form" field="user_group"></has-error>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="editUser" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editUser" type="submit" class="btn btn-primary">Save changes</button>
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
                editUser : false,
                users : {},
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
                })
            }
        },
        methods: {
            // Our method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            updateUser(){
                this.$Progress.start()
                  this.form.put('api/user/' + this.form.id)
                    .then(() => {
                        $('#userModal').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'User updated successfully'
                        })
                        Event.$emit('afterEvent');
                        this.$Progress.finish()
                    })
                    .catch(() => {
                        toast.fire({
                            type: 'warning',
                            title: 'Update user failed'
                        })
                        this.$Progress.fail()
                    })
            },
            newUserModal(){
                this.editUser = false;
                this.form.reset();
                this.form.clear();
                $('#userModal').modal('show')
            },
            editUserModal(user){
                this.editUser = true;
                this.form.reset();
                this.form.clear();
                $('#userModal').modal('show')
                this.form.fill(user)
            },
            deleteUser(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    if (result.value) {
                        this.$Progress.start()
                        this.form.delete('api/user/' + id)
                            .then(() => {
                                this.$Progress.finish()
                                Event.$emit('afterEvent');
                                swal.fire(
                                    'Deleted!',
                                    'User has been deleted.',
                                    'success'
                                )
                            })
                            .catch(() => {
                                this.$Progress.fail()
                                swal.fire(
                                    'Failed!',
                                    'There is an issue deleting the user.',
                                    'warning'
                                )
                            });
                    }
                })
            },
            getUserGroup(group){
                if (group == 'admin') {
                    return "<span class='badge badge-admin'>Admin</span>"
                }else if(group == 'support'){
                    return "<span class='badge badge-support'>Support</span>"
                }else{
                    return "<span class='badge badge-vip'>VIP</span>"
                }
            },
            isSubscribed(status){
                if (status === '1') {
                    return "<span class='badge badge-success'>Subscribed</span>"
                }else{
                    return "<span class='badge badge-danger'>Not Subscribed</span>"
                }
            },
            loadUsers(){
                axios.get('api/user')
                .then(
                    ({ data }) => (this.users = data)
                );
            },
            createUser() {
                this.$Progress.start()
                // Submit the form via a POST request
                this.form.post('api/user')
                    .then(() => {
                        this.$Progress.finish()
                        Event.$emit('afterEvent');
                        $('#userModal').modal('hide')
                        toast.fire({
                            type: 'success',
                            title: 'User added successfully'
                        })
                    })
                    .catch(() => {
                        this.$Progress.fail()
                    });
            }
        },
        created() {
            Event.$on('afterEvent', () => {
                this.loadUsers();
            })
            this.loadUsers();
        }
    }
</script>
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
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
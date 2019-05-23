<div class="col-md-12">
    <div class="message">

    </div>
    <div id="general-actions" class=" row margin-btm">
        <div class="col-md-12">
            <div class="pull-right">
                <button class="btn btn-primary new-btn userButtonShow" >New User</button>
            </div>
            <div class="pull-left">
                <label>Type to filter:</label>
                <input type='text' id='inputSearch'/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="display-data" class="margin-btm">
                <div class="no-data alert alert-info">
                    <strong></strong>
                    <span>Loading users list</span>
                </div>
                <div id='error-alert'>
                </div>
                <div class="ppal-data hidden">
                    <table id='users-table'  class="table table-stripped table-data">
                        <tr class="table-headers">
                            <th>Id</th>
                            <th>Username</th>
                            <th>User Picture</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="table-row-actions">
                            <td class="row-actions-template hidden">
                                <button class="btn btn-primary edit-btn">Edit</button>
                                <button class="btn btn-danger delete-btn">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="data-editor" class="margin-btm hidden">
                <div class="form-horizontal" role="form">
                    <input type="hidden" class="update-input" value="">
                    <input type="hidden" class="user_entry_type" value="">
                    <div class="form-group">
                        <label for="inputUsername" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="username" id="inputUsername" placeholder="Username">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Change Password</label>
                        <div class="col-sm-10">
                            <input class="form-control text-left" type="checkbox" autocomplete="off" value="change_password" id="change_password_checkbox">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="Password" id="inputPassword" disabled="disabled" placeholder="Entering a Password will trigger an email to the user with the credentials">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="Email" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputUserPicture" class="col-sm-2 control-label">User Picture</label>
                        <div class="col-sm-6">
                            <input type="file" name="UserPicture" id="inputUserPicture">
                        </div>
                        <div class="col-sm-4" style="display:none;">
                            <img width="100" height="100" src="" class="inputUserPictureImg">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputType" class="col-sm-2 control-label">Type</label>
                        <div class="col-sm-10">
                            <select type="button" class="form-control grab" data-toggle="dropdown" name="Type" id="inputType" >
                                <option value="Admin" selected>Admin</option>
                                <option value="Integrator">Integrator</option>
                                <option value="End Customer">End Customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputRelatedTo" class="col-sm-2 control-label">Related to</label>
                        <div class="col-sm-10">
                            <select type="button" class="form-control grab disabled" data-toggle="dropdown" name="RelatedTo" id="inputRelatedTo" >
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button  class="btn btn-primary update-btn">Update</button>
                            <button  class="btn btn-primary save-btn">Save</button>
                            <button  class="btn btn-danger pull-right cancel-btn">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">User Delete</h4>
                </div>
                <div class="modal-body">
                    <!--p>Deleting a Volume Unit will also delete related volume units</p-->
                    <p>This action cannot be undone, proceed anyway?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger modal-delete-btn">Delete</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal fade" id="modal-error">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Error</h4>
                </div>
                <div class="modal-body">
                    <!--p>Deleting a Volume Unit will also delete related volume units</p-->
                    <p>Something went wrong. Have you filled out all the fields?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/users_manager.js"></script>
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/select2.min.js"></script>
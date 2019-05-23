<div class="col-md-12">
    <div class="message">

    </div>
    <div id="general-actions" class=" row margin-btm">
        <div class="col-md-12">
            <div class="pull-right">
                <button class="btn btn-primary new-btn" >New Endcustomer</button>
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
                    <span>Loading Endcustomer list</span>
                </div>
                <div id='error-alert'>
                </div>
                <div class="ppal-data hidden">
                    <table id='Endcustomer-table'  class="table table-stripped table-data">
                        <tr class="table-headers">
                            <th>Id</th>
                            <th>Name</th>
							<th>Endcustomer Logo</th>
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
                    <input type="hidden" class="Endcustomer_entry_type" value="">
                    <div class="form-group">
                        <label for="inputName" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="Name" id="inputName" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="associatedIntegrator" class="col-sm-2 control-label">Associated Integrator</label>
                        <div class="col-sm-10">
                            <select class="form-control grab" name="associatedIntegrator" id="associatedIntegrator">
                            </select>
                        </div>
                    </div>
					<div class="form-group">
                        <label for="inputEndcustomerLogo" class="col-sm-2 control-label">Endcustomer Logo</label>
                        <div class="col-sm-6">
                            <input type="file" name="EndcustomerLogo" id="inputEndcustomerLogo">
                        </div>
                        <div class="col-sm-4" style="display:none;">
                            <img width="200" src="" class="inputEndcustomerPictureImg">
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
                    <h4 class="modal-title">Endcustomer Delete</h4>
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
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/Endcustomer-Controller.js"></script>
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/select2.min.js"></script>
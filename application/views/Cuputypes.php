<div class="col-md-12">
    <div class="message">

    </div>
    <div id="general-actions" class=" row margin-btm">
        <div class="col-md-12">
            <!--<div class="pull-right">
                <button class="btn btn-primary new-btn disabled" >New CUPU unit</button>
            </div>-->

            <div class="pull-left">
                <label>Type to filter:</label>
                <input type='text' id='inputSearch'/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" id="checking-unitsTypes"><div class="alert alert-info">Checking for existing Units Types...</div></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="display-data" class="margin-btm">
                <div class="no-data alert alert-info">
                    <strong></strong>
                    <span>Data not available!</span>
                </div>
                <div class="ppal-data hidden">
                    <table id='unitsTypes-table' class="table table-stripped table-data">
                        <tr class="table-headers">
                            <th>HardwareCode</th>
                            <th>HardwareName</th>
                            <th>MinVPV</th>
							<th>MaxVPV</th>
							<th>MaxLPV</th>
							<th>MaxPVP</th>
							<th>Maxlcharge</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="table-row-actions">
                            <td class="row-actions-template hidden">
                                <!--<button class="btn btn-primary edit-btn">Edit</button>
                                <button class="btn btn-danger delete-btn">Delete</button>-->
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="data-editor" class="margin-btm hidden">

                <div id="empty-fields" class="alert alert-danger">You have to fill all fields in order to save this!</div>

                <div class="form-horizontal" role="form">
                    <input type="hidden" class="update-input" value="">
                    <div class="form-group">
                        <label for="inputHardwareCode" class="col-sm-2 control-label">HardwareCode</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control grab required" name="HardwareCode" id="inputHardwareCode" placeholder="HardwareCode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSerialNo" class="col-sm-2 control-label">HardwareName</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="HardwareName" id="HardwareName" placeholder="HardwareName" >
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
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Container Delete</h4>
                    </div>
                    <div class="modal-body">
                        <p>This action cannot be undone, proceed?</p>
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
                        <p>Something went wrong. Have you filled out all the fields?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Continue</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </div>
    <script type="text/javascript" src="<? echo base_url(); ?>assets/js/highcharts.js"></script>
    <script type="text/javascript" src="<?echo base_url(); ?>assets/js/Cuputypes-Controller.js"></script>

<div class="col-md-12">
    <div class="row">
        <div class="col-sm-4" id="checking-units"><div class="alert alert-info">Checking for existing Units...</div></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="display-data" class="margin-btm">
                <div class="no-data alert alert-info">
                    <strong></strong>
                    <span>There are no Units to list!</span>
                </div>
                <div class="ppal-data hidden">
                    <table id='units-table' class="table table-stripped table-data">
                        <tr class="table-headers">
                            <th>SerialNo</th>
                            <th>Total Operating Hours</th>
                            <th>Total No Of Activations</th>
                            <th>ErrorCode</th>
                        </tr>
                    </table>
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

        <div class="modal fade" id="modal-show-log">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Unit Measurements Log</h4>
                    </div>
                    <div class="modal-body">
                        <div id="log-chart-Unit"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script type="text/javascript" src="<? echo base_url(); ?>assets/js/Predective-Controller.js"></script>
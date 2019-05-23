<div class="col-md-12">
    <div class="message">

    </div>
    <div id="general-actions" class=" row margin-btm">
        <div class="col-md-12">
            <div class="pull-right">
              <!--  <button class="btn btn-primary new-btn disabled" >New CUPU unit</button>-->
            </div>

            <!--<div class="pull-left">
                <label>Type to filter:</label>
                <input type='text' id='inputSearch'/>
            </div>-->
        </div>
    </div>
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
                            <th>HardwareCode</th>
                            <th>Hardware Name</th>
                            <th>Location</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="table-row-actions">
                            <td class="row-actions-template hidden">
                                <button class="btn btn-primary show-log-btn">Log</button>
                                <button class="btn btn-primary edit-btn">Edit</button>
								<button class="btn btn-primary unit_statistics">Statistics</button>
                                <button class="btn btn-danger delete-btn">Delete</button>
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
                        <label for="inputSerialNo" class="col-sm-2 control-label">SerialNo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grab" name="SerialNo" id="inputSerialNo" placeholder="SerialNo" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputHardwareCode" class="col-sm-2 control-label">Hardware Code</label>
                        <div class="col-sm-10">
                            <input type="text" id="inputHardwareCode" class="form-control grab required" name="HardwareCode" placeholder="Hardware Code">
                            <!--<input type="hidden" class="form-control grab required" name="HardwareCode" id="inputHardwareCode">-->
                        </div>
                    </div>
                    <div class="form-group" id="inputHardwareNameDiv">
                        <label for="inputHardwareName" class="col-sm-2 control-label">Hardware Name</label>
                        <div class="col-sm-10">
                            <input type="text" id="inputHardwareName" class="form-control grab required" name="HardwareName" placeholder="Hardware Name">
                        </div>
                    </div>
                    <div class="form-group" id="aircompressortimeoutdiv" style="display:none;">
                        <label for="aircompressortimeout" class="col-sm-2 control-label">Air compressor Timeout</label>
                        <div class="col-sm-2">
                            <select type="button" class="form-control grab" data-toggle="dropdown" name="AirCompressorTimeout" id="aircompressortimeout">
                                <?php
                                    for($x = 1; $x <= 255; $x++){
                                        ?>
                                        <option <?php if($x == 10){ echo 'selected="selected"';} ?> value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                        <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputLat" class="col-sm-2 control-label">GPS Coordinates</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control grab required" name="Lat" id="inputLat" placeholder="0.00">
                        </div>
                        <div>
                            <label class="col-sm-1 control-label">,</label>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control grab required" name="Lng" id="inputLng" placeholder="0.00">
                        </div>
                    </div>
					<div class="form-group" id="assignEndcustomerDiv">
                        <label for="IntegratorNo" class="col-sm-2 control-label">Assign to</label>
                        <div class="col-sm-5" id="Integrator_div">
                            <select type="button" class="form-control grab" data-toggle="dropdown" name="IntegratorNo" id="IntegratorNo">
                                <option value="">Select Integrator</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <select type="button" class="form-control grab" data-toggle="dropdown" name="EndCustomerNo" id="EndCustomerNo">
                                <option value="">Select End Customer</option>
                            </select>
                        </div>
                    </div>
					<div class="form-group">
						<label for="Available_Sounds" class="col-sm-2 control-label">Available Sounds</label>
                        <div class="col-sm-3" id="Available_Sounds">
							<div class="subject-info-box-1">
							  <select multiple="multiple" id='lstBox1' class="form-control">
								
							  </select>
							</div>
						</div>
                        <div class="col-sm-1">
							<div class="subject-info-arrows text-center">
							 <!-- <input type="button" id="btnAllRight" value=">>" class="btn btn-default" /><br />-->
							  <input type="button" id="btnRight" value=">" class="btn btn-default" /><br />
							  <input type="button" id="btnLeft" value="<" class="btn btn-default" /><br />
							  <!-- <input type="button" id="btnAllLeft" value="<<" class="btn btn-default" />-->
							</div>
						</div>
                        <label for="Playlist" class="col-sm-1 control-label">Playlist</label>
                        <div class="col-sm-5" id="Playlist">
							<div class="subject-info-box-2">
							  <select multiple="multiple" id='lstBox2' class="form-control">
								
							  </select>
							</div>
						</div>
					</div>
                    <div class="form-group">
                        <label for="inputAudioOutVolume" class="col-sm-2 control-label">Audio Out Volume</label>
                        <div class="col-sm-2">
						
                            <select type="button" class="form-control grab" data-toggle="dropdown" name="AudioOutVolume" id="AudioOutVolume">
                                <?php
                                    for($x = 0; $x <= 255; $x++){
                                        ?>
                                        <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                        <?php 
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputNotes" class="col-sm-2 control-label">Notes</label>
                        <div class="col-sm-10">
                            <textarea id="inputNotes" class="form-control grab required" name="Note" placeholder="Notes"> </textarea>
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
				
				<div id="wrapper" class="chart_wrapper">
					 <div class="chart">
						<table id="data-table" border="1" cellpadding="10" cellspacing="0">
						   <thead>
							  <tr>
								 <td>&nbsp;</td>
								 <th scope="col"></th>
							  </tr>
						   </thead>
						   <tbody id="data-table_body">
							  
						   </tbody>
						</table>
					</div>
                <button  class="btn btn-danger pull-right back-btn">Back</button>
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
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/style_chart.css">
    <link rel="stylesheet" href="<? echo base_url(); ?>assets/css/bar.css">
    <script type="text/javascript" src="<? echo base_url(); ?>assets/js/highcharts.js"></script>
	<script type="text/javascript" src="<? echo base_url(); ?>assets/js/graph.js"></script>
    <script type="text/javascript" src="<? echo base_url(); ?>assets/js/Unit-Controller.js"></script>

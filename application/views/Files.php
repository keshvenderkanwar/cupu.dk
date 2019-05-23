
<div class="col-md-12">
    <div class="message">

    </div>
    <div id="general-actions" class=" row margin-btm">
        <div class="col-md-12">
            <div class="pull-right">
                <button class="btn btn-primary new-btn disabled" >Upload Sound</button>
            </div>

            <div class="pull-left">
                <label>Type to filter:</label>
                <input type='text' id='inputSearch'/>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4" id="checking-files"><div class="alert alert-info">Checking for existing files...</div></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="display-data" class="margin-btm">
                <div class="no-data alert alert-info">
                    <strong></strong>
                    <span>There are no files to list!</span>
                </div>
                <div class="ppal-data hidden">
                    <table id='files-table' class="table table-stripped table-data">
                        <tr class="table-headers">
                            <th>FileNo</th>
                            <th>Description</th>
                            <th>FileName</th>
                            <th>Actions</th>
                        </tr>
                        <tr class="table-row-actions">
                            <td class="row-actions-template hidden">
                                <button class="btn btn-primary show-audio-btn">Play</button>
                                <!--<button class="btn btn-primary edit-btn">Edit</button>-->
                                <button class="btn btn-danger delete-btn">Delete</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div id="data-editor" class="margin-btm hidden">

                <div id="empty-fields" class="alert alert-danger">You have to fill all fields in order to save this!</div>

                <div class="form-horizontal" role="form" enctype="multipart/form-data">
                    <input type="hidden" class="update-input" value="">
                    <!--                    <div class="form-group">
                                            <label for="inputFileTitle" class="col-sm-2 control-label">FileTitle</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control grab required" name="FileTitle" id="inputFileTitle" placeholder="FileTitle">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputFileName" class="col-sm-2 control-label">FileName</label>
                                            <div class="col-sm-10">
                                                <input type="file" name="FileName" id="FileName">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button  class="btn btn-primary update-btn">Update</button>
                                                <button  class="btn btn-primary save-btn">Save</button>
                                                <button  class="btn btn-danger pull-right cancel-btn">Cancel</button>
                                            </div>
                                        </div>-->
                    <form id="upload_form" action="" method="post" enctype="multipart/form-data" target="upload_target" class="form-group">
							<p id="f1_upload_process">Loading...<br/><img src="assets/images/loader.gif" /><br/></p>
							<div id="f1_upload_form" align="center"><br/>
								<div class="form-group">
									<label for="inputFileTitle" class="col-sm-2 control-label">File Title: </label> 
									<div class="col-sm-6">
											<input id="inputFileTitle" name="Description" type="text" class="form-control grab" required />
									</div>
								</div>
								<div class="form-group">
									<label for="inputFile" class="col-sm-2 control-label">File:  </label>
									<div class="col-sm-6">
											<input id ="inputFile" name="myfile" type="file" class="" required/>
									</div>
								</div>
								<div class="form-group">
									<label for="inputfileEndCust" class="col-sm-2 control-label">End Customer</label>
									<div class="col-sm-6">
										<select type="button" class="form-control grab disabled" data-toggle="dropdown" name="EndCustomerNo" id="inputfileEndCust" required>
										</select>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="submit" name="submitBtn" class="btn btn-primary sbtn" value="Upload" />
									</div>
								</div>
							</div>
                        <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal-delete">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">File Delete</h4>
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

        <div class="modal fade" id="modal-show-audio">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title">Play audio</h4>
                    </div>
                    <div class="modal-body" align="center">
                        <audio id ="modal-audio-player" controls autoplay>
                            <source src="" type="audio/mpeg">
                        </audio>
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
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/highcharts.js"></script>
<script type="text/javascript" src="<? echo base_url(); ?>assets/js/File-Controller.js"></script>
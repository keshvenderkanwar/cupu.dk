
<div align="center">
    <img src=<?php echo base_url(); ?>assets/images/AKJI_logo_transparent.gif height="25%" width="25%">
    <h1>CUPU Cloud Login</h1>
    <?php echo validation_errors(); ?>
    <?php echo form_open('verifylogin'); ?>
    <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" size="50" id="username" name="username"/>
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" size="50" id="password" name="password"/>
    </div>
    <div>
        <input type="submit" value="Login" class="btn btn-primary"/>
    </div>
</form>
</div>
</body>
</html>
<div class="row clearfix">
    <div class="col-md-12 column">
        <nav class="navbar navbar-default" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span><span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home"><img src=<?php echo base_url(); ?>assets/images/AKJI_logo_transparent.gif height="200%"></a>
                <!--<a class="navbar-brand" href="home" > AKJ Inventions </a>-->
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                        <li <? if (isset($section) AND $section=='units') echo 'class="active"'; ?>>
                            <a href="<?echo base_url();?>units">Units</a>
                        </li>
                        <li <? if (isset($section) AND $section=='map') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>map">Map</a>
                        </li>
                        <li <? if (isset($section) AND $section=='files') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>files">Sounds</a>
                        </li>
                        <li style="display:none;" class="adminShow" <? if (isset($section) AND $section=='cuputypes') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>cuputypes">CUPU Types</a>
                        </li>
                        <li style="display:none;" class="adminShow" <? if (isset($section) AND $section=='Integrators') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>Integrator">Integrators</a>
                        </li>
                        <li style="display:none;" class="adminShow integratorShow" <? if (isset($section) AND $section=='Endcustomer') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>Endcustomer">End Customer</a>
                        </li>
                        <li <? if (isset($section) AND $section=='users') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>users">Users</a>
                        </li>
                        <li <? if (isset($section) AND $section=='predictive_maintenance') echo 'class="active"'; ?> >
                            <a href="<?echo base_url();?>predictive_maintenance">Predictive Maintenance</a>
                        </li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="" href="<?php echo base_url(); ?>home/logout">Log out</a>
                    </li>

                </ul>
            </div>

        </nav>
    </div>
</div>
<div class="row">


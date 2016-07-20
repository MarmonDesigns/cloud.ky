
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            <div class="headline style-3">

                <h5><?php $query->printText('error-number')?></h5>
                <h2><?php $query->printText('error-message')?></h2>
                <p><?php $query->printText('error-description')?></p>

            </div><!-- headline -->

        </div><!-- col -->
    </div><!-- row -->
</div><!-- ontainer -->

<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">

            <p class="text-primary text-center"><em><?php $query->printText('additional-info')?></em></p>

        </div><!-- col -->
    </div><!-- row -->
</div><!-- ontainer -->

<br><br>

<div class="container">
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">

            <p class="text-center"><a class="btn btn-default" href="<?php $query->printText('button-link')?>"><?php $query->printText('button-title')?><i class="fa fa-arrow-right"></i></a></p>

        </div><!-- col -->
    </div><!-- row -->
</div><!-- ontainer -->
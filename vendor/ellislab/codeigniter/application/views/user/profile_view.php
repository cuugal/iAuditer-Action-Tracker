<?php defined('BASEPATH') OR exit('No direct script access allowed');?>


<div class="row">
    <div class="col-lg-12">
        <h1>User Profile</h1>


        <table class="table table-striped table-bordered table-hover" style="border: 2px solid #ddd" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th width="250px"></th>

                <th>&nbsp;</th>

            </tr>
            </thead>
            <tbody>


                <tr>
                    <td><b>Accountable Areas:</b></td>
                    <td><?=implode(',', $aoa);?></td>
                </tr>
                <tr>
                    <td><b>Responsible Areas:</b></td>
                    <td><?=implode(',', $rp);?></td>
                </tr>
            </tbody>
            <tfoot>
            <tr>
                <th></th>

                <th>&nbsp;</th>
            </tr>
            </tfoot>
        </table>

    </div>
</div>

